<?php
require 'includes/config.php';

if (isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO customers (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    try {
        if ($stmt->execute()) {
            $success = "Đăng ký thành công! Vui lòng <a href='login.php'>đăng nhập</a>.";
        }
    } catch (mysqli_sql_exception $e) {
        $error = "Lỗi: Tên đăng nhập hoặc email đã tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Đăng Ký</h1>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
        <form method="POST">
            <label>Tên đăng nhập:</label><br>
            <input type="text" name="username" required><br>
            <label>Email:</label><br>
            <input type="email" name="email" required><br>
            <label>Mật khẩu:</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">Đăng ký</button>
        </form>
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
        <a href="index.php">Quay lại trang chủ</a>
    </div>
</body>
</html>