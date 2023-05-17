-- Criar tabela "users"
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(250),
    email VARCHAR(250),
    password VARCHAR(250)
);

-- Inserir usuários na tabela
INSERT INTO users (name, email, password) VALUES ('John Doe', 'john@example.com', 'password123');
INSERT INTO users (name, email, password) VALUES ('Jane Smith', 'jane@example.com', 'p@ssw0rd');
INSERT INTO users (name, email, password) VALUES ('Alice Johnson', 'alice@example.com', 'secret123');
INSERT INTO users (name, email, password) VALUES ('Felipe Figueiredo', 'felipe@email.com', '123456');

-- Cria tabela "product_types"
CREATE TABLE product_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(250),
)

-- Cria tabela "product"
CREATE TABLE products (
    id SERIAL PRIMARY KEY ,
    name VARCHAR(250),
    product_type_id INT UNIQUE,
    FOREIGN KEY (product_type_id) REFERENCES product_types (id)
)

-- Cria tabela "product_type_tax_rates"
CREATE TABLE product_type_tax_rates (
    id SERIAL PRIMARY KEY,
    tax_rate VARCHAR(250),
    product_type_id INT UNIQUE,
    FOREIGN KEY (product_type_id) REFERENCES product_types (id)
)