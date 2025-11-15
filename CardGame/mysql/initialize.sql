CREATE USER IF NOT EXISTS 'data_user'@'localhost' IDENTIFIED BY 'data';
GRANT ALL PRIVILEGES ON * . * TO 'data_user'@'localhost';

DROP DATABASE IF EXISTS test_db;
CREATE DATABASE IF NOT EXISTS test_db;

use test_db;

DROP TABLE IF EXISTS jobs;
CREATE TABLE IF NOT EXISTS jobs (
    id INT PRIMARY KEY,
    name VARCHAR(255)
);

insert into jobs (id, name) values
(1, 'knight'),
(2, 'wizard'),
(3, 'thief');

DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS user (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    level INT,
    job_id INT
);

DROP TABLE IF EXISTS battle_log;
CREATE TABLE IF NOT EXISTS battle_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    result_win BOOLEAN,
    create_date DATE
);

INSERT INTO user(id, name, level, job_id) VALUES
(1, 'abc', 45, 3),
(2, 'def', 21, 1),
(3, 'ghi', 37, 2),
(4, 'jkl', 26, 2),
(5, 'mno', 31, 3),
(6, 'pqr', 19, 1),
(7, 'stu', 42, 1),
(8, 'vwx', 29, 2),
(9, 'yz', 40, 3);

INSERT INTO battle_log (user_id, result_win, create_date) VALUES
(8, TRUE, '2025-01-05'),
(9, TRUE, '2025-01-05'),
(6, TRUE, '2025-01-05'),
(5, TRUE, '2025-01-05'),
(8, TRUE, '2025-01-05'),
(3, FALSE, '2025-01-05'),
(2, FALSE, '2025-01-05'),
(9, FALSE, '2025-01-05'),
(1, FALSE, '2025-01-05'),
(8, TRUE, '2025-01-05'),
(9, TRUE, '2025-01-05'),
(6, FALSE, '2025-01-05'),
(1, FALSE, '2025-01-06'),
(4, TRUE, '2025-01-06'),
(2, TRUE, '2025-01-06'),
(3, TRUE, '2025-01-06'),
(5, TRUE, '2025-01-06'),
(7, FALSE, '2025-01-06'),
(7, TRUE, '2025-01-06'),
(5, FALSE, '2025-01-06'),
(2, TRUE, '2025-01-06'),
(1, TRUE, '2025-01-06'),
(4, FALSE, '2025-01-06'),
(6, TRUE, '2025-01-06'),
(3, TRUE, '2025-01-06'),
(8, FALSE, '2025-01-06'),
(7, FALSE, '2025-01-06'),
(6, FALSE, '2025-01-06'),
(6, TRUE, '2025-01-06'),
(1, FALSE, '2025-01-06'),
(3, TRUE, '2025-01-06'),
(6, FALSE, '2025-01-06'),
(7, TRUE, '2025-01-06'),
(7, TRUE, '2025-01-06'),
(4, TRUE, '2025-01-06'),
(2, TRUE, '2025-01-06'),
(8, TRUE, '2025-01-06'),
(4, TRUE, '2025-01-06'),
(8, FALSE, '2025-01-07'),
(1, TRUE, '2025-01-07'),
(3, TRUE, '2025-01-07'),
(3, FALSE, '2025-01-07'),
(9, FALSE, '2025-01-07'),
(9, TRUE, '2025-01-07'),
(5, TRUE, '2025-01-07'),
(1, FALSE, '2025-01-07'),
(7, TRUE, '2025-01-07'),
(3, TRUE, '2025-01-07'),
(8, TRUE, '2025-01-07'),
(4, TRUE, '2025-01-07'),
(2, FALSE, '2025-01-07'),
(2, TRUE, '2025-01-07'),
(5, FALSE, '2025-01-07'),
(9, FALSE, '2025-01-07'),
(5, TRUE, '2025-01-08'),
(4, TRUE, '2025-01-08'),
(6, TRUE, '2025-01-08'),
(1, TRUE, '2025-01-08'),
(2, TRUE, '2025-01-08'),
(7, TRUE, '2025-01-08'),
(5, TRUE, '2025-01-08'),
(6, FALSE, '2025-01-08'),
(5, TRUE, '2025-01-08'),
(7, TRUE, '2025-01-08'),
(4, TRUE, '2025-01-08'),
(2, TRUE, '2025-01-08'),
(8, TRUE, '2025-01-08'),
(3, TRUE, '2025-01-08'),
(9, FALSE, '2025-01-08'),
(4, TRUE, '2025-01-08'),
(1, FALSE, '2025-01-08'),
(9, TRUE, '2025-01-08');


