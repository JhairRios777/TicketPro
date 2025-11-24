CREATE DATABASE IF NOT EXISTS TicketPro;
	DEFAULT CHARACTER SET utf8mb4
	DEFAULT COLLATE utf8mb4_unicode_ci;
	
USE TicketPro;

/*Tabla de Roles*/
CREATE TABLE IF NOT EXISTS Roles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(100) NOT NULL,
	description VARCHAR(255)
);

/*Tabla de Sucursales*/
CREATE TABLE IF NOT EXISTS Branches (
	id INT AUTO_INCREMENT PRIMARY KEY,
	branch_name VARCHAR(150) NOT NULL,
	location VARCHAR(255)
);

/*Tabla de Tipos de Clientes*/
CREATE TABLE IF NOT EXISTS ClientTypes (
	id INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(150) NOT NULL,
	description VARCHAR(255)
);

/*Tabla de Servicios*/
CREATE TABLE IF NOT EXISTS Services (
	id INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(150) NOT NULL,
	description VARCHAR(255)
);

/*Tabla de Estados de Ticket*/
CREATE TABLE IF NOT EXISTS TicketStatuses (
	id INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(150) NOT NULL,
	description VARCHAR(255)
);

/*Tabla de Usuarios*/
CREATE TABLE IF NOT EXISTS Users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(150) NOT NULL,
	username VARCHAR(100) UNIQUE NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	service_id INT NOT NULL,
	role_id INT NOT NULL,
	email VARCHAR(150) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	`status` ENUM('Active', 'Inactive') DEFAULT 'Active',
	CONSTRAINT fk_user_service FOREIGN KEY (service_id) REFERENCES Services(id),
	CONSTRAINT fk_user_role FOREIGN KEY (role_id) REFERENCES Roles(id)
);

/*Tabla de Puestos de Atención*/
CREATE TABLE IF NOT EXISTS ServiceDesks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	branch_id INT NOT NULL,
	desk_name VARCHAR(150) NOT NULL,
	CONSTRAINT fk_desk_user FOREIGN KEY (user_id) REFERENCES Users(id),
	CONSTRAINT fk_des_branch FOREIGN KEY (branch_id) REFERENCES Branches(id)
);

/*Tabla de Tickets*/
CREATE TABLE IF NOT EXISTS Tickets (
	id INT AUTO_INCREMENT PRIMARY KEY,
	ticket_code VARCHAR(10) NOT NULL,
	service_id INT NOT NULL,
	client_type_id INT NOT NULL,
	status_id INT NOT NULL,
	user_id INT NOT NULL,
	date_time DATETIME DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_ticket_service FOREIGN KEY (service_id) REFERENCES Services(id),
	CONSTRAINT fk_ticket_client_type FOREIGN KEY (client_type_id) REFERENCES ClientTypes(id),
	CONSTRAINT fk_ticket_status FOREIGN KEY (status_id) REFERENCES TicketStatuses(id),
	CONSTRAINT fk_ticket_user FOREIGN KEY (user_id) REFERENCES Users(id)
);

/*Tabla del Historial de los Tickets*/
CREATE TABLE IF NOT EXISTS TicketHistory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    status_id INT NOT NULL,
    user_id INT,
    date_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    observation VARCHAR(255),
    CONSTRAINT fk_history_ticket FOREIGN KEY (ticket_id) REFERENCES Tickets(id),
    CONSTRAINT fk_history_status FOREIGN KEY (status_id) REFERENCES TicketStatuses(id),
    CONSTRAINT fk_history_user FOREIGN KEY (user_id) REFERENCES Users(id)
);

/*Tabla de Auditoria*/
CREATE TABLE Audits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    desk_id INT,
    ticket_id INT,
    `action` VARCHAR(100) NOT NULL,
    details TEXT,
    date_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_audit_user FOREIGN KEY (user_id) REFERENCES Users(id),
    CONSTRAINT fk_audit_desk FOREIGN KEY (desk_id) REFERENCES ServiceDesks(id),
    CONSTRAINT fk_audit_ticket FOREIGN KEY (ticket_id) REFERENCES Tickets(id)
);

INSERT INTO Roles(`name`, description) VALUES ('Administrador', 'Administrador en el sistema');
INSERT INTO Roles(`name`, description) VALUES ('Empleado', 'Empleado del banco');
INSERT INTO Roles(`name`, description) VALUES ('Cliente', 'Usuario para la vista de los clientes');
INSERT INTO Roles(`name`, description) VALUES ('General', 'Usuario para la vista donde se muestran la cola de tickets');

INSERT INTO Services(`name`, description) VALUES ('Caja', 'Servicios de caja');
INSERT INTO Services(`name`, description) VALUES ('Atención al Cliente', 'Atención al cliente');

INSERT INTO Users(`name`, username, `password`, service_id, role_id, email, phone, `status`) VALUES ('Jhair Rios', 'jrios', '1234', 1, 1, 'jrios@bac.hn', '9999-9999', 'Active');
INSERT INTO Users(`name`, username, `password`, service_id, role_id, email, phone, `status`) VALUES ('Jorge Vallecillo', 'jvallecillo', '1234', 2, 2, 'jvallecillo@bac.hn', '8888-8888', 'Active');
INSERT INTO Users(`name`, username, `password`, service_id, role_id, email, phone, `status`) VALUES ('Cliente', 'cliente', '1234', 1, 3, 'cliente@bac.hn', '0000-0000', 'Active');
INSERT INTO Users(`name`, username, `password`, service_id, role_id, email, phone, `status`) VALUES ('General', 'general', '1234', 1, 4, 'general@bac.hn', '0000-0001', 'Active');

SELECT * FROM Users;
SELECT * FROM Services;
