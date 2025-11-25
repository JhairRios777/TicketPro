DELIMITER //
CREATE PROCEDURE SP_Ticket (
	IN _id INT,
	IN _ticket_code VARCHAR(10),
	IN _service_id INT,
	IN _client_type_id INT,
	IN _status_id INT,
	IN _user_id INT,
	IN _date_time DATETIME
) 
BEGIN

	DECLARE _Exists INTEGER;
	SELECT COUNT(id) FROM Tickets WHERE id = _id INTO _Exists;
	
	IF _Exists > 0 THEN
		UPDATE Tickets SET ticket_code = _ticket_code, service_id = _service_id, client_type_id = _client_type_id, status_id = _status_id, user_id = _user_id, date_time = _date_time WHERE id = _id;
		
	ELSE
		INSERT INTO Tickets (id, ticket_code, service_id, client_type_id, status_id, user_id, date_time) VALUES (_id, _ticket_code, _service_id, _client_type_id, _status_id, _user_id, _date_time);	 
	END IF;
END // 