use `fabapp-v0.9`;

-- ---------------------- INSERT NEW MATERIAL ---------------------------------
-- sheet_type         (type_id, type)
/* User types in material name type (ex: Glass) into UI
Insert this value into sheet_type table and run this line to get
the auto incremented type_id */
INSERT INTO sheet_type (type) VALUES ('Glass');

-- ----------------- Add Variants to new material -----------------------------
-- variants                (variant_id, description, name, colorhex, type_id)
/* Have a box for variant id, description, name, hex (?)
    The type_id should be pulled from above entry (ex: since Glass was assigned type_id 1, 
    have a variable assigned with 1 and insert that as the type_id for these variants) */

/* ** IDK if you need this line but this just pulls out the id for glass and you use this number
    to insert as type_id into variants */
SELECT type_id FROM sheet_type WHERE type = 'Glass';

INSERT INTO variants VALUES ('0025', 'transparent', 'tangerine orange', NULL, 1);
INSERT INTO variants VALUES ('0113', 'transparent', 'white', NULL, 1);
INSERT INTO variants VALUES ('0120', 'transparent', 'canary yellow', NULL, 1);
INSERT INTO variants VALUES ('0137', 'transparent', 'french vanilla', NULL, 1);
INSERT INTO variants VALUES ('0221', 'transparent', 'citronelle', NULL, 1);
INSERT INTO variants VALUES ('0225', 'transparent', 'pimento red', NULL, 1);
INSERT INTO variants VALUES ('0920', 'transparent', 'warm white', NULL, 1);
INSERT INTO variants VALUES ('0101', 'transparent', 'stiff black', NULL, 1);
INSERT INTO variants VALUES ('0114', 'transparent', 'cobalt blue', NULL, 1);

INSERT INTO variants VALUES ('1025', 'opaque', 'light orange striker', NULL, 1);
INSERT INTO variants VALUES ('1116', 'opaque', 'turquoise blue', NULL, 1);
INSERT INTO variants VALUES ('1125', 'opaque', 'orange', NULL, 1);
INSERT INTO variants VALUES ('1212', 'opaque', 'deep green', NULL, 1);
INSERT INTO variants VALUES ('1320', 'opaque', 'marigold yellow', NULL, 1);
INSERT INTO variants VALUES ('1401', 'opaque', 'crystal clear', NULL, 1);
INSERT INTO variants VALUES ('1427', 'opaque', 'vernal green', NULL, 1);
INSERT INTO variants VALUES ('1464', 'opaque', 'true blue', NULL, 1);
INSERT INTO variants VALUES ('1128', 'opaque', 'deep royal purple', NULL, 1);
INSERT INTO variants VALUES ('1164', 'opaque', 'carribean blue', NULL, 1);
INSERT INTO variants VALUES ('1449', 'opaque', 'oregon grey', NULL, 1);

INSERT INTO variants VALUES ('1100', 'clear', 'tekta', NULL, 1);

-- ----------------- Add Cut Sizes to new material -----------------------------
-- cut_sizes            (cut_id, width, height, price, child_id, amount, type_id)
/* Insert all cut sizes first, cut_id is auto incremented
    Type_id also inserted the same way as variants, child_id and amount inserted next step */
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (35, 20, 50.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (20, 20, 40.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (20, 15, 35.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (20, 10, 30.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (15, 10, 25.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (10, 10, 20.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (10, 5, 15.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (5, 5, 10.0, 1);

-- ---------------------- Add Cut Sizes Children -----------------------------
-- cutsize_children            (childcut_id, parent_id, child_id, amount)
/* After inserting all cut sizes, for each cut size, user selects the child(ren) of that cut size */
-- User is selecting children for 35 x 20
SELECT cut_id FROM cut_sizes WHERE width = 35 AND height = 20; -- returns 1 as parent_id
-- User selects 20 x 20 as a child and adds 1 as amount
SELECT cut_id FROM cut_sizes WHERE width = 20 AND height = 20; -- Returns 2
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (1, 2, 1);
-- User adding a second child for 35 x 20, selects 20 x 15 with 1 as amount
SELECT cut_id FROM cut_sizes WHERE width = 20 AND height = 15; -- Returns 3
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (1, 3, 1);

-- User is selecting children for 20 x 20
SELECT cut_id FROM cut_sizes WHERE width = 20 AND height = 20; -- returns 2 as parent_id
-- User selects 20 x 10 as a child and adds 2 as amount
SELECT cut_id FROM cut_sizes WHERE width = 20 AND height = 10; -- Returns 4
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (2, 4, 2);

-- And so on and so forth with the rest of the parents
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (3, 5, 2); -- 20 x 15
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (4, 6, 2); -- 20 x 10 
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (5, 6, 1); -- 15 x 10 child 1
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (5, 7, 1); -- 15 x 10 child 2
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (6, 7, 2); -- 10 x 10 
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (7, 8, 2); -- 10 x 5


-- INSERT NEW MATERIAL (plywood)
INSERT INTO sheet_type (type) VALUES ('Plywood');
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (96, 48, 100.0, 2);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (24, 36, 50.0, 2);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (12, 24, 0.0, 2);

-- User is selecting children for 96 x 48
SELECT cut_id FROM cut_sizes WHERE width = 96 AND height = 48; -- returns 9 as parent_id
-- User selects 24 x 36 as a child and adds 5 as amount
SELECT cut_id FROM cut_sizes WHERE width = 24 AND height = 36; -- Returns 10
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (9, 10, 5);

INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (9, 11, 1); -- excess piece


-- ---------------------- INSERT NEW INVENTORY ---------------------------------
-- -- sheet_inventory         (obj_id, trans_id, variant_id, cut_id, staff_id, removed_date)
/* User first selects sheet type (Glass) */
use `fabapp-v0.9`;
SELECT type_id from sheet_type WHERE type = 'Glass'; -- return 1
/* SQL returns all the variants and cutsizes associated with that type */
SELECT * FROM variants WHERE type_id = 1 ORDER BY name ASC;
SELECT * FROM cut_sizes WHERE type_id = 1;

/* User selects variant tangerine orange in size 35 x 20 */
SELECT variant_id FROM variants WHERE name = 'tangerine orange'; -- returns 0025
SELECT cut_id FROM cut_sizes WHERE width = 35 AND height = 20; -- returns 1
INSERT INTO sheet_inventory (variant_id, cut_id) VALUES (0025, 1);

-- insert buncha other stuff 
INSERT INTO sheet_inventory (variant_id, cut_id) VALUES (0025, 1)
,(0025, 1)
,(0025, 1)
,(0113, 1)
,(0137, 2)
,(1164, 1)
,(1100, 1)
,(1100, 1)
,(1100, 5)
,(1128, 6)
,(1128, 6)
,(1128, 5)
,(1449, 2)
,(0101, 1);
