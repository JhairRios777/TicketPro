
CREATE DATABASE IF NOT EXISTS ControlTickets
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;
USE ControlTickets;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Auditorias;
DROP TABLE IF EXISTS HistorialTickets;
DROP TABLE IF EXISTS Tickets;
DROP TABLE IF EXISTS EstadosTickets;
DROP TABLE IF EXISTS PuestosAtencion;
DROP TABLE IF EXISTS Usuarios;
DROP TABLE IF EXISTS Servicios;
DROP TABLE IF EXISTS TipoClientes;
DROP TABLE IF EXISTS Sucursal;
DROP TABLE IF EXISTS Roles;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE Roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255)
) 

CREATE TABLE Sucursal (
    id_sucursal INT AUTO_INCREMENT PRIMARY KEY,
    nom_sucursal VARCHAR(150) NOT NULL
) 

CREATE TABLE TipoClientes (
    id_tipo_cliente INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(150) NOT NULL
) 

CREATE TABLE Servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(200) NOT NULL
) 

CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    usuario VARCHAR(100) UNIQUE NOT NULL,
    contrasenia VARCHAR(255) NOT NULL,
    id_servicio INT,
    id_role INT,
    email VARCHAR(150),
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    CONSTRAINT fk_usuario_servicio FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio),
    CONSTRAINT fk_usuario_rol FOREIGN KEY (id_role) REFERENCES Roles(id_rol)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE PuestosAtencion (
    id_puesto_atencion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_sucursal INT NOT NULL,
    nombre_puesto VARCHAR(150) NOT NULL,
    CONSTRAINT fk_puestos_usuario FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    CONSTRAINT fk_puestos_sucursal FOREIGN KEY (id_sucursal) REFERENCES Sucursal(id_sucursal)
) 

CREATE TABLE EstadosTickets (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(100) NOT NULL
) 
CREATE TABLE Tickets (
    id_ticket INT AUTO_INCREMENT PRIMARY KEY,
    codigoticket VARCHAR(10) NOT NULL,
    id_servicio INT NOT NULL,
    id_tipo_cliente INT NOT NULL,
    id_estado INT NOT NULL,
    id_usuario INT,
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_tickets_servicio FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio),
    CONSTRAINT fk_tickets_tipocliente FOREIGN KEY (id_tipo_cliente) REFERENCES TipoClientes(id_tipo_cliente),
    CONSTRAINT fk_tickets_estado FOREIGN KEY (id_estado) REFERENCES EstadosTickets(id_estado),
    CONSTRAINT fk_tickets_usuario FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
) 

CREATE TABLE HistorialTickets (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_ticket INT NOT NULL,
    id_estado INT NOT NULL,
    id_usuario INT,
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    observacion VARCHAR(255),
    CONSTRAINT fk_hist_ticket FOREIGN KEY (id_ticket) REFERENCES Tickets(id_ticket),
    CONSTRAINT fk_hist_estado FOREIGN KEY (id_estado) REFERENCES EstadosTickets(id_estado),
    CONSTRAINT fk_hist_usuario FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
) 

CREATE TABLE Auditorias (
    id_registro INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_puesto_atencion INT,
    id_ticket INT,
    accion VARCHAR(100) NOT NULL,
    detalles TEXT,
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_auditoria_usuario FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    CONSTRAINT fk_auditoria_puesto FOREIGN KEY (id_puesto_atencion) REFERENCES PuestosAtencion(id_puesto_atencion),
    CONSTRAINT fk_auditoria_ticket FOREIGN KEY (id_ticket) REFERENCES Tickets(id_ticket)
) 
