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

/* web
http://localhost/get_card.php
*/

SELECT * FROM user_cards WHERE user_id = 2 AND card_id != 7;
user_id = Nagasakaでcard_id = Cavalry の時の　user_cardsのid
答えは、6
SELECT * FROM user_cards WHERE user_id = 2 AND card_id = 7;