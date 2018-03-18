use sheet_cutting;

-- View Inventory (only sheets available in inventory)
SELECT sheet_type, description, name, height, width, price, count(obj_id) as 'In Stock'
FROM SHEET_INVENTORY s
INNER JOIN SHEETS h on s.variant_id = h.variant_id and s.size = h.size
INNER JOIN VARIANTS v on h.variant_id = v.variant_id
INNER JOIN CUT_SIZES c on h.size = c.cut_id
GROUP BY s.variant_id, s.size;

-- View Inventory (ALL styles of sheets and sizes and it's inventory count)
SELECT sheet_type, description, name, height, width, price, count(obj_id) as 'In Stock'
FROM SHEETS h 
INNER JOIN VARIANTS v on h.variant_id = v.variant_id
INNER JOIN CUT_SIZES c on h.size = c.cut_id
LEFT JOIN SHEET_INVENTORY s on s.variant_id = h.variant_id and s.size = h.size
GROUP BY h.variant_id, h.size;

-- View Variants
SELECT * 
FROM VARIANTS;

-- View Cut Plans/Sizes
SELECT * 
FROM CUT_SIZES;

-- View All Styles of Sheets (Variants x Sizes) and their information
SELECT sheet_type, description, name, height, width, price 
FROM SHEETS h 
INNER JOIN VARIANTS v on h.variant_id = v.variant_id
INNER JOIN CUT_SIZES c on h.size = c.cut_id;

-- Customer orders 10 x 10 carribean blue sheet
--need to be implemented in php somehow to check parents of parents 
-- First, check if 10 x 10 carribean available
SELECT *
FROM SHEET_INVENTORY s
INNER JOIN SHEETS h on s.variant_id = h.variant_id and s.size = h.size
INNER JOIN VARIANTS v on h.variant_id = v.variant_id
INNER JOIN CUT_SIZES c on h.size = c.cut_id
WHERE name = 'carribean blue' AND height = 10 AND width = 10; -- outputs no data

-- Check parents of 10 x 10
SELECT * 
FROM CUT_SIZES
WHERE height = 10 and width = 10; -- parent_id outputs 3 and 4

-- Check Inventory for carribean blue in cut 3 and 4 -- outputs no data
-- else set parent sizes as current size and check their parents
SELECT * 
FROM CUT_SIZES
WHERE cut_id = 3 or cut_id = 4; -- parent_id outputs 1 and 2

-- Check Inventory for carribean blue in cut 1 and 2 
SELECT *
FROM SHEET_INVENTORY s
INNER JOIN SHEETS h on s.variant_id = h.variant_id and s.size = h.size
INNER JOIN VARIANTS v on h.variant_id = v.variant_id
INNER JOIN CUT_SIZES c on h.size = c.cut_id
WHERE name = 'carribean blue' AND cut_id = 1;