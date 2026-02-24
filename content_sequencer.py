import mysql.connector
import sys

def get_recommendation():
    try:
        # Catch learner_id from PHP, default to 1
        learner_id = sys.argv[1] if len(sys.argv) > 1 else 1
        
        db = mysql.connector.connect(
            host="localhost",
            user="root",
            password="root",
            database="astraal_lxp"
        )
        cursor = db.cursor(dictionary=True)

        # 1. Fetch 360 profile to determine media preference
        cursor.execute("SELECT overall_engagement FROM engagement_scores WHERE learner_id=%s", (learner_id,))
        profile = cursor.fetchone()
        score = profile['overall_engagement'] if profile else 0.5

        # 2. Get the next unit
        cursor.execute("SELECT * FROM content_units LIMIT 1")
        unit = cursor.fetchone()

        if unit:
            # 3. Adaptive Content Selection based on score
            if score > 0.7:
                path = unit['video_path'] # Visual preference
            elif score < 0.3:
                path = unit['audio_path'] # Auditory preference
            else:
                path = unit['pdf_path']   # Reading preference
            
            print(f"{unit['unit_title']}|{path}")
        else:
            print("Introduction|default.pdf")

    except Exception as e:
        print(f"Error|{str(e)}")
    finally:
        if 'db' in locals() and db.is_connected():
            db.close()

if __name__ == "__main__":
    get_recommendation()