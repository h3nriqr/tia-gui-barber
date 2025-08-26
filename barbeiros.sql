-- Apaga o banco caso exista
DROP DATABASE IF EXISTS barbeiros;

-- Cria o banco
CREATE DATABASE IF NOT EXISTS barbeiros;

USE barbeiros;

-- Tabela de Clientes
CREATE TABLE clientes ( 
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    fone VARCHAR(15),
    email VARCHAR(100),
    data_nascimento DATE NOT NULL,

    CONSTRAINT unico_cliente_cpf UNIQUE (cpf),
    CONSTRAINT unico_cliente_email UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Barbeiros
CREATE TABLE barbeiros ( 
    id_barbeiro INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    email VARCHAR(100),
    fone VARCHAR(15),

    CONSTRAINT unico_barbeiro_cpf UNIQUE (cpf),
    CONSTRAINT unico_barbeiro_email UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Serviços
CREATE TABLE servicos ( 
    id_servico INT PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    duracao_minutos INT NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Agendamentos
CREATE TABLE agendamentos ( 
    id_agendamento INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT NOT NULL, 
    id_barbeiro INT NOT NULL,
    id_servico INT NOT NULL,
    data_agendamento DATE NOT NULL,
    hora_agendamento TIME NOT NULL,

    status VARCHAR(20) DEFAULT 'Pendente',
    observacoes TEXT,
    
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_barbeiro) REFERENCES barbeiros(id_barbeiro) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_servico) REFERENCES servicos(id_servico) ON DELETE CASCADE ON UPDATE CASCADE,
    
    CONSTRAINT unico_cliente_agendamento UNIQUE (id_cliente, data_agendamento, hora_agendamento),
    CONSTRAINT unico_barbeiro_agendamento UNIQUE (id_barbeiro, data_agendamento, hora_agendamento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserção dos dados corrigida
INSERT INTO clientes (nome, cpf, fone, email, data_nascimento) VALUES 
('Pai do Lucas Style', '77788899900', '20048922', 'pdl@exemplo.com', '1980-02-28'),
('Clientonaldo', '44455566611', '23459876', 'clt@exemplo.com', '2001-04-01');

INSERT INTO barbeiros (nome, cpf, email, fone) VALUES 
('Lucas Style', '11122233300', 'l@s.com', '40028922'),
('Richard', '32112323122', 'r@r.com', '12129898');

INSERT INTO servicos (descricao, preco, duracao_minutos) VALUES 
('Cabelo', 30.00, 30),
('Barba', 20.00, 15),
('Cabelo + Barba', 45.00, 45);

INSERT INTO agendamentos (id_cliente, id_barbeiro, id_servico, data_agendamento, hora_agendamento) VALUES 
(1, 1, 1, '2025-04-27', '14:00'),
(2, 2, 2, '2025-04-27', '15:00'),
(2, 1, 3, '2025-04-30', '17:00');
