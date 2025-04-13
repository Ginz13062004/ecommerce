<?php
require '../includes/config.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debug: In ra dữ liệu nhận được
    echo "Username: $username<br>";
    echo "Password: $password<br>";

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Debug: In ra dữ liệu user
    echo "<pre>User: ";
    var_dump($user);
    echo "</pre>";

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        echo "Đăng nhập thành công, đang chuyển hướng...";
        header("Location: index.php");
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
        // Debug: Kiểm tra tại sao password_verify thất bại
        if ($user) {
            echo "Password verify failed. Hash: " . $user['password'] . "<br>";
        } else {
            echo "Không tìm thấy user.<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Đăng Nhập Admin</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Tên đăng nhập:</label><br>
        <input type="text" name="username" required><br>
        <label>Mật khẩu:</label><br>
        <input type="password" name="password" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>