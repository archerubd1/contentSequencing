import sys
import mysql.connector
import pickle
import pandas as pd

learner_id = int(sys.argv[1])
course_id = int(sys.argv[2])

model = pickle.load(open("sequencer.pkl", "rb"))

db = mysql.connector.connect(
    host="localhost",
    user="db_user",
    password="db_password",
    database="astraal_lxp"
)

cursor = db.cursor(dictionary=True)

# Fetch engagement weight
cursor.execute("""
SELECT engagement_weight, mode
FROM sequencing_settings
WHERE course_id=%s
""", (course_id,))

settings = cursor.fetchone()
engagement_weight = settings['engagement_weight'] if settings else 0.5

# Fetch units
cursor.execute("""
SELECT * FROM content_units
WHERE course_id=%s
""", (course_id,))

units = cursor.fetchall()

feature_rows = []
unit_ids = []

for unit in units:

    cursor.execute("""
    SELECT * FROM learner_content_activity
    WHERE learner_id=%s AND unit_id=%s
    """, (learner_id, unit['unit_id']))

    activity = cursor.fetchone()

    prior_score = activity['assessment_score'] if activity else 0
    time_ratio = (activity['time_spent'] / unit['estimated_time']) if activity else 1
    difficulty_gap = abs(unit['difficulty_level'] - prior_score)
    prerequisite_done = 1

    engagement_signal = 0.5  # fallback baseline

    feature_rows.append([
        prior_score,
        time_ratio,
        difficulty_gap,
        prerequisite_done,
        engagement_signal * engagement_weight
    ])

    unit_ids.append(unit['unit_id'])

df = pd.DataFrame(feature_rows)

scores = model.predict_proba(df)[:, 1]

ranked = sorted(zip(unit_ids, scores), key=lambda x: x[1], reverse=True)

cursor.execute("""
DELETE FROM personalized_sequence
WHERE learner_id=%s AND course_id=%s
""", (learner_id, course_id))

for idx, (unit_id, score) in enumerate(ranked):
    cursor.execute("""
    INSERT INTO personalized_sequence
    VALUES (%s,%s,%s,%s,NOW())
    """, (learner_id, course_id, unit_id, idx + 1))

db.commit()
db.close()
