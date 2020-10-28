-- Gemaakt door Furkan Uçar OITAOO8B
-- create new db
CREATE DATABASE drempeltoets;

-- tabel Medewerker aanmaken.
CREATE TABLE Medewerker(
    id INT NOT NULL AUTO_INCREMENT,
    voornaam VARCHAR(250) NOT NULL,
    achternaam VARCHAR(250),
    email VARCHAR(250),
    PRIMARY KEY(id)
);

-- tabel activiteiten aanmaken.
CREATE TABLE activiteiten(
    id INT NOT NULL AUTO_INCREMENT,
    omschrijving VARCHAR(250) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel Jongeren aanmaken.
CREATE TABLE Jongeren(
    id INT NOT NULL AUTO_INCREMENT,
    Voornaam VARCHAR(250) NOT NULL,
    NAW VARCHAR(250) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel Koppel aanmaken.
CREATE TABLE koppel(
    id INT NOT NULL AUTO_INCREMENT,
    ActiviteitenID INT NOT NULL,
    JongerenID INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(ActiviteitenID) REFERENCES activiteiten(id),
    FOREIGN KEY(JongerenID) REFERENCES Jongeren(id)
);
