SELECT DAYOFWEEK(start_day) FROM shift WHERE id = '1';

SELECT * FROM AMZ.shift;
SELECT * FROM AMZ.users;
SELECT * FROM AMZ.session;

SELECT * FROM session;
SELECT COUNT(*) FROM session WHERE id_session = '64e66b32a2ee0' AND end_session is null;
SELECT COUNT(*) FROM session WHERE id_session = '64e66b32a2ee0' AND end_session is null;
SELECT COUNT(*) FROM session WHERE id_session = '64e668b4510e6' AND end_session is null;

UPDATE shift SET start_day = '2023-08-31', week_day = '4', start_time = '12:00', end_time = '14:00' WHERE id = '1';
UPDATE shift SET start_day = '2023-12-15', week_day = '5', start_time = '08:01', end_time = '13:01' WHERE id = 1;



SELECT * FROM AMZ.shift_user;
SELECT max(id) as id_number FROM AMZ.shift;
truncate table AMZ.shift;
truncate table AMZ.users;
truncate table AMZ.shift_user;