CREATE DATABASE chez_jeremy;
USE chez_jeremy;

CREATE TABLE users(
   id_user INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
   firstname_user VARCHAR(50) NOT NULL,
   lastname_user VARCHAR(50) NOT NULL,
   age_user VARCHAR(50),
   address_user VARCHAR(50),
   email_user VARCHAR(100) NOT NULL,
   -- password_user VARCHAR(255) NOT NULL,
   phone_user INT NOT NULL
)engine=InnoDB;

CREATE TABLE appointments(
	id_appointment INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `hour` TIME NOT NULL,
	`date` DATE NOT NULL,
    is_booked BOOLEAN DEFAULT FALSE
)engine=InnoDB;

CREATE TABLE booked_appointments (
    id_booked_appointments INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    age INT,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    street VARCHAR(100),
    postal_code INT,
    town VARCHAR (50),
    `date` DATE NOT NULL,
    `hour` TIME NOT NULL,
    benefit VARCHAR(100) NOT NULL,
    hairdresser VARCHAR(50)
)engine=InnoDB;