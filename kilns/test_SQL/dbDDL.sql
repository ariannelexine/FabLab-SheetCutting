use `fabapp-v0.9`;

CREATE TABLE sheet_type (
  type_id INT PRIMARY KEY AUTO_INCREMENT,
  type VARCHAR(30)
);

CREATE TABLE variants (
  variant_id VARCHAR(10) PRIMARY KEY,
  description VARCHAR(15),
  name VARCHAR(30),
  colorhex VARCHAR(6),
  type_id INT REFERENCES sheet_type(type_id)
);

-- Auto increment? 
CREATE TABLE cut_sizes (
  cut_id INT PRIMARY KEY,
  width INT,  
  height INT,
  price DECIMAL,
  child_id INT REFERENCES CUT_SIZES(cut_id),
  amount INT,
  type_id INT REFERENCES sheet_type(type_id)
);

CREATE TABLE sheet_inventory (
  obj_id INT PRIMARY KEY AUTO_INCREMENT,
  trans_id INT,
  variant_id INT,
  cut_id INT,
  staff_id VARCHAR(10),
  removed_date datetime
);
