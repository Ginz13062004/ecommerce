<?php
require 'includes/config.php';
require 'includes/functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$product = getProductById($conn, $_GET['id']);
if (!$product) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="product-detail">
        <h1><?php echo $product['name']; ?></h1>
        <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <p><?php echo $product['description']; ?></p>
        <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
        <a href="index.php" class="back-link">Quay lại</a>
    </div>
</body>
</html>