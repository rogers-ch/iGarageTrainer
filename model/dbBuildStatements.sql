CREATE TABLE igarage_user (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
	username VARCHAR(100) UNIQUE,
    password VARCHAR(100),
    fitness_level VARCHAR(100)

) ENGINE=InnoDB;

CREATE TABLE workout (
    workout_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_time DATETIME DEFAULT NOW(),
    FOREIGN KEY(user_id) REFERENCES igarage_user(user_id)

) ENGINE=InnoDB;

CREATE TABLE exercise (
    exercise_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    exercise_name VARCHAR(100) UNIQUE,
    description TEXT,
    difficulty INT,
    muscle_group VARCHAR(100)

) ENGINE=InnoDB;

CREATE TABLE equipment (
    equip_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    equip_name VARCHAR(100) UNIQUE

) ENGINE=InnoDB;

CREATE TABLE workout_line (
    workout_id INT NOT NULL,
    exercise_id INT NOT NULL,
    workout_order INT NOT NULL,
    primary key(workout_id, exercise_id, workout_order),
    FOREIGN KEY (workout_id) REFERENCES workout(workout_id),
    FOREIGN KEY (exercise_id) REFERENCES exercise(exercise_id)

) ENGINE=InnoDB;

CREATE TABLE req_equip_line (
    exercise_id INT NOT NULL,
    equip_id INT NOT NULL,
    primary key(exercise_id, equip_id),
    FOREIGN KEY (exercise_id) REFERENCES exercise(exercise_id),
    FOREIGN KEY (equip_id) REFERENCES equipment(equip_id)

) ENGINE=InnoDB;

CREATE TABLE equipment_line (
    user_id INT NOT NULL,
    equip_id INT NOT NULL,
    primary key(user_id, equip_id),
    FOREIGN KEY (user_id) REFERENCES igarage_user(user_id),
    FOREIGN KEY (equip_id) REFERENCES equipment(equip_id)

) ENGINE=InnoDB;

-- Insert statement for igarage_user table
INSERT INTO igarage_user (user_id, firstName, lastName, username, password, fitness_level)
VALUES (NULL, 'Admin', 'Admin', 'Admin', '@dm1n', 'advanced');


-- Insert statement for equipment table
INSERT INTO equipment (equip_id, equip_name)
VALUES 	(NULL, 'dumbbells'),
        (NULL, 'kettlebells'),
        (NULL, 'resistance bands'),
        (NULL, 'chairs'),
        (NULL, 'pull-up bar'),
        (NULL, 'no equipment');

-- Insert statement for exercise table
INSERT INTO exercise (exercise_id, exercise_name, description, difficulty, muscle_group)
VALUES
(NULL, 'Bicep curls', 'Stand holding a dumbbell in each hand with your arms hanging by your sides. Ensure your elbows are close to your torso and your palms facing forward. Keeping your upper arms stationary, exhale as you curl the weights up to shoulder level while contracting your biceps.', 1, 'biceps'),
(NULL, 'Triceps Dips', 'Slide off the front of the bench with your legs extended out in front of you. Straighten your arms, keeping a little bend in your elbows to keep tension on your triceps and off your elbow joints. Slowly bend your elbows to lower your body toward the floor until your elbows are at about a 90-degree angle.', 2, 'triceps'),
(NULL, 'Traditional Push-ups', 'Place your hands shoulder-width apart. Bend your arms lowering your chest to the floor but keeping your body straight. Once your chest is near to the floor. Push yourself back to the start position.', 2, 'chest'),
(NULL, 'Superman', 'Lie flat on your stomach, extend your arms forward, palms on the ground. Raise your upper body and then your legs to form an arch. Make sure that your knees and your chest do not touch the floor. Keep your head and neck neutral. Do not overextend your neck and keep your chin tucked. You can bend your arms slightly at the elbows as you extend them up and forward. You can increase or decrease your body tension by slightly raising or lowering your upper body and/or legs simultaneously.', 1, 'back'),
(NULL, 'Plank', 'Place your palms flat on the floor, hands shoulder-width apart. Shoulders stacked directly above your wrists. Extend your legs behind you, feet hip-width apart. Tuck your tailbone and engage your core, glutes, and quads. Hold here for a set amount of time.', 2, 'abs'),
(NULL, 'Dumbbell Squat', 'Stand with feet at hip-width distance, holding dumbbells at your shoulders with palms facing in. Send the glutes back and lower down into a squat until your quads are about parallel with the ground. Press through the heels to return to stand.', 2, 'legs'),
(NULL, 'Body-weight Squat', 'Stand with feet at hip-width distance. Extend your arms straight in front of you with palms facing down. Send the glutes back and lower down into a squat until your quads are about parallel with the ground. Hold for 5 seconds before slowly returning to a standing position.', 1, 'legs');


-- Insert statement for req_equip_line table
INSERT INTO req_equip_line (exercise_id, equip_id)
VALUES (8, 1),
       (9, 4),
       (10, 6),
       (11, 6),
       (12, 6),
       (13, 1),
       (14, 6);


/* Equipment id numbers:

    'dumbbells' - 1
    'kettlebells' - 2
    'resistance bands' - 3
    'chairs' - 4
    'pull-up bar' - 5
    'no equipment' - 6

 */

SELECT workout_id, DATE(date_time) as 'Date' FROM workout
WHERE user_id = 29 AND date_time BETWEEN DATE_SUB(NOW(), INTERVAL 14 DAY) AND NOW();