DELIMITER //
CREATE PROCEDURE SP_Deleteservicedesk (
	IN _id INTEGER
) 
BEGIN

	DELETE FROM ServiceDesks WHERE id=_id;
END //