CREATE TABLE inventory (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Quantity INT NOT NULL
);

INSERT INTO inventory (Name, Quantity) VALUES
('Coffee Beans', 100),
('Milk', 50),
('Sugar', 75);

ALTER TABLE inventory AUTO_INCREMENT = 1;