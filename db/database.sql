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
   featured BOOLEAN DEFAULT FALSE NOT NULL,
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



/*
CREATE TABLE images (
   id SERIAL PRIMARY KEY,
   name VARCHAR(100) NOT NULL,
   folder VARCHAR(80) NOT NULL,
   type VARCHAR(30) NOT NULL,
   size FLOAT NOT NULL,
   createdAt TIMESTAMP,

   product_id INTEGER, FOREIGN KEY (product_id) REFERENCES products (id) 
);

CREATE TABLE users (
   id SERIAL PRIMARY KEY,
   email VARCHAR(50) NOT NULL,
   password VARCHAR(100) NOT NULL,
   cep VARCHAR(15) NOT NULL,  
   street VARCHAR(50) NOT NULL,
   num VARCHAR(10) NOT NULL,
   city VARCHAR(30) NOT NULL,
   state VARCHAR(30) NOT NULL,
   phone VARCHAR(20) NOT NULL,
   neighboorhood VARCHAR(30) NOT NULL,
   createdAt TIMESTAMP
);

CREATE TABLE common (
   dtnasc DATE NOT NULL,
   name VARCHAR(30) NOT NULL,
   sex VARCHAR(10) NOT NULL,
   cpf VARCHAR(15) NOT NULL                   
) inherits (users);

CREATE TABLE company (
   socialReason VARCHAR(40) NOT NULL, 
   cnpj VARCHAR(30) NOT NULL,         
   name VARCHAR(50) NOT NULL,
   ie VARCHAR(15) NOT NULL
) inherits (users);

CREATE TABLE departed (
   id SERIAL PRIMARY KEY,
   name VARCHAR(50) NOT NULL
);

CREATE TABLE products (
   id SERIAL PRIMARY KEY,
   description VARCHAR(50) NOT NULL,
   name VARCHAR(50) NOT NULL,
   price MONEY NOT NULL,              
   featured BOOLEAN DEFAULT FALSE NOT NULL,
   stock INTEGER NOT NULL,

   image_id INTEGER, FOREIGN KEY (image_id) REFERENCES image (id),
   dep_id INTEGER, FOREIGN KEY (dep_id) REFERENCES departed (id)
);

CREATE TABLE image (
   id SERIAL PRIMARY KEY,
   folder VARCHAR(80) NOT NULL,
   
   product_id INTEGER, FOREIGN KEY (product_id) REFERENCES products (id)
);

CREATE TABLE item_pedido (
   product_id INTEGER,
   request_id INTEGER,
   amount INTEGER NOT NULL,

   FOREIGN KEY (product_id) REFERENCES products (id),
   FOREIGN KEY (request_id) REFERENCES request (id)   
);

CREATE TABLE request (
   id SERIAL PRIMARY KEY,
   _date DATE NOT NULL,
   status BOOLEAN NOT NULL,

   client_id INTEGER,
   FOREIGN KEY (client_id) REFERENCES person (id)
);

CREATE TABLE billet (
   id SERIAL PRIMARY KEY,
   dtvenc DATE NOT NULL,
   status BOOLEAN NOT NULL,

   request_id INTEGER,
   FOREIGN KEY (request_id) REFERENCES request (id)   
);

CREATE TABLE contacts (
   id SERIAL PRIMARY KEY,
   email VARCHAR(50) NOT NULL,
   name VARCHAR(30) NOT NULL,   
   subject VARCHAR(30) NOT NULL,
   content TEXT NOT NULL,
   createdAt TIMESTAMP
);

CREATE TABLE admin (
   id SERIAL PRIMARY KEY,
   login VARCHAR(30) NOT NULL,
   password VARCHAR(20) NOT NULL,
   createdAt TIMESTAMP
);

*/