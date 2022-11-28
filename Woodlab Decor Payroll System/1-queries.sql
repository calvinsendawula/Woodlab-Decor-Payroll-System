-- 1. A SELECT query that uses a sub-query in the WHERE clause
SELECT * FROM `employee`
WHERE `salary` > (SELECT AVG(`salary`) FROM `employee`);

-- 2. A SELECT query that uses ORDER BY
SELECT * FROM `employee`
ORDER BY `salary` DESC;

-- 3. A SELECT query that uses GROUP BY and HAVING
SELECT `department_id`, AVG(`salary`) FROM `employee`
GROUP BY `department_id`
HAVING AVG(`salary`) > 50000;

-- 4. A SELECT query that uses a sub-query as a relation
SELECT * FROM `employee`
WHERE `department_id` IN (SELECT `department_id` FROM `employee`
                     WHERE `salary` > 50000);

-- 5. A SELECT query that uses INNER JOINS
SELECT `employee`.`firstname`, `department`.`name` FROM `employee`
INNER JOIN `department` ON `employee`.`department_id` = `department`.`id`;

-- 6. A SELECT query that uses partial matching in the WHERE clause
SELECT * FROM `employee`
WHERE `firstname` LIKE 'J%';

-- 7. A SELECT query that uses aggregate functions
SELECT COUNT(`firstname`) FROM `employee`;

-- 8. A SELECT query that uses a self-join
SELECT `employee1`.`firstname`, `employee2`.`firstname` FROM `employee` AS `employee1`
INNER JOIN `employee` AS `employee2` ON `employee1`.`department_id` = `employee2`.`department_id`
WHERE `employee1`.`firstname` < `employee2`.`firstname`;

-- 9. A query that creates a VIEW
CREATE VIEW `low_earners` AS
SELECT * FROM `employee`
WHERE `salary` < 50000;

-- 10. A query that uses a VIEW as a relation
SELECT * FROM `low_earners`;

-- 11. A trigger that is useful in the context of the database
-- Create trigger_test table
CREATE TABLE `trigger_test` (
    `message` VARCHAR(255)
);

-- Create trigger
DELIMITER $$
CREATE
    TRIGGER `my_trigger` BEFORE INSERT
    ON `employee`
    FOR EACH ROW BEGIN
        INSERT INTO trigger_test VALUES('added new employee');
    END$$
DELIMITER ;

-- At this point, we can insert a new employee and see the trigger in action
-- Open phpMyAdmin and insert a new employee
-- Go to the trigger_test table and see the message

-- 12. A query to encrypt user passwords when they are stored in the database
-- Create trigger
DELIMITER $$
CREATE
    TRIGGER `encrypt_password` BEFORE INSERT
    ON `users`
    FOR EACH ROW BEGIN
        SET NEW.password = MD5(NEW.password);
    END$$
DELIMITER ;