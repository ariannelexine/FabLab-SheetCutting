use `fabapp-v0.9`;

INSERT INTO sheet_type (type) VALUES ('Glass');

INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0025', 'transparent', 'tangerine orange', 'F28500', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0113', 'transparent', 'white', 'FFFFFF', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0120', 'transparent', 'canary yellow', 'FFEF00', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0137', 'transparent', 'french vanilla', 'FFFEC0', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0221', 'transparent', 'citronelle', 'F29000', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0225', 'transparent', 'pimento red', 'D90702', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0920', 'transparent', 'warm white', 'efebd8', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0101', 'transparent', 'stiff black', '000000', 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('0114', 'transparent', 'cobalt blue', '0047ab', 1);

INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1025', 'opaque', 'light orange striker', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1116', 'opaque', 'turquoise blue', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1125', 'opaque', 'orange', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1212', 'opaque', 'deep green', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1320', 'opaque', 'marigold yellow', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1401', 'opaque', 'crystal clear', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1427', 'opaque', 'vernal green', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1464', 'opaque', 'true blue', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1128', 'opaque', 'deep royal purple', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1164', 'opaque', 'carribean blue', NULL, 1);
INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1449', 'opaque', 'oregon grey', NULL, 1);

INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES ('1100', 'clear', 'tekta', NULL, 1);

INSERT INTO cut_sizes (width, height, price, type_id) VALUES (35, 20, 50.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (20, 20, 40.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (20, 15, 35.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (20, 10, 30.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (15, 10, 25.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (10, 10, 20.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (10, 5, 15.0, 1);
INSERT INTO cut_sizes (width, height, price, type_id) VALUES (5, 5, 10.0, 1);

INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (1, 2, 1);
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (1, 3, 1);
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (2, 4, 2);
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (3, 5, 2); -- 20 x 15
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (4, 6, 2); -- 20 x 10 
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (5, 6, 1); -- 15 x 10 child 1
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (5, 7, 1); -- 15 x 10 child 2
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (6, 7, 2); -- 10 x 10 
INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES (7, 8, 2); -- 10 x 5


use `fabapp-v0.9`;
INSERT INTO sheet_inventory (variant_id, cut_id) VALUES (1, 1)
,(1, 1)
,(1, 1)
,(2, 1)
,(4, 2)
,(19, 1)
,(21, 1)
,(21, 1)
,(21, 5)
,(18, 6)
,(18, 6)
,(18, 5)
,(20, 2)
,(8, 1)
,(1, 1)
,(2, 1)
,(4, 1)
,(5, 1)
,(6, 1)
,(7, 1)
,(8, 1)
,(9, 1)
,(10, 1)
,(11, 1)
,(12, 1)
,(13, 1)
,(14, 1)
,(15, 1)
,(16, 1)
,(17, 1)
,(18, 1)
,(19, 1)
,(20, 1)
,(21, 1)
,(1, 2)
,(2, 2)
,(4, 2)
,(5, 2)
,(6, 2)
,(7, 2)
,(8, 2)
,(9, 2)
,(10, 2)
,(11, 2)
,(12, 2)
,(13, 2)
,(14, 2)
,(15, 2)
,(16, 2)
,(17, 2)
,(18, 2)
,(19, 2)
,(20, 2)
,(21, 2);