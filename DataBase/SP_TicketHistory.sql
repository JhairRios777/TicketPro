DELIMITER //
CREATE PROCEDURE SP_TicketHistory (
	IN _id INT,
	IN _ticket_id INT,
	IN _status_id INT,
	IN _user_id INT,
	IN _date_time DATETIME,
	IN _observation VARCHAR(255)
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM TicketHistory WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE TicketHistory SET ticket_id = _ticket_id, status_id = _status_id, user_id = _user_id, date_time = _date_time, observation = _observation WHERE id = _id;
		
	ELSE
		INSERT INTO TicketHistory (id, ticket_id, status_id, user_id, date_time, observation) VALUES (_id, _ticket_id, _status_id, _user_id, _date_time, _observation);	 
	END IF;
END // 