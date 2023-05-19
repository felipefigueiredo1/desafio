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
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Insere tipos de produto na tabela
INSERT INTO product_types (name, created_at, updated_at) VALUES('Filmes', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO product_types (name, created_at, updated_at) VALUES('Jogos', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO product_types (name, created_at, updated_at) VALUES('Series', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Cria tabela "products"
CREATE TABLE products (
    id SERIAL PRIMARY KEY ,
    name VARCHAR(250),
    product_type_id INT,
    price FLOAT,
    FOREIGN KEY (product_type_id) REFERENCES product_types (id),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Insere produtos na tabela
INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('Um Sonho de Liberdade', 1, 50, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('Blade Runner', 1, 40, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('Matrix', 1, 80, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('Half Life', 2, 20, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('Deus Ex', 2, 10, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('Fallout', 2, 15, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('The Wire S1', 3, 30, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('Sopranos S1', 3, 40, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO products (name, product_type_id, price, created_at, updated_at) VALUES('True Detective S1', 3, 60, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Cria tabela "product_type_tax_rates"
CREATE TABLE product_type_tax_rates (
    id SERIAL PRIMARY KEY,
    tax_rate INT,
    product_type_id INT,
    FOREIGN KEY (product_type_id) REFERENCES product_types (id),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Insere taxa de imposto em cada tipo de produto na tabela
INSERT INTO product_type_tax_rates (tax_rate, product_type_id, created_at, updated_at) VALUES(10, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO product_type_tax_rates (tax_rate, product_type_id, created_at, updated_at) VALUES(8, 2, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO product_type_tax_rates (tax_rate, product_type_id, created_at, updated_at) VALUES(10, 3, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Cria tabela "sales"
CREATE TABLE sales(
    id SERIAL PRIMARY KEY,
    quantity INT,
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES products (id),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Insere vendas na tabela
INSERT INTO sales (quantity, product_id, created_at, updated_at) VALUES(5, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO sales (quantity, product_id, created_at, updated_at) VALUES(10, 6, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO sales (quantity, product_id, created_at, updated_at) VALUES(1, 7, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);