<?php 
$db = new PDO("sqlite:db/products.db");

// Отримуємо параметри фільтра
$search = isset($_GET['search']) ? $_GET['search'] : '';
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 1000;

// Запит з фільтрацією за назвою і ціною
$query = "SELECT * FROM products WHERE name LIKE :search AND price BETWEEN :min AND :max COLLATE NOCASE";
$stmt = $db->prepare($query);
$stmt->execute([
    'search' => "%$search%",
    'min' => $min_price,
    'max' => $max_price
]);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Товари з бази</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .filter-form {
      text-align: center;
      margin: 20px 0;
    }
    .filter-form input {
      padding: 8px;
      margin: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .filter-form button {
      padding: 8px 15px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    table {
      margin: 0 auto;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px 15px;
    }
  </style>
</head>
<body>

  <h1 style="text-align:center;">Список товарів</h1>

  <!-- 🔍 Центрована форма з фільтром за назвою і ціною -->
  <form method="get" class="filter-form">
    <input type="text" name="search" placeholder="Пошук за назвою" value="<?= htmlspecialchars($search) ?>">
    <input type="number" name="min_price" placeholder="Від" value="<?= htmlspecialchars($min_price) ?>" min="0">
    <input type="number" name="max_price" placeholder="До" value="<?= htmlspecialchars($max_price) ?>" min="0">
    <button type="submit">🔍 Фільтрувати</button>
  </form>

  <!-- 📋 Таблиця з товарами -->
  <table border="1">
    <tr>
      <th>Назва</th>
      <th>Ціна (грн)</th>
    </tr>
    <?php foreach ($products as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= $p['price'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

</body>
</html>