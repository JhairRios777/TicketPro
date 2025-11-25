DELIMITER //
CREATE PROCEDURE SP_ServiceDesk (
	IN _id INT,
	IN _user_id INT,
	IN _branch_id INT,
	IN _desk_name VARCHAR(150)
	
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM ServiceDesks WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE ServiceDesks SET user_id = _user_id, branch_id = _branch_id, desk_name = _desk_name WHERE id = _id;
		
	ELSE
		INSERT INTO ServiceDesks (id, user_id, branch_id, desk_name) VALUES (_id, _user_id, _branch_id, _desk_name);	 
	END IF;
END // 