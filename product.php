<?php
require 'includes/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = 1;
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <h1>Cửa hàng</h1>
        <div class="user-menu">
            <?php if (isset($_SESSION['customer_id'])): ?>
                <span>Xin chào, <?php echo $_SESSION['customer_username']; ?></span>
                <a href="logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="login.php">Đăng nhập</a>
                <a href="register.php">Đăng ký</a>
            <?php endif; ?>
            <a href="cart.php">Giỏ hàng</a>
        </div>
    </div>
    <div class="product-detail">
        <h1><?php echo $product['name']; ?></h1>
        <img src="images/<?php echo $product['image']; ?>">
        <p><?php echo $product['description']; ?></p>
        <p class="price"><?php echo number_format($product['price']); ?> VND</p>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
            <button name="add_to_cart" class="back-link">Thêm vào giỏ</button>
        </form>
        <a href="index.php" class="back-link">Quay lại</a>
    </div>
</body>
</html>