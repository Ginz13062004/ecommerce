<?php
require 'includes/config.php';
require 'includes/functions.php';
$products = getProducts($conn);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Website Thương Mại Điện Tử</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Danh Sách Sản Phẩm</h1>
    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h2><a href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h2>
                <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="admin/index.php">Quản lý sản phẩm</a>
</body>
</html>