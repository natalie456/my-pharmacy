<?php
$db = new PDO("sqlite:db/products.db");

// створимо таблицю, якщо ще не існує
$db->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    price INTEGER
)");

// додаємо кілька товарів
$db->exec("INSERT INTO products (name, price) VALUES 
    ('Парацетамол', 50),
    ('Ібупрофен', 70),
    ('Но-шпа', 60)
");

echo "Готово! Базу створено.";
?>