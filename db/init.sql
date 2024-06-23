ALTER DATABASE php_final_project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS roles
(
    role_id   INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS users
(
    user_id  INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE  NOT NULL,
    password VARCHAR(255)        NOT NULL,
    email    VARCHAR(100) UNIQUE NOT NULL,
    role_id  INT,
    FOREIGN KEY (role_id) REFERENCES roles (role_id)
);

CREATE TABLE IF NOT EXISTS specializations
(
    specialization_id   INT AUTO_INCREMENT PRIMARY KEY,
    specialization_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS coaches
(
    coach_id          INT AUTO_INCREMENT PRIMARY KEY,
    name              VARCHAR(100)        NOT NULL,
    specialization_id INT,
    email             VARCHAR(100) UNIQUE NOT NULL,
    FOREIGN KEY (specialization_id) REFERENCES specializations (specialization_id)
);

CREATE TABLE IF NOT EXISTS activities
(
    activity_id      INT AUTO_INCREMENT PRIMARY KEY,
    activity_name    VARCHAR(100) NOT NULL,
    description      TEXT,
    start_time       TIME         NOT NULL,
    end_time         TIME         NOT NULL,
    max_participants INT          NOT NULL,
    coach_id         INT,
    FOREIGN KEY (coach_id) REFERENCES coaches (coach_id)
);

CREATE TABLE IF NOT EXISTS registrations
(
    registration_id   INT AUTO_INCREMENT PRIMARY KEY,
    user_id           INT,
    activity_id       INT,
    registration_date DATETIME                        DEFAULT CURRENT_TIMESTAMP,
    status            ENUM ('confirmed', 'cancelled') DEFAULT 'confirmed',
    FOREIGN KEY (user_id) REFERENCES users (user_id),
    FOREIGN KEY (activity_id) REFERENCES activities (activity_id)
);

CREATE VIEW view_coaches_by_specialization AS
SELECT
    c.coach_id,
    c.name,
    a.description,
    a.start_time,
    a.activity_id,
    c.specialization_id
FROM
    coaches c
        JOIN
    activities a ON c.coach_id = a.coach_id
ORDER BY
    a.start_time;

DELIMITER //

CREATE PROCEDURE getRegistrationsByUser(IN user_id INT)
BEGIN
    SELECT
        r.registration_date,
        a.start_time,
        a.end_time,
        a.activity_name,
        r.status,
        c.name
    FROM
        registrations r
        JOIN activities a ON r.activity_id = a.activity_id
        LEFT JOIN coaches c ON a.coach_id = c.coach_id
    WHERE
        r.user_id = user_id
    ORDER BY
        r.registration_date;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE CreateRegistration(
    IN p_user_id INT,
    IN p_activity_id INT,
    IN p_registration_date DATE
)
BEGIN
    INSERT INTO registrations (user_id, activity_id, registration_date)
    VALUES (p_user_id, p_activity_id, p_registration_date);
END //

DELIMITER ;


INSERT INTO roles (role_name)
VALUES ('ADMIN'),
       ('USER');

INSERT INTO users (username, password, email, role_id)
VALUES ('admin', 'admin', 'admin@test.com', (SELECT role_id FROM roles WHERE role_name = 'ADMIN'));

INSERT INTO specializations (specialization_name)
VALUES ('Кардиотренировки'),
       ('Йога'),
       ('Силовые тренировки'),
       ('Пилатес');

INSERT INTO coaches (name, specialization_id, email)
VALUES ('Алексей Иванов',
        (SELECT specialization_id FROM specializations WHERE specialization_name = 'Силовые тренировки'),
        'alexey.ivanov@test.com'),
       ('Сергей Волков',
        (SELECT specialization_id FROM specializations WHERE specialization_name = 'Силовые тренировки'),
        'sergey.volkov@test.com'),
       ('Ольга Смирнова',
        (SELECT specialization_id FROM specializations WHERE specialization_name = 'Кардиотренировки'),
        'olga.smirnova@test.com'),
       ('Игорь Соколов', (SELECT specialization_id FROM specializations WHERE specialization_name = 'Кардиотренировки'),
        'igor.sokolov@test.com'),
       ('Анна Павлова', (SELECT specialization_id FROM specializations WHERE specialization_name = 'Кардиотренировки'),
        'anna.pavlova@test.com'),
       ('Ирина Кузнецова', (SELECT specialization_id FROM specializations WHERE specialization_name = 'Пилатес'),
        'irina.kuznetsova@test.com'),
       ('Наталья Орлова', (SELECT specialization_id FROM specializations WHERE specialization_name = 'Пилатес'),
        'natalia.orlova@test.com'),
       ('Виктория Васильева', (SELECT specialization_id FROM specializations WHERE specialization_name = 'Пилатес'),
        'victoria.vasileva@test.com'),
       ('Екатерина Фролова', (SELECT specialization_id FROM specializations WHERE specialization_name = 'Йога'),
        'ekaterina.frolova@test.com'),
       ('Александр Семёнов', (SELECT specialization_id FROM specializations WHERE specialization_name = 'Йога'),
        'alexander.semenov@test.com');

INSERT INTO activities (activity_name, description, start_time, end_time, max_participants, coach_id)
VALUES ('Утренняя кардиотренировка', 'Интенсивная кардиотренировка для начинающих.', '07:00:00', '08:00:00', 20,
        (SELECT coach_id FROM coaches WHERE name = 'Ольга Смирнова')),
       ('Силовая тренировка для начинающих', 'Базовая силовая тренировка для всех уровней.', '09:00:00', '10:00:00', 15,
        (SELECT coach_id FROM coaches WHERE name = 'Алексей Иванов')),
       ('Йога для всех уровней', 'Утренняя йога для снятия стресса и улучшения гибкости.', '08:00:00', '09:00:00', 25,
        (SELECT coach_id FROM coaches WHERE name = 'Екатерина Фролова')),
       ('Пилатес для начинающих', 'Пилатес для улучшения осанки и укрепления мышц.', '10:00:00', '11:00:00', 10,
        (SELECT coach_id FROM coaches WHERE name = 'Ирина Кузнецова')),
       ('Вечерняя кардиотренировка', 'Интенсивная кардиотренировка для всех уровней.', '18:00:00', '19:00:00', 20,
        (SELECT coach_id FROM coaches WHERE name = 'Игорь Соколов')),
       ('Силовая тренировка для продвинутых', 'Интенсивная силовая тренировка для опытных.', '19:00:00', '20:00:00', 15,
        (SELECT coach_id FROM coaches WHERE name = 'Сергей Волков')),
       ('Йога на закате', 'Вечерняя йога для расслабления и медитации.', '20:00:00', '21:00:00', 25,
        (SELECT coach_id FROM coaches WHERE name = 'Александр Семёнов')),
       ('Пилатес для всех уровней', 'Пилатес для укрепления и тонуса мышц.', '08:00:00', '09:00:00', 10,
        (SELECT coach_id FROM coaches WHERE name = 'Наталья Орлова')),
       ('Кардиотренировка выходного дня', 'Интенсивная кардиотренировка для всех уровней.', '09:00:00', '10:00:00', 20,
        (SELECT coach_id FROM coaches WHERE name = 'Анна Павлова')),
       ('Пилатес для продвинутых', 'Интенсивный пилатес для опытных.', '10:00:00', '11:00:00', 10,
        (SELECT coach_id FROM coaches WHERE name = 'Виктория Васильева'));
