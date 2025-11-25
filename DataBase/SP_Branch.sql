DELIMITER //
CREATE PROCEDURE SP_Branch (
	IN _id INT,
	IN _branch_name VARCHAR(150),
	IN _location VARCHAR(255)
	 
	
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM Branches WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE Branches SET branch_name = _branch_name, location = _location WHERE id = _id;
		
	ELSE
		INSERT INTO Branches (id, branch_name, location) VALUES (_id, _branch_name, _location);	 
	END IF;
END // 