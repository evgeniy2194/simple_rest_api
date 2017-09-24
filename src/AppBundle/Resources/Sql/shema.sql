CREATE DATABASE rest_api;

CREATE TABLE inventories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_code VARCHAR(8) NOT NULL,
  allotment INT DEFAULT 0,
  price FLOAT NOT NULL,
  date DATETIME,
  discount INT DEFAULT NULL,
  max_pax INT DEFAULT 0
);

INSERT into inventories (room_code, allotment, price, date, discount, max_pax)
VALUES
('STDDBL', 2, 75, '2017-11-25', 10, 2),
('STDDBL', 1, 80, '2017-11-26', null, 2),
('STDDBL', 1, 50, '2017-11-27', null, 2),
('STDDBL', 0, 40, '2017-11-28', 15, 1),
('STDSNGL', 1, 40, '2017-11-25', null, 1),
('STDSNGL', 1, 40, '2017-11-26', null, 1),
('STDSNGL', 1, 40, '2017-11-27', 20, 1);