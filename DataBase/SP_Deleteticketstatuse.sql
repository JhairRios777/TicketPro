DELIMITER //
CREATE PROCEDURE SP_Deleteticketstatus (
	IN _id INTEGER
) 
BEGIN

	DELETE FROM TicketStatuses WHERE id=_id;
END //