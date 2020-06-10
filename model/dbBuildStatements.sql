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
    primary key(workout_id, exercise_id),
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

) ENGINE=InnoDB


INSERT INTO igarage_user (user_id, firstName, lastName, username, password, fitness_level)
VALUES (NULL, 'Admin', 'Admin', 'Admin', '@dm1n', 'advanced')

--Insert statement for equipment table
INSERT INTO equipment (equip_id, equip_name)
VALUES 	(NULL, 'dumbbells'),
        (NULL, 'kettlebells'),
        (NULL, 'resistance bands'),
        (NULL, 'chairs'),
        (NULL, 'pull-up bar'),
        (NULL, 'no equipment');

