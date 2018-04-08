use `fabapp-v0.9`;

-- variants                (variant_id, description, name, colorhex, type_id)
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

-- cut_sizes            (cut_id, width, height, price, child_id, amount, type_id)
INSERT INTO cut_sizes VALUES (0, 35, 20, 50.0, 2, 1, 1);
INSERT INTO cut_sizes VALUES (1, 35, 20, 50.0, 3, 1, 1);
INSERT INTO cut_sizes VALUES (2, 20, 20, 40.0, 4, 1, 1);
INSERT INTO cut_sizes VALUES (3, 20, 15, 35.0, 6, 2, 1);
INSERT INTO cut_sizes VALUES (4, 20, 10, 30.0, 7, 2, 1);
INSERT INTO cut_sizes VALUES (5, 15, 10, 25.0, 7, 1, 1);
INSERT INTO cut_sizes VALUES (6, 15, 10, 25.0, 8, 1, 1);
INSERT INTO cut_sizes VALUES (7, 10, 10, 20.0, 8, 2, 1);
INSERT INTO cut_sizes VALUES (8, 10, 5, 15.0, 9, 2, 1);
INSERT INTO cut_sizes VALUES (9, 5, 5, 10.0, NULL, NULL, 1);

INSERT INTO cut_sizes VALUES (10, 48, 96, 100.0, 12, 5, 2);
INSERT INTO cut_sizes VALUES (11, 48, 96, 100.0, 13, 1, 2);
INSERT INTO cut_sizes VALUES (12, 24, 36, 50.0, NULL, NULL, 2);
INSERT INTO cut_sizes VALUES (13, 12, 24, 0.0, NULL, NULL, 2);

-- sheet_type         (type_id, type)
INSERT INTO sheet_type (type) VALUES ('Glass'), ('Plywood');

-- sheet_inventory         (obj_id, trans_id, variant_id, cut_id, staff_id, removed_date)
INSERT INTO sheet_inventory (trans_id, variant_id, cut_id) VALUES (NULL, 0025, 1)
,(NULL, 0025, 1)
,(NULL, 0025, 1)
,(NULL, 0113, 1)
,(NULL, 0137, 2)
,(NULL, 1164, 1)
,(NULL, 1100, 1)
,(NULL, 1100, 1)
,(NULL, 1100, 5)
,(NULL, 1128, 6)
,(NULL, 1128, 6)
,(NULL, 1128, 5)
,(NULL, 1449, 2)
,(NULL, 0101, 1);
