CREATE TABLE content_units (
    unit_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    unit_title VARCHAR(255),
    difficulty_level FLOAT,
    prerequisite_unit INT NULL,
    estimated_time INT
);

CREATE TABLE learner_content_activity (
    learner_id INT,
    unit_id INT,
    completion_status BOOLEAN,
    time_spent INT,
    assessment_score FLOAT,
    last_access DATETIME
);

CREATE TABLE personalized_sequence (
    learner_id INT,
    course_id INT,
    unit_id INT,
    rank_position INT,
    calculated_on DATETIME
);

CREATE TABLE sequencing_settings (
    course_id INT PRIMARY KEY,
    mode VARCHAR(50),
    engagement_weight FLOAT DEFAULT 0.5,
    rl_enabled BOOLEAN DEFAULT FALSE,
    last_updated DATETIME
);

CREATE TABLE sequencing_rewards (
    learner_id INT,
    unit_id INT,
    reward_value FLOAT,
    recorded_on DATETIME
);
