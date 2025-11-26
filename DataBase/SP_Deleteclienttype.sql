DELIMITER //
CREATE PROCEDURE SP_Deleteclienttype (
	IN _id INTEGER
) 
BEGIN

	DELETE FROM ClientTypes WHERE id= _id;
END //