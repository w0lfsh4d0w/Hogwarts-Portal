CREATE DATABASE IF NOT EXISTS hogwarts_db;
USE hogwarts_db;

-- 1. House
CREATE TABLE House (
    house_id    INT AUTO_INCREMENT PRIMARY KEY,
    house_name  VARCHAR(50)  NOT NULL UNIQUE,
    total_points INT          NOT NULL DEFAULT 0
);

-- 2. User
CREATE TABLE User (
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    user_name   VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        ENUM('Student', 'Professor', 'Dumbledore') NOT NULL
);

-- 3. Student
CREATE TABLE Student (
    student_id  INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT            NOT NULL UNIQUE,
    house_id    INT            NOT NULL,
    balance     DECIMAL(10,2)  NOT NULL DEFAULT 1000.00,
    status      ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    CONSTRAINT fk_student_user
        FOREIGN KEY (user_id)  REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_student_house
        FOREIGN KEY (house_id) REFERENCES House(house_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- =============================================
-- 4. Professor
-- =============================================
CREATE TABLE Professor (
    professor_id    INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT          NOT NULL UNIQUE,
    professor_name  VARCHAR(100) NOT NULL,
    CONSTRAINT fk_professor_user
        FOREIGN KEY (user_id) REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- 5. Wand
-- =============================================
CREATE TABLE Wand (
    wand_id     INT AUTO_INCREMENT PRIMARY KEY,
    student_id  INT NOT NULL UNIQUE,
    wood_type   ENUM('Holly','Yew','Elder','Willow','Hawthorn','Oak') NOT NULL,
    core_type   ENUM('Phoenix Feather','Dragon Heartstring',
                     'Unicorn Hair','Thestral Tail Hair') NOT NULL,
    CONSTRAINT fk_wand_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- 6. Course
-- =============================================
CREATE TABLE Course (
    course_id       INT AUTO_INCREMENT PRIMARY KEY,
    course_name     VARCHAR(150) NOT NULL,
    professor_id    INT          NOT NULL,
    CONSTRAINT fk_course_professor
        FOREIGN KEY (professor_id) REFERENCES Professor(professor_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- =============================================
-- 7. Enrollment
-- =============================================
CREATE TABLE Enrollment (
    enroll_id       INT AUTO_INCREMENT PRIMARY KEY,
    student_id      INT NOT NULL,
    course_id       INT NOT NULL,
    enrolled_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status          ENUM('Enrolled', 'Dropped') NOT NULL DEFAULT 'Enrolled',
    CONSTRAINT uq_enrollment UNIQUE (student_id, course_id),
    CONSTRAINT fk_enrollment_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_enrollment_course
        FOREIGN KEY (course_id)  REFERENCES Course(course_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- 8. Assignment
-- =============================================
CREATE TABLE Assignment (
    assignment_id   INT AUTO_INCREMENT PRIMARY KEY,
    course_id       INT          NOT NULL,
    assignment_type ENUM('Quiz', 'Task') NOT NULL,
    title           VARCHAR(200) NOT NULL,
    max_points      INT          NOT NULL DEFAULT 100,
    created_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deadline        TIMESTAMP    NOT NULL,
    CONSTRAINT fk_assignment_course
        FOREIGN KEY (course_id) REFERENCES Course(course_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- 9. Submission
-- =============================================
CREATE TABLE Submission (
    submission_id   INT AUTO_INCREMENT PRIMARY KEY,
    assign_id       INT NOT NULL,
    student_id      INT NOT NULL,
    score           INT NOT NULL DEFAULT 0,
    submitted_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_submission UNIQUE (assign_id, student_id),
    CONSTRAINT chk_score
        CHECK (score >= 0),
    CONSTRAINT fk_submission_assignment
        FOREIGN KEY (assign_id)  REFERENCES Assignment(assignment_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_submission_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- 10. HousePoints
-- =============================================
CREATE TABLE HousePoints (
    points_id       INT AUTO_INCREMENT PRIMARY KEY,
    house_id        INT NOT NULL,
    student_id      INT NOT NULL,
    submission_id   INT NOT NULL UNIQUE,
    points          INT NOT NULL DEFAULT 0,
    added_at        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_housepoints_house
        FOREIGN KEY (house_id)      REFERENCES House(house_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_housepoints_student
        FOREIGN KEY (student_id)    REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_housepoints_submission
        FOREIGN KEY (submission_id) REFERENCES Submission(submission_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- 11. DiagonAlleyShop
-- =============================================
CREATE TABLE DiagonAlleyShop (
    item_id     INT AUTO_INCREMENT PRIMARY KEY,
    item_name   VARCHAR(150)  NOT NULL,
    item_type   ENUM('Broom', 'Potion Ingredient', 'Spell Book') NOT NULL,
    item_price  DECIMAL(10,2) NOT NULL
);

-- =============================================
-- 12. Inventory
-- =============================================
CREATE TABLE Inventory (
    inventory_id    INT AUTO_INCREMENT PRIMARY KEY,
    student_id      INT NOT NULL,
    item_id         INT NOT NULL,
    quantity        INT NOT NULL DEFAULT 1,
    purchased_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_inventory_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_inventory_item
        FOREIGN KEY (item_id)    REFERENCES DiagonAlleyShop(item_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- =============================================
-- 13. Message
-- =============================================
CREATE TABLE Message (
    message_id      INT AUTO_INCREMENT PRIMARY KEY,
    sender_id       INT     NOT NULL,
    receiver_id     INT     NOT NULL,
    message_body    TEXT    NOT NULL,
    sent_at         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_read         BOOLEAN   NOT NULL DEFAULT FALSE,
    CONSTRAINT fk_message_sender
        FOREIGN KEY (sender_id)   REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_message_receiver
        FOREIGN KEY (receiver_id) REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Indexes

CREATE INDEX idx_student_house     ON Student(house_id);
CREATE INDEX idx_course_professor  ON Course(professor_id);
CREATE INDEX idx_enrollment_course ON Enrollment(course_id);
CREATE INDEX idx_assignment_course ON Assignment(course_id);
CREATE INDEX idx_submission_assign ON Submission(assign_id);
CREATE INDEX idx_housepoints_house ON HousePoints(house_id);
CREATE INDEX idx_inventory_item    ON Inventory(item_id);
CREATE INDEX idx_message_sender    ON Message(sender_id);
CREATE INDEX idx_message_receiver  ON Message(receiver_id);

-- TRIGGER: auto-update House.total_points
-- when a new HousePoints row is inserted
DELIMITER $$

CREATE TRIGGER trg_update_house_points
AFTER INSERT ON HousePoints
FOR EACH ROW
BEGIN
    UPDATE House
    SET total_points = total_points + NEW.points
    WHERE house_id = NEW.house_id;
END$$

-- TRIGGER: auto-update House.total_points
-- when a HousePoints row is deleted
CREATE TRIGGER trg_rollback_house_points
AFTER DELETE ON HousePoints
FOR EACH ROW
BEGIN
    UPDATE House
    SET total_points = total_points - OLD.points
    WHERE house_id = OLD.house_id;
END$$

DELIMITER ;

-- SEED DATA: Houses
INSERT INTO House (house_name, total_points) VALUES
    ('Gryffindor', 0),
    ('Slytherin',  0),
    ('Ravenclaw',  0),
    ('Hufflepuff', 0);

-- =============================================
-- SEED DATA: Shop Items
-- =============================================
INSERT INTO DiagonAlleyShop (item_name, item_type, item_price) VALUES
    ('Nimbus 2000',                 'Broom',              500.00),
    ('Firebolt',                    'Broom',              1200.00),
    ('Polyjuice Potion Ingredient', 'Potion Ingredient',  80.00),
    ('No Sleep Potion',             'Potion Ingredient',  60.00),
    ('Basic Spell Book',            'Spell Book',         120.00),
    ('Dark Magic (PHP)',            'Spell Book',         999.00);