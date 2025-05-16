CREATE DATABASE chez_jeremy;
USE chez_jeremy;

CREATE TABLE hairdressers (
	id_hairdresser INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(50)
)engine=InnoDB;

CREATE TABLE appointments(
	id_appointment INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `hour` TIME NOT NULL,
	`date` DATE NOT NULL,
    is_booked BOOLEAN DEFAULT FALSE,
    id_hairdresser INT NOT NULL,
    FOREIGN KEY (id_hairdresser) REFERENCES hairdressers (id_hairdresser)
)engine=InnoDB;

CREATE TABLE booked_appointments (
    id_booked_appointment INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
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
    id_hairdresser INT NOT NULL,
    FOREIGN KEY (id_hairdresser) REFERENCES hairdressers (id_hairdresser)
)engine=InnoDB;

INSERT INTO hairdressers (`name`) VALUES ("JEREMY"),("REMY"),("EMY");