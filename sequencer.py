import mysql.connector
import sys
from datetime import datetime

# 1. DATABASE CONNECTION (UwAmp Default)
try:
   # Inside sequencer.py
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root",
    database="astraal_lxp" # MUST be astraal_lxp based on your screenshot
)
   cursor = db.cursor(dictionary=True)
except Exception as e:
    print(f"Connection Error: {e}")
    sys.exit()

# Get Learner ID from PHP exec command
learner_id = sys.argv[1] if len(sys.argv) > 1 else 1

def run_rl_sequencer():
    # A. Check Governance Settings
    cursor.execute("SELECT mode FROM sequencing_settings WHERE course_id = 1")
    setting = cursor.fetchone()
    mode = setting['mode'] if setting else 'Personalized'

    # B. Fetch Units and Rewards
    cursor.execute("SELECT * FROM content_units")
    units = cursor.fetchall()
    
    cursor.execute("SELECT unit_id, reward_value FROM sequencing_rewards WHERE learner_id = %s", (learner_id,))
    rewards = {r['unit_id']: r['reward_value'] for r in cursor.fetchall()}

    # C. RL Scoring Logic (Section 2.3)
    # Reward formula: reward = (completion * 0.5) + (score * 0.5)
    def calculate_priority(unit):
        base_diff = unit['difficulty_level']
        reward = rewards.get(unit['unit_id'], 0)
        # Higher score = Lower priority (User already knows this)
        # Higher difficulty + Low Reward = Top Priority (User needs reinforcement)
        return base_diff - (reward * 0.6)

    if mode == 'Standard':
        ranked = sorted(units, key=lambda x: x['unit_id'])
        msg = "Standard Sequence applied by Faculty."
    else:
        # RL / ML Ranking
        ranked = sorted(units, key=calculate_priority, reverse=True)
        msg = "RL-Optimized: Reinforcement path active."

    # D. Save New Sequence & Audit Log
    cursor.execute("SELECT unit_id, rank_position FROM personalized_sequence WHERE learner_id = %s", (learner_id,))
    old_ranks = {row['unit_id']: row['rank_position'] for row in cursor.fetchall()}

    cursor.execute("DELETE FROM personalized_sequence WHERE learner_id = %s", (learner_id,))

    for i, unit in enumerate(ranked):
        new_pos = i + 1
        old_pos = old_ranks.get(unit['unit_id'], 0)
        
        cursor.execute("""
            INSERT INTO personalized_sequence (learner_id, course_id, unit_id, rank_position, calculated_on) 
            VALUES (%s, 1, %s, %s, NOW())
        """, (learner_id, unit['unit_id'], new_pos))
        
        # Log changes for Faculty Audit
        if old_pos != 0 and old_pos != new_pos:
            cursor.execute("""
                INSERT INTO sequencing_audit_log (learner_id, unit_id, change_reason, old_position, new_position, logged_at) 
                VALUES (%s, %s, %s, %s, %s, NOW())
            """, (learner_id, unit['unit_id'], msg, old_pos, new_pos))

    db.commit()
    db.close()

if __name__ == "__main__":
    run_rl_sequencer()