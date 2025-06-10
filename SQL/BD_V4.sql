CREATE DATABASE IF NOT EXISTS rede_social;
USE rede_social;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    nickname VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    bio TEXT,
    foto_perfil VARCHAR(255) DEFAULT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE publicacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    texto TEXT NOT NULL,
    data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    editado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE curtidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_publicacao INT NOT NULL,
    UNIQUE (id_usuario, id_publicacao),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_publicacao) REFERENCES publicacoes(id) ON DELETE CASCADE
);

CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_publicacao INT NOT NULL,
    texto TEXT NOT NULL,
    data_comentario DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_comentario_pai INT DEFAULT NULL,
    editado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_publicacao) REFERENCES publicacoes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_comentario_pai) REFERENCES comentarios(id) ON DELETE CASCADE
);

# CREATE TABLE curtidas_comentarios (
#    id INT AUTO_INCREMENT PRIMARY KEY,
#    id_usuario INT NOT NULL,
#    id_comentario INT NOT NULL,
#    UNIQUE (id_usuario, id_comentario),
#    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
#    FOREIGN KEY (id_comentario) REFERENCES comentarios(id) ON DELETE CASCADE
#);

CREATE TABLE seguidores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_seguidor INT NOT NULL,
    id_seguido INT NOT NULL,
    UNIQUE(id_seguidor, id_seguido),
    FOREIGN KEY (id_seguidor) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_seguido) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE auth_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    selector VARCHAR(255) NOT NULL,
    hashed_validator VARCHAR(255) NOT NULL,
    userid INT NOT NULL,
    expires DATETIME NOT NULL,
    FOREIGN KEY (userid) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);






