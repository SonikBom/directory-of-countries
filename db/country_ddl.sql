-- создание БД
DROP DATABASE IF EXISTS country_db_pv225;
CREATE DATABASE country_db_pv225;
-- переключение на данную БД
USE country_db_pv225;
-- создание таблицы стран
CREATE TABLE country_t (
	id INT NOT NULL AUTO_INCREMENT,
    shortName NVARCHAR(200)  NOT NULL,
    fullName NVARCHAR(200) NOT NULL,
    isoAlpha2 CHAR(2) NOT NULL,
    isoAlpha3 CHAR(3) NOT NULL,
    isoNumeric Char(5) NOT NULL,
    population INT NOT NULL,
    square  INT NOT NULL,
    --
    PRIMARY KEY(id),
    UNIQUE(isoAlpha2)
);
