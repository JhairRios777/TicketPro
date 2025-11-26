DELIMITER //
CREATE PROCEDURE SP_Deleteticketstatuse (
	IN _Id INTEGER
) 
BEGIN

	DELETE FROM TicketStatuses WHERE Id=_Id;
END //