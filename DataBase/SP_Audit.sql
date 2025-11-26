DELIMITER $$

USE `ticketpro`$$

DROP PROCEDURE IF EXISTS `SP_Audit`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Audit`(
  IN _id INT,
  IN _user_id INT,
  IN _desk_id INT,
  IN _ticket_id INT,
  IN _action VARCHAR(255),
  IN _details TEXT,
  IN _date_time DATETIME
)
BEGIN
  IF _id IS NULL OR _id = 0 OR _id = '' THEN
    INSERT INTO Audits (user_id, desk_id, ticket_id, ACTION, details, date_time)
    VALUES (_user_id, _desk_id, _ticket_id, _action, _details, _date_time);
  ELSE
    UPDATE Audits
    SET user_id = _user_id,
        desk_id = _desk_id,
        ticket_id = _ticket_id,
        `action` = _action,
        details = _details,
        date_time = _date_time
    WHERE id = _id;
  END IF;
END$$

DELIMITER ;