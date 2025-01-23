CREATE DATABASE corretor_db;

USE corretor_db;

CREATE TABLE corretores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    creci VARCHAR(10) NOT NULL
);

INSERT INTO corretores (name, cpf, creci)
VALUES 
('André Nunes', '12345678910', '1234');
