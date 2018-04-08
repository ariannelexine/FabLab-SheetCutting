use `fabapp-v0.9`;

-- View Inventory 
-- size x variants restricted to sheet type
SELECT DISTINCT type, v.variant_id, name, width, height, price, count(obj_id) as 'In Stock'
FROM sheet_type s
LEFT JOIN cut_sizes as c ON s.type_id = c.type_id
LEFT JOIN variants as v ON s.type_id = v.type_id
LEFT JOIN sheet_inventory as i ON i.variant_id = v.variant_id AND i.cut_id = c.cut_id
WHERE i.removed_date IS NULL
GROUP BY name, width, height;

-- Select Materials
SELECT DISTINCT type
FROM sheet_type
ORDER BY type ASC;

-- Select Variants after sheet type selected (variants for glass)
SELECT variant_id, name
FROM variants
WHERE type_id = 1
ORDER BY name ASC;

-- Select cut sizes after sheet type selected
SELECT cut_id, width, height
FROM cut_sizes
WHERE type_id = 1;

-- Make a sale 
-- you should be able to pull of the variant and cut id as variables to use 
-- in this sql statement, so we won't need to join all the tables
SELECT * 
FROM sheet_inventory
WHERE obj_id = 
(SELECT max(obj_id)
FROM sheet_inventory s
WHERE variant_id = '0025' AND cut_id = 1);

-- object_id from above statement
UPDATE sheet_inventory 
SET staff_id = '000', removed_date = CURRENT_TIMESTAMP
WHERE obj_id = 2; 

-- Get parent of cut_size 10 x 10 
SELECT cut_id FROM cut_sizes WHERE width = 10 AND height = 10; -- returns 6

SELECT * FROM cut_sizes WHERE cut_id IN
(SELECT parent_id FROM cutsize_children WHERE child_id = 6);

use `fabapp-v0.9`;
SELECT DISTINCT type, v.variant_id, name, width, height, price, count(obj_id) as 'In Stock'
FROM sheet_type s
LEFT JOIN cut_sizes as c ON s.type_id = c.type_id
LEFT JOIN variants as v ON s.type_id = v.type_id
LEFT JOIN sheet_inventory as i ON i.variant_id = v.variant_id AND i.cut_id = c.cut_id
WHERE i.removed_date IS NULL AND v.variant_id = '1128'
GROUP BY name, width, height;


/* type
variant
count
from parent */

