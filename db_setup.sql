-- make sure using correct db
USE php_quiz;

-- drop old tables if needed start fresh
DROP TABLE IF EXISTS high_scores;
DROP TABLE IF EXISTS questions;

-- table to hold our quiz questions
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    wrong_answer1 VARCHAR(255) NOT NULL,
    wrong_answer2 VARCHAR(255) NOT NULL,
    wrong_answer3 VARCHAR(255) NOT NULL,
    -- make category more prominent
    category VARCHAR(100) NOT NULL DEFAULT 'general knowledge'
    -- maybe add difficulty later: difficulty INT DEFAULT 1 (1=easy, 2=med, 3=hard)
);

-- table for high scores
CREATE TABLE high_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(50) NOT NULL,
    score INT NOT NULL,
    category VARCHAR(100) NOT NULL, -- track score per category
    played_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- --- SAMPLE QUESTIONS (more variety maybe) ---

INSERT INTO questions (question_text, correct_answer, wrong_answer1, wrong_answer2, wrong_answer3, category) VALUES
('what color is the sky on a clear day?', 'blue', 'green', 'red', 'purple', 'general knowledge'),
('how many legs does a spider usually have?', '8', '6', '4', '10', 'animals'),
('whats the main ingredient in traditional guacamole?', 'avocado', 'tomato', 'onion', 'lime juice', 'food'),
('what is the capital of poland?', 'warsaw', 'krakow', 'gdansk', 'poznan', 'geography'),
('which planet is known as the red planet?', 'mars', 'jupiter', 'venus', 'saturn', 'space'),
('what does php stand for (recursive acronym)?', 'php: hypertext preprocessor', 'personal home page', 'pre hypertext processor', 'pretty helpful programming', 'programming'),
('how many days are in a leap year?', '366', '365', '360', '370', 'general knowledge'),
('what is 2 + 2 * 2?', '6', '8', '4', '10', 'math'),
('who painted the mona lisa?', 'leonardo da vinci', 'michelangelo', 'raphael', 'donatello', 'art'),
('what is the largest mammal?', 'blue whale', 'elephant', 'giraffe', 'hippopotamus', 'animals'),
('in which country would u find the city of staszów?', 'poland', 'germany', 'czech republic', 'ukraine', 'geography'),
('what is `echo (true && false);` in php?', 'nothing (empty string)', '1', '0', 'error', 'programming'),
('which sql keyword is used to retrieve data?', 'select', 'update', 'insert', 'delete', 'programming'),
('what is the chemical symbol for water?', 'h2o', 'co2', 'o2', 'h2so4', 'science');