use sheet_cutting;

-- VARIANTS                (variant_id, sheet_type, description, name)
INSERT INTO VARIANTS VALUES (0025, 'Glass', 'transparent', 'tangerine orange');
INSERT INTO VARIANTS VALUES (0113, 'Glass', 'transparent', 'white');
INSERT INTO VARIANTS VALUES (0120, 'Glass', 'transparent', 'canary yellow');
INSERT INTO VARIANTS VALUES (0137, 'Glass', 'transparent', 'french vanilla');
INSERT INTO VARIANTS VALUES (0221, 'Glass', 'transparent', 'citronelle');
INSERT INTO VARIANTS VALUES (0225, 'Glass', 'transparent', 'pimento red');
INSERT INTO VARIANTS VALUES (0920, 'Glass', 'transparent', 'warm white');
INSERT INTO VARIANTS VALUES (0101, 'Glass', 'transparent', 'stiff black');
INSERT INTO VARIANTS VALUES (0114, 'Glass', 'transparent', 'cobalt blue');

INSERT INTO VARIANTS VALUES (1025, 'Glass', 'opaque', 'light orange striker');
INSERT INTO VARIANTS VALUES (1116, 'Glass', 'opaque', 'turquoise blue');
INSERT INTO VARIANTS VALUES (1125, 'Glass', 'opaque', 'orange');
INSERT INTO VARIANTS VALUES (1212, 'Glass', 'opaque', 'deep green');
INSERT INTO VARIANTS VALUES (1320, 'Glass', 'opaque', 'marigold yellow');
INSERT INTO VARIANTS VALUES (1401, 'Glass', 'opaque', 'crystal clear');
INSERT INTO VARIANTS VALUES (1427, 'Glass', 'opaque', 'vernal green');
INSERT INTO VARIANTS VALUES (1464, 'Glass', 'opaque', 'true blue');
INSERT INTO VARIANTS VALUES (1128, 'Glass', 'opaque', 'deep royal purple');
INSERT INTO VARIANTS VALUES (1164, 'Glass', 'opaque', 'carribean blue');
INSERT INTO VARIANTS VALUES (1449, 'Glass', 'opaque', 'oregon grey');

INSERT INTO VARIANTS VALUES (1100, 'Glass', 'clear', 'tekta');

-- CUT_SIZES               (cut_id, height, width, price, parent_id)
INSERT INTO CUT_SIZES VALUES (0, 35, 20, 50.0, null);
INSERT INTO CUT_SIZES VALUES (1, 20, 20, 40.0, 0);
INSERT INTO CUT_SIZES VALUES (2, 20, 15, 35.0, 0);
INSERT INTO CUT_SIZES VALUES (3, 20, 10, 30.0, 1);
INSERT INTO CUT_SIZES VALUES (4, 15, 10, 25.0, 2);
INSERT INTO CUT_SIZES VALUES (5, 10, 10, 20.0, 3);
INSERT INTO CUT_SIZES VALUES (6, 10, 10, 20.0, 4);
INSERT INTO CUT_SIZES VALUES (7, 10, 5, 15.0, 6);
INSERT INTO CUT_SIZES VALUES (8, 5, 5, 10.0, 7);

-- SHEETS         The VARIANTS and CUT_SIZES tables cross joined
INSERT INTO SHEETS
SELECT variant_id, cut_id
FROM VARIANTS, CUT_SIZES;

-- SHEET_INVENTORY               (obj_id, variant_id, size)
INSERT INTO SHEET_INVENTORY VALUES (000, 0025, 0);
INSERT INTO SHEET_INVENTORY VALUES (001, 0025, 0);
INSERT INTO SHEET_INVENTORY VALUES (002, 0025, 0);
INSERT INTO SHEET_INVENTORY VALUES (003, 0113, 0);
INSERT INTO SHEET_INVENTORY VALUES (004, 0137, 2);
INSERT INTO SHEET_INVENTORY VALUES (005, 1164, 1);
INSERT INTO SHEET_INVENTORY VALUES (006, 1100, 1);
INSERT INTO SHEET_INVENTORY VALUES (012, 1100, 1);
INSERT INTO SHEET_INVENTORY VALUES (007, 1100, 5);
INSERT INTO SHEET_INVENTORY VALUES (008, 1128, 6);
INSERT INTO SHEET_INVENTORY VALUES (013, 1128, 6);
INSERT INTO SHEET_INVENTORY VALUES (009, 1128, 5);
INSERT INTO SHEET_INVENTORY VALUES (010, 1449, 2);
INSERT INTO SHEET_INVENTORY VALUES (011, 0101, 1);