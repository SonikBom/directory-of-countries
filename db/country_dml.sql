-- заполнение БД
USE country_db_pv225;
-- удалить данные
TRUNCATE TABLE country_t;
-- добавить данные
INSERT INTO country_t (
	shortName,
    fullName,
    isoAlpha2,
    isoAlpha3,
    isoNumeric,
    population,
    square
) VALUES 
	('Россия','Российская Федерация','RU','RUS','643', 146150789, 17125191),
    ('Англия', 'Великобритания', 'EN', 'ENG', '392', 57106398 ,133396),
    ('Швеция', 'Швеция', 'SE', 'SER', '752', 10551707, 450295),
    ('Франция', 'Франция', 'FR', 'FRA', '250', 68373433, 643801),
    ('Италия', 'Италия', 'IT', 'ITA', '380', 58968501, 302073);
-- получим данные
SELECT * FROM country_t;