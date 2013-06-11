\c postgres

DROP DATABASE IF EXISTS store;

CREATE DATABASE store;

\c store

CREATE TABLE users (
   id SERIAL PRIMARY KEY,
   email VARCHAR(50) NOT NULL UNIQUE,
   password VARCHAR(100) NOT NULL,
   admin BOOLEAN DEFAULT FALSE,
   createdAt TIMESTAMP
);

CREATE TABLE clients (
   cep VARCHAR(15) NOT NULL,  
   street VARCHAR(50) NOT NULL,
   num VARCHAR(10) NOT NULL,
   city VARCHAR(30) NOT NULL,
   state VARCHAR(30) NOT NULL,
   phone VARCHAR(20) NOT NULL,
   neighboorhood VARCHAR(30) NOT NULL
) inherits(users);

CREATE TABLE common (
   dtnasc DATE NOT NULL,
   name VARCHAR(30) NOT NULL,
   sex VARCHAR(10) NOT NULL,
   cpf VARCHAR(15) NOT NULL                   
) inherits (clients);

CREATE TABLE company (
   socialReason VARCHAR(40) NOT NULL, 
   cnpj VARCHAR(30) NOT NULL,         
   name VARCHAR(50) NOT NULL,
   ie VARCHAR(15) NOT NULL
) inherits (clients);

CREATE TABLE contacts (
   id SERIAL PRIMARY KEY,
   email VARCHAR(50) NOT NULL,
   name VARCHAR(30) NOT NULL,   
   content TEXT NOT NULL,
   createdAt TIMESTAMP
);

CREATE TABLE departments (
   id SERIAL PRIMARY KEY,
   name VARCHAR(50) NOT NULL,
   createdAt TIMESTAMP
);

CREATE TABLE products (
   id SERIAL PRIMARY KEY,
   description VARCHAR(50) NOT NULL,
   name VARCHAR(50) NOT NULL,
   price MONEY NOT NULL,              
   feactured BOOLEAN DEFAULT FALSE NOT NULL,
   stock INTEGER NOT NULL,
   createdAt TIMESTAMP,
   photoName VARCHAR(100) NOT NULL,

   department_id INTEGER, FOREIGN KEY (department_id) REFERENCES departments (id)
);

CREATE TABLE photos (
  id SERIAL PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  type VARCHAR(10) NOT NULL,
  size FLOAT NOT NULL,
  folder VARCHAR(100) NOT NULL
);

CREATE TABLE product_photo (
  product_photo INTEGER references products(id) ON DELETE CASCADE
) inherits(photos);
