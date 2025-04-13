<?php
require '../includes/config.php';
require '../includes/functions.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$product = getProductById($conn, $_GET['id']);
if (!$product) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'] ?: $product['image'];

    if ($_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);
    }

    $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $_GET['id']);
    $stmt->execute();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Sản Phẩm</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Sửa Sản Phẩm</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>
        <label>Mô tả:</label><br>
        <textarea name="description"><?php echo $product['description']; ?></textarea><br>
        <label>Giá:</label><br>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required><br>
        <label>Hình ảnh:</label><br>
        <input type="file" name="image" accept="image/*"><br>
        <img src="../images/<?php echo $product['image']; ?>" width="100"><br>
        <button type="submit">Cập nhật</button>
    </form>
    <a href="index.php">Quay lại</a>
</body>
</html>