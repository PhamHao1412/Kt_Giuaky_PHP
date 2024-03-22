<?php
session_start();
require_once("config/db.class.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem nút Login đã được nhấn chưa
    if (isset($_POST["login"])) {
        // Lấy dữ liệu từ form
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Kiểm tra dữ liệu đã nhập
        if (!empty($username) && !empty($password)) {
            // Kết nối CSDL
            $conn = new DB();

            // Truy vấn để lấy thông tin user
            $sql = "SELECT * FROM user WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Kiểm tra xem user có tồn tại không
            if ($user) {
                // Kiểm tra mật khẩu
                if (password_verify($password, $user["password"])) {
                    // Đăng nhập thành công, lưu session và chuyển hướng
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["username"] = $user["username"];
                    $_SESSION["fullname"] = $user["fullname"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["role"] = $user["role"];
                    header("Location: home.php");
                    exit();
                } else {
                    // Mật khẩu không đúng
                    $error = "Incorrect password.";
                }
            } else {
                // User không tồn tại
                $error = "User not found.";
            }
        } else {
            // Thông báo lỗi khi dữ liệu nhập không đủ
            $error = "Please enter both username and password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
