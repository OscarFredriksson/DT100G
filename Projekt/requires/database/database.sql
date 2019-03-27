CREATE TABLE QUIZZES
(
    QUIZ_ID INT NOT NULL AUTO_INCREMENT,
    TITLE VARCHAR(100),
    DESCRIPTION TINYTEXT,
    PRIMARY KEY(QUIZ_ID)
);

CREATE TABLE QUESTIONS
(
    QUESTION_ID INT NOT NULL AUTO_INCREMENT,
    TEXT TINYTEXT,
    QUIZ_ID INT NOT NULL,
    PRIMARY KEY(QUESTION_ID),
    FOREIGN KEY(QUIZ_ID) REFERENCES QUIZZES(QUIZ_ID)
);

CREATE TABLE ALTERNATIVES
(
    ALTERNATIVE_ID INT NOT NULL AUTO_INCREMENT,
    TEXT VARCHAR(100),
    IS_CORRECT BIT NOT NULL,
    QUESTION_ID INT NOT NULL,
    PRIMARY KEY(ALTERNATIVE_ID),
    FOREIGN KEY(QUESTION_ID) REFERENCES QUESTIONS (QUESTION_ID)
);

INSERT INTO QUIZZES(TITLE, DESCRIPTION) VALUES ('Test titel', 'Beskrivande text här');

INSERT INTO QUESTIONS(TEXT, QUIZ_ID) VALUES ('Här är frågan osv...', 1);

INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Alternativ 1', 0, 1);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Alternativ 2', 1, 1);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Alternativ 3', 0, 1);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Alternativ 4', 0, 1);


INSERT INTO QUESTIONS(TEXT, QUIZ_ID) VALUES ('Fråga nummer två!', 1);

INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Svar 1', 0, 2);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Svar 2', 1, 2);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Svar 3', 0, 2);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Svar 4', 0, 2);


INSERT INTO QUESTIONS(TEXT, QUIZ_ID) VALUES ('Vad ska man skriva i en testfråga egentligen?', 1);

INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Vet inte', 0, 3);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Idk', 0, 3);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Ingen aning', 0, 3);
INSERT INTO ALTERNATIVES(TEXT, IS_CORRECT, QUESTION_ID) VALUES ('Visar sig', 1, 3);