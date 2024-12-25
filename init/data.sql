USE yeticave;

INSERT INTO categories (name, code)
VALUES 
	('Доски и лыжи','boards'),
	('Крепления','attachment'),
	('Ботинки','boots'),
	('Одежда','clothing'),
	('Инструменты','tools'),
	('Разное','other');

INSERT INTO users (reg_date, email, name, password, contact)
VALUES
	('2024-01-25', 'test1@mail.ru', 'test1', 'test1', 'test1@mail.ru'),
	('2024-02-25', 'test2@mail.ru', 'test2', 'test2', 'test2@mail.ru'),
	('2024-03-25', 'test3@mail.ru', 'test3', 'test3', 'test3@mail.ru');

INSERT INTO lots (create_date, name, category_id, start_price, image, finsh_date, discription, bet_stage, creator_id, winner_id)
VALUES
	( DEFAULT, '2014 Rossignol District Snowboard', '1', '10999', 'img/lot-1.jpg','2024-12-26', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', '100', '1', '2'),
	('2024-12-24', 'DC Ply Mens 2016/2017 Snowboard', '1', '159999', 'img/lot-2.jpg','2025-01-26', 'DC Ply Mens 2016/2017 Snowboard', '100', '1', '2'),
	('2024-12-25', 'Крепления Union Contact Pro 2015 года размер L/XL', '2', '8000', 'img/lot-3.jpg','2025-01-03', 'Крепления Union Contact Pro 2015 года размер L/XL', '100', '1', '3'),
	('2024-12-24', 'Ботинки для сноуборда DC Mutiny Charocal', '3', '10999', 'img/lot-4.jpg', '2024-12-30', 'Ботинки для сноуборда DC Mutiny Charocal', '100', '1', '3'),
	('2024-12-25', 'Куртка для сноуборда DC Mutiny Charocal', '4', '7500', 'img/lot-5.jpg', '2024-12-31', 'Куртка для сноуборда DC Mutiny Charocal', '100', '2', NULL),
	('2024-12-24', 'Маска Oakley Canopy', '6', '5400', 'img/lot-6.jpg', '2025-02-01', 'Маска Oakley Canopy', '100', '2', NULL);

INSERT INTO bets (bet_date, price, user_id, lot_id)
VALUES
	('2024-12-26 00:33:00', '11099', '2', '1'),
	('2024-12-26 00:34:00', '11199', '3', '1'),
	('2024-12-26 00:34:30', '11299', '2', '1'),
	('2024-12-26 00:51:38', '160099', '2', '2'),
	('2024-12-26 00:51:38', '8100', '3', '3'),
	('2024-12-24 00:51:38', '11099', '3', '4');
