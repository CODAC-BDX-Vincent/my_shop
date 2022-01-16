SELECT DISTINCT * FROM products,categories
WHERE products.name LIKE '%chaise%'
OR products.description LIKE '%chaise%'
OR categories.name LIKE '%chaise%';


SELECT DISTINCT * FROM products,categories
WHERE products.name LIKE '%table%'
   OR products.description LIKE '%table%'
   OR categories.name LIKE '%table%';


SELECT * FROM products WHERE CONCAT(name,description) LIKE "%designed%";


SELECT * FROM products INNER JOIN products.category_id=categories.id WHERE CONCAT(products.name,products.description) LIKE "%lit%"
AND categories.name LIKE "%lit%";

SELECT * FROM products INNER JOIN categories ON  categories.id=products.category_id WHERE CONCAT(products.name,products.description) LIKE "%lit%" OR categories.name LIKE "%lit%";