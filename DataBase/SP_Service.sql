DELIMITER //
CREATE PROCEDURE SP_Service (
	IN _id INT,
	IN _name VARCHAR(150),
	IN _description VARCHAR(255)
	
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM Services WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE Services SET `name` = _name, description = _description WHERE id = _id;
		
	ELSE
		INSERT INTO Services (id, `name`, description) VALUES (_id, _name, _description);	 
	END IF;
END // 