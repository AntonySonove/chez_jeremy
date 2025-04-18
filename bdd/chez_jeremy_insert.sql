CREATE DATABASE chez_jeremy;
USE chez_jeremy;

SELECT id_appointment, `hour`, `date`, is_booked, `name`, h.id_hairdresser 
FROM appointments AS a
INNER JOIN hairdressers AS h
ON a.id_hairdresser=h.id_hairdresser;

UPDATE appointments SET is_booked =1 WHERE `hour`="09:00";
UPDATE appointments SET is_booked =1 WHERE `hour`="09:30";

UPDATE appointments SET is_booked =0 WHERE `hour`="09:00";
UPDATE appointments SET is_booked =0 WHERE `hour`="09:30";

DELETE FROM appointments;
DELETE FROM booked_appointments;
DELETE FROM hairdressers;

DROP DATABASE chez_jeremy;