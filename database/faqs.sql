CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL
);

INSERT INTO faqs (question, answer) 
VALUES ('What are the store hours?', 'Our store is open from 8:00 AM to 8:00 PM, Monday to Sunday.');
VALUES ('Do you offer home delivery?', 'Yes, we offer home delivery within a 5-mile radius. Delivery charges may apply.');
