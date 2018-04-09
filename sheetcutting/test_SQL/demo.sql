use `fabapp-v0.9`;

INSERT INTO sheet_type (type) VALUES ('Glass');

INSERT INTO variants VALUES ('0025', 'transparent', 'tangerine orange', 'F28500', 1);
INSERT INTO variants VALUES ('0113', 'transparent', 'white', 'FFFFFF', 1);
INSERT INTO variants VALUES ('0120', 'transparent', 'canary yellow', 'FFEF00', 1);
INSERT INTO variants VALUES ('0137', 'transparent', 'french vanilla', 'FFFEC0', 1);
INSERT INTO variants VALUES ('0221', 'transparent', 'citronelle', 'F29000', 1);
INSERT INTO variants VALUES ('0225', 'transparent', 'pimento red', 'D90702', 1);
INSERT INTO variants VALUES ('0920', 'transparent', 'warm white', 'efebd8', 1);
INSERT INTO variants VALUES ('0101', 'transparent', 'stiff black', '000000', 1);
INSERT INTO variants VALUES ('0114', 'transparent', 'cobalt blue', '0047ab', 1);

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
,(0101, 1)
,(0025, 1)
,(0113, 1)
,(0137, 1)
,(0221, 1)
,(0225, 1)
,(0920, 1)
,(0101, 1)
,(0114, 1)
,(1025, 1)
,(1116, 1)
,(1125, 1)
,(1212, 1)
,(1320, 1)
,(1401, 1)
,(1427, 1)
,(1464, 1)
,(1128, 1)
,(1164, 1)
,(1449, 1)
,(1100, 1)
,(0025, 2)
,(0113, 2)
,(0137, 2)
,(0221, 2)
,(0225, 2)
,(0920, 2)
,(0101, 2)
,(0114, 2)
,(1025, 2)
,(1116, 2)
,(1125, 2)
,(1212, 2)
,(1320, 2)
,(1401, 2)
,(1427, 2)
,(1464, 2)
,(1128, 2)
,(1164, 2)
,(1449, 2)
,(1100, 2);