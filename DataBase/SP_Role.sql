DELIMITER //
CREATE PROCEDURE SP_Role (
	IN _id INT,
	IN _name VARCHAR(100),
	IN _description VARCHAR(255)
	
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM Roles WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE Roles SET `name` = _name, description = _description WHERE id = _id;
		
	ELSE
		INSERT INTO Roles (id, `name`, description) VALUES (_id, _name, _description);	 
	END IF;
END // 