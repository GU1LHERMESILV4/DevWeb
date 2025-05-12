-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS fiap;
USE fiap;

-- Criação da tabela alunos
CREATE TABLE IF NOT EXISTS alunos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    ra VARCHAR(20) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    curso VARCHAR(100)
);
