<?php
require '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);
    }

    // Tìm ID nhỏ nhất chưa sử dụng
    $sql = "SELECT MIN(t1.id + 1) AS next_id FROM products t1 LEFT JOIN products t2 ON t2.id = t1.id + 1 WHERE t2.id IS NULL";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $next_id = $row['next_id'] ?: 1; // Nếu không có khoảng trống, lấy id = 1

    $sql = "INSERT INTO products (id, name, description, price, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issds", $next_id, $name, $description, $price, $image);
    $stmt->execute();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sản Phẩm</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Thêm Sản Phẩm</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" required><br>
        <label>Mô tả:</label><br>
        <textarea name="description"></textarea><br>
        <label>Giá:</label><br>
        <input type="number" name="price" step="0.01" required><br>
        <label>Hình ảnh:</label><br>
        <input type="file" name="image" accept="image/*" required><br>
        <button type="submit">Thêm</button>
    </form>
    <a href="index.php">Quay lại</a>
</body>
</html>