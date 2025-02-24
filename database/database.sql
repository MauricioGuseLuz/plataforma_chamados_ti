-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS plataforma_chamados;
USE plataforma_chamados;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    whatsapp VARCHAR(20) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    codigo_validacao VARCHAR(10),
    validado BOOLEAN DEFAULT 0
);

-- Tabela de chamados
CREATE TABLE IF NOT EXISTS chamados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    descricao TEXT NOT NULL,
    tipo_incidente VARCHAR(100) NOT NULL,
    data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de anexos
CREATE TABLE IF NOT EXISTS anexos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chamado_id INT NOT NULL,
    arquivo_base64 LONGTEXT NOT NULL,
    FOREIGN KEY (chamado_id) REFERENCES chamados(id)
);

-- Tabela de contatos do chamado
CREATE TABLE IF NOT EXISTS contatos_chamado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chamado_id INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    observacao TEXT,
    FOREIGN KEY (chamado_id) REFERENCES chamados(id)
);

-- Tabela de histórico do chamado
CREATE TABLE IF NOT EXISTS historico_chamado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chamado_id INT NOT NULL,
    descricao TEXT NOT NULL,
    data_evento DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chamado_id) REFERENCES chamados(id)
);