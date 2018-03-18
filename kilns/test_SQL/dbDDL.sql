use sheet_cutting;

CREATE TABLE SHEETS (
  variant_id INT REFERENCES VARIANTS(variant_id),
  size INT REFERENCES CUT_SIZES(cut_id),
  PRIMARY KEY(variant_id, size)
);

CREATE TABLE VARIANTS (
  variant_id INT PRIMARY KEY,
  sheet_type VARCHAR(15),
  description VARCHAR(15),
  name VARCHAR(30)
);

CREATE TABLE CUT_SIZES (
  cut_id INT PRIMARY KEY,
  height INT,
  width INT, 
  price DECIMAL,
  parent_id INT REFERENCES CUT_SIZES(cut_id)
);

CREATE TABLE SHEET_INVENTORY (
  obj_id INT PRIMARY KEY,
  variant_id INT,
  size INT,
  FOREIGN KEY (variant_id, size) REFERENCES SHEETS(variant_id, size)
);

