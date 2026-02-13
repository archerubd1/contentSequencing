import mysql.connector

db = mysql.connector.connect(
    host="localhost",
    user="db_user",
    password="db_password",
    database="astraal_lxp"
)

cursor = db.cursor(dictionary=True)

epsilon = 0.1

cursor.execute("""
SELECT unit_id, AVG(reward_value) as avg_reward
FROM sequencing_rewards
GROUP BY unit_id
""")

rows = cursor.fetchall()

# Placeholder logic for reinforcement adjustment
for row in rows:
    adjusted = row['avg_reward'] * (1 - epsilon)
    # Could store multiplier per unit

db.close()
