CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories
(
	category_id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	code VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE users
(
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	email VARCHAR(128) NOT NULL UNIQUE,
	name VARCHAR(128) NOT NULL,
	password VARCHAR(128) NOT NULL,
	contact VARCHAR(128) NOT NULL
);

CREATE TABLE lots
(
	lot_id INT PRIMARY KEY AUTO_INCREMENT,
	create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	name VARCHAR(128) NOT NULL,
	discription TEXT NOT NULL,
	image VARCHAR(128) NOT NULL UNIQUE,
	start_price INT NOT NULL,
	finsh_date DATETIME NOT NULL,
	bet_stage INT NOT NULL,
	creator_id INT NOT NULL,
	winner_id INT,
	category_id INT NOT NULL,
	FOREIGN KEY (creator_id) REFERENCES users (user_id),
	FOREIGN KEY (winner_id) REFERENCES users (user_id),
	FOREIGN KEY (category_id) REFERENCES categories (category_id)
);
CREATE FULLTEXT INDEX lot_search ON lots(name, discription);

CREATE TABLE bets
(
	bet_id INT PRIMARY KEY AUTO_INCREMENT,
	bet_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	price INT NOT NULL,
	user_id INT NOT NULL,
	lot_id INT NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users (user_id),
	FOREIGN KEY (lot_id) REFERENCES lots (lot_id)
);