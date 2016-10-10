#Вывести ошибки [:error], отсортированных по PHP Fatal error,PHP Warning, PHP Notice
SELECT log_description 
FROM log_table 
WHERE log_type=':error' 
ORDER BY FIELD(SUBSTRING_INDEX(log_description, ':', 1), "PHP Notice","PHP Warning","PHP Fatal error") DESC;

#Список ошибок которые повторялись несколько раз
SELECT log_description, COUNT(log_description) AS count
FROM log_table
WHERE log_type=':error'
GROUP BY log_description 
HAVING count > 1
ORDER BY count DESC;

#Общее кол-во повторяющихся ошибок
SELECT COUNT(log_description) - COUNT(DISTINCT log_description) AS 'duplicates'
FROM log_table;