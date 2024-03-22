<?php
require_once("config/db.class.php");

// Kiểm tra xem có tham số id được truyền qua không
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Lấy thông tin nhân viên từ cơ sở dữ liệu dựa trên id
    $employee = Employee::getEmployeeById($id);
    
    if(!$employee) {
        // Nếu không tìm thấy nhân viên, chuyển hướng hoặc hiển thị thông báo lỗi
        echo "Không tìm thấy nhân viên.";
        exit;
    }
} else {
    // Nếu không có id được truyền qua, chuyển hướng hoặc hiển thị thông báo lỗi
    echo "Lỗi: Không có mã nhân viên được cung cấp.";
    exit;
}

// Xử lý dữ liệu biểu mẫu khi được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem tất cả các trường đã được điền đầy đủ không
    if (isset($_POST['ma_nv'], $_POST['ten_nv'], $_POST['phai'], $_POST['noi_sinh'], $_POST['ma_phong'], $_POST['luong'])) {
        // Lấy dữ liệu từ biểu mẫu
        $ma_nv = $_POST['ma_nv'];
        $ten_nv = $_POST['ten_nv'];
        $phai = $_POST['phai'];
        $noi_sinh = $_POST['noi_sinh'];
        $ma_phong = $_POST['ma_phong'];
        $luong = $_POST['luong'];
        
        // Gọi phương thức để cập nhật thông tin nhân viên
        $result = Employee::updateEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);
        
        if ($result) {
            // Nếu cập nhật thành công, chuyển hướng hoặc hiển thị thông báo thành công
            echo "Cập nhật thành công!";
        } else {
            // Nếu cập nhật thất bại, hiển thị thông báo lỗi
            echo "Lỗi: Không thể cập nhật nhân viên.";
        }
    } else {
        // Nếu không đủ dữ liệu được gửi, hiển thị thông báo lỗi
        echo "Lỗi: Vui lòng điền đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>
    <h1>Edit Employee</h1>
    <form method="post">
        <label for="ma_nv">Mã NV:</label><br>
        <input type="text" id="ma_nv" name="ma_nv" value="<?php echo $employee['Ma_Nv']; ?>" readonly><br>
        <label for="ten_nv">Tên NV:</label><br>
        <input type="text" id="ten_nv" name="ten_nv" value="<?php echo $employee['Ten_Nv']; ?>"><br>
        <label for="phai">Phái:</label><br>
        <input type="text" id="phai" name="phai" value="<?php echo $employee['Phai']; ?>"><br>
        <label for="noi_sinh">Nơi Sinh:</label><br>
        <input type="text" id="noi_sinh" name="noi_sinh" value="<?php echo $employee['Noi_Sinh']; ?>"><br>
        <label for="ma_phong">Mã Phòng:</label><br>
        <input type="text" id="ma_phong" name="ma_phong" value="<?php echo $employee['Ma_Phong']; ?>"><br>
        <label for="luong">Lương:</label><br>
        <input type="text" id="luong" name="luong" value="<?php echo $employee['Luong']; ?>"><br><br>
        <input type="submit" value="Cập nhật">
    </form>
</body>
</html>
