DELIMITER //
CREATE PROCEDURE SP_ClientType (
	IN _id INT,
	IN _name VARCHAR(150),
	IN _description VARCHAR(255)
	
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM ClientTypes WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE ClientTypes SET `name` = _name, description = _description WHERE id = _id;
		
	ELSE
		INSERT INTO ClientTypes (id, `name`, description) VALUES (_id, _name, _description);	 
	END IF;
END // 