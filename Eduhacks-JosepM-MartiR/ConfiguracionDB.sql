-- SCRIPT DE CONFIGURACION DE LA BASE DE DATOS PARA LA PRACTICA 1 DE PHP

-- Ceacion de la base de datos
CREATE DATABASE practica1php; -- Falta la codificacion de caracteres
USE practica1Php;

-- Creacion tabla
CREATE TABLE users (
	iduser INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mail varchar(50) unique,
    username varchar(16) unique,
    passHash varchar(60),
    userFirstName varchar(60),
    userLastName varchar(120),
    creationDate datetime,
    removeDate datetime,
    lastSignIn datetime,
    `active` TinyInt(1)
);

-- Creacion del usuario php
CREATE USER 'php'@'localhost' IDENTIFIED BY 'LaP4ssw0rToWapaNiñu';
GRANT SELECT ON Practica1Php.users TO 'php'@'localhost';
GRANT INSERT ON Practica1Php.users TO 'php'@'localhost';
GRANT UPDATE ON Practica1Php.users TO 'php'@'localhost';

-- --------------------------------------------------------------
-- --------------------------------------------------------------
-- --------------------------------------------------------------

-- PRUEBAAASSSS
-- SELECT * FROM users;
-- INSERT INTO users (username,mail,userFirstName,userLastName,passHash,creationDate,active) VALUES ("admin","admin@testing.test","Prueba","Tester","$2y$10$1WpdxKz73nSW7p2QrQvUiuk36yKOeOc0hKdT2vKmsOl6.RMgLadiu",CURTIME(),0);
-- $2y$10$1WpdxKz73nSW7p2QrQvUiuk36yKOeOc0hKdT2vKmsOl6.RMgLadiu -> 1234

-- UPDATE users SET lastSignIn = CURTIME() WHERE iduser = '24';

-- SELECT * FROM users WHERE (username='admin' OR mail='admin') AND active=1 LIMIT 1;
-- SELECT * FROM users WHERE (UPPER(username)=UPPER('Josep') OR UPPER(mail)=UPPER(''));

-- DELETE FROM users;
