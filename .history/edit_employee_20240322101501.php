<?php
require_once("config/db.class.php");
        require_once("entities/employee.class.php");

// Kiểm tra nếu form đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $ma_nv = $_POST["ma_nv"];
    $ten_nv = $_POST["ten_nv"];
    $phai = $_POST["phai"];
    $noi_sinh = $_POST["noi_sinh"];
    $ma_phong = $_POST["ma_phong"];
    $luong = $_POST["luong"];

    // Gọi phương thức sửa nhân viên từ class Employee
    $result = Employee::editEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);
    if ($result) {
        echo "Cập nhật thông tin nhân viên thành công!";
    } else {
        echo "Đã xảy ra lỗi khi cập nhật thông tin nhân viên!";
    }
} else {
    // Nếu không có dữ liệu POST, lấy mã nhân viên từ tham số trên URL
    if (isset($_GET["id"])) {
        $ma_nv = $_GET["id"];
        // Lấy thông tin nhân viên từ cơ sở dữ liệu
        $db = new Db();
        $sql = "SELECT * FROM nhanvien WHERE Ma_Nv='$ma_nv'";
        $result = $db->select_to_array($sql);
        // Kiểm tra xem nhân viên có tồn tại không
        if (count($result) > 0) {
            $employee = $result[0];
        } else {
            echo "Không tìm thấy nhân viên!";
            exit();
        }
    } else {
        echo "Thiếu thông tin nhân viên cần sửa!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
</head>
<body>
    <h2>Sửa thông tin nhân viên</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Mã nhân viên: <input type="text" name="ma_nv" value="<?php echo $employee['Ma_Nv']; ?>" readonly><br>
        Tên nhân viên: <input type="text" name="ten_nv" value="<?php echo $employee['Ten_Nv']; ?>"><br>
        Giới tính: <input type="text" name="phai" value="<?php echo $employee['Phai']; ?>"><br>
        Nơi sinh: <input type="text" name="noi_sinh" value="<?php echo $employee['Noi_Sinh']; ?>"><br>
        Mã phòng: <input type="text" name="ma_phong" value="<?php echo $employee['Ma_Phong']; ?>"><br>
        Lương: <input type="text" name="luong" value="<?php echo $employee['Luong']; ?>"><br>
        <input type="submit" value="Cập nhật thông tin">
    </form>
</body>
</html>
