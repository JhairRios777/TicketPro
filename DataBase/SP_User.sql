DELIMITER //
CREATE PROCEDURE SP_User (
	IN _id INT,
	IN _name VARCHAR(150),
	IN _username VARCHAR(100),
	IN _password VARCHAR(255),
	IN _service_id INT,
	IN _role_id INT,
	IN _email VARCHAR(120),
	IN _phone VARCHAR(20),
	IN _status VARCHAR(15)
	
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM Users WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE Users SET `name` = _name, username = _username, `password` = _password, service_id = _service_id, role_id = _role_id, email = _email, phone = _phone, `status` = _status WHERE id = _id;
		
	ELSE
		INSERT INTO Users (id, `name`, username, `password`, service_id, role_id, email, phone, `status`) VALUES (_id, _name, _username, _password, _service_id, _role_id, _email, _phone, _status);	 
	END IF;
END // 