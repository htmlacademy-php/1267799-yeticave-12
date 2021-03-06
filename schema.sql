CREATE DATABASE IF NOT EXISTS yeticave DEFAULT CHARACTER SET 'utf8';

USE yeticave;

CREATE TABLE IF NOT EXISTS category (
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL UNIQUE,
    code_name VARCHAR(128) NOT NULL UNIQUE);
    
CREATE TABLE IF NOT EXISTS user (
	id INT AUTO_INCREMENT PRIMARY KEY,
    register_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL UNIQUE,
    name VARCHAR(128) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_contact TEXT);
    
CREATE TABLE IF NOT EXISTS lot (
	id INT AUTO_INCREMENT PRIMARY KEY,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    img_link TEXT NOT NULL,
    start_price DECIMAL(8,2) NOT NULL ,
    end_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    bid_step DECIMAL(8,2) NOT NULL,
    userID INT NOT NULL,
    winnerID INT,
    categoryID INT NOT NULL,
    ## связи
    FOREIGN KEY (userID) REFERENCES user (id),
    FOREIGN KEY (winnerID) REFERENCES user (id),
    FOREIGN KEY (categoryID) REFERENCES category (id)
    );
    
CREATE TABLE IF NOT EXISTS bid (
	id INT AUTO_INCREMENT PRIMARY KEY,
    bid_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sum_price DECIMAL(8,2) NOT NULL,
    userID INT NOT NULL,
    lotID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES user (id),
    FOREIGN KEY (lotID) REFERENCES lot (id)
    );

## добавление полнотекстового поиска
CREATE FULLTEXT INDEX lot_search ON lot(name, description);
