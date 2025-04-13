<?php
require '../includes/config.php';
require '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$products = getProducts($conn);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Quản Lý Sản Phẩm</h1>
    <p>Xin chào, <?php echo $_SESSION['admin_username']; ?> | <a href="logout.php">Đăng xuất</a></p>
    <a href="add_product.php">Thêm sản phẩm</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
                <td><img src="../images/<?php echo $product['image']; ?>" width="50"></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Sửa</a>
                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="../index.php">Quay lại trang chủ</a>
</body>
</html>