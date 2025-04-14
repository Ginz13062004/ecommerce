<?php
require 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_id'])) {
    unset($_SESSION['cart'][$_POST['remove_id']]);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center">Giỏ Hàng</h1>
        <?php if (empty($_SESSION['cart'])): ?>
            <div class="alert alert-info">Giỏ trống!</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $item) {
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                        echo "<tr>
                            <td>{$item['name']}</td>
                            <td>" . number_format($item['price']) . "</td>
                            <td>{$item['quantity']}</td>
                            <td>" . number_format($subtotal) . "</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='remove_id' value='$id'>
                                    <button class='btn btn-danger btn-sm'>X</button>
                                </form>
                            </td>
                        </tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="3"><b>Tổng:</b></td>
                        <td><?php echo number_format($total); ?></td>
                    </tr>
                </tbody>
            </table>
            <a href="checkout.php" class="btn btn-primary w-100">Thanh toán</a>
        <?php endif; ?>
        <p class="text-center mt-2"><a href="index.php" class="btn btn-secondary">Mua tiếp</a></p>
    </div>
</body>
</html>