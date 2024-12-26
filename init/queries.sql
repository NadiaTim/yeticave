--получить все категории
SELECT name, code
FROM categories;


--получить самые новые, открытые лоты. 
--Каждый лот должен включать 
--название, стартовую цену, ссылку на изображение, цену, название категории;
SELECT l.id, l.name, l.start_price, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finish_date
FROM lots l
JOIN categories c 
ON l.category_id = c.category_id
LEFT JOIN (	SELECT lot_id, max(price) price
		FROM bets
		GROUP BY lot_id) p 
ON l.lot_id = p.lot_id
WHERE l.finsh_date>now()
ORDER BY l.create_date DESC;

--показать лот по его ID. 
--Получите также название категории, к которой принадлежит лот;
SELECT l.name, l.discription, l.start_price, l.image, c.name category, l.create_date, l.finsh_date
FROM lots l
JOIN categories c 
ON l.category_id = c.category_id;


--получить список ставок для лота по его идентификатору с сортировкой по дате.
SELECT bet_date, price
FROM bets
WHERE lot_id = 1
ORDER BY bet_date DESC;