/* 例題（基礎） */
/*1*/
select*from user where id = 5;
/*2*/
select*from user order by level desc limit 3;
/*3*/
select count(*)from battle_log where create_date = '2025-01-05';
/*4*/
select u.id, u.name, u.job_id, j.name from users u left outer join jobs j on u.job_id = j.id order by u.id;

/* 例題（難しい） */
/*1*/
select user_id, count(id) as win_count from battle_log
where result_win = true
group by user_id;

/*2*/

/*3*/

/*4*/



/* カードゲーム */
DROP USER 'cardGame'@'%';
CREATE USER 'cardGame'@'%' IDENTIFIED BY 'card';
GRANT ALL PRIVILEGES ON * . * TO 'cardGame'@'%';

DROP DATABASE IF EXISTS card_game;
CREATE DATABASE IF NOT EXISTS card_game;

use card_game;
/* ユーザーが組んだデッキ一覧 */
DROP TABLE IF EXISTS user_decks;
CREATE TABLE IF NOT EXISTS user_decks (
    user_id INT PRIMARY KEY,
    deck_id INT,
    user_card_id INT
);

insert into user_decks (user_id, deck_id, user_card_id) values
(1, 1, 1),
(1, 1, 2),
(1, 1, 3),
(1, 2, 4),
(1, 2, 5),
(1, 2, 6),
(2, 1, 7),
(2, 1, 8),
(2, 1, 9);

/* ユーザーが所持しているカード一覧 */
DROP TABLE IF EXISTS user_cards;
CREATE TABLE IF NOT EXISTS user_cards(
    id INT PRIMARY KEY,
    user_id INT,
    card_id INT
);

insert into user_cards (id, user_id, card_id) values
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 2, 1),
(8, 2, 3),
(9, 2, 4),
(10, 2, 5);






// Card_Game
// テーブル作成

DROP DATABASE IF EXISTS card_game;
CREATE DATABASE IF NOT EXISTS card_game;
use card_game;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY,
    name VARCHAR(255)
);

DROP TABLE IF EXISTS user_cards;
CREATE TABLE IF NOT EXISTS user_cards (
    id INT PRIMARY KEY,
    user_id INT,
    card_id INT
);

DROP TABLE IF EXISTS user_decks;
CREATE TABLE IF NOT EXISTS user_decks (
    id INT PRIMARY KEY,
    user_id INT,
    deck_id INT,
    user_card_id INT
);

DROP TABLE IF EXISTS cards;
CREATE TABLE IF NOT EXISTS cards (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    kind_id INT,
    level INT
);

insert into users (id, name) values
(1, 'Shimada'),
(2, 'Nagasaka'),
(3, 'Deguti'),
(4, 'Shirasaki');

insert into user_cards (id, user_id, card_id) values
(1, 1, 1), 
(2, 1, 4), 
(3, 1, 7), 
(4, 2, 1), 
(5, 2, 4), 
(6, 2, 7), 
(7, 3, 1), 
(8, 3, 4), 
(9, 3, 7), 
(10, 4, 1), 
(11, 4, 4), 
(12, 4, 7);


insert into user_decks (user_id, deck_id, user_card_id) values
(, , ),
(, , );

insert into cards (id, name, kind_id, level) values
(1, 'Infantry', 1, 1), 
(2, 'Heavy Infantry', 1, 2), 
(3, 'Armored Guardian', 1, 3), 
(4, 'Archer', 2, 1), 
(5, 'Crossbowman', 2, 2), 
(6, 'Sniper', 2, 3), 
(7, 'Cavalry', 3, 1), 
(8, 'Heavy Cavalry', 3, 2), 
(9, 'Knight King', 3, 3); 


