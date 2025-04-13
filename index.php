<?php
require 'includes/config.php';
require 'includes/functions.php';
$products = getProducts($conn);
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Website Thương Mại Điện Tử</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <h1>Website Thương Mại Điện Tử</h1>
        <div class="user-menu">
            <?php if (isset($_SESSION['customer_id'])): ?>
                <span>Xin chào, <?php echo $_SESSION['customer_username']; ?></span>
                <a href="logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="login.php">Đăng nhập</a>
                <a href="register.php">Đăng ký</a>
            <?php endif; ?>
            <a href="admin/login.php">Quản trị</a>
        </div>
    </div>
    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h2><a href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h2>
                <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>