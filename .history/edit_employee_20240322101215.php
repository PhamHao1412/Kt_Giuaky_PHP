<?php
require_once("config/db.class.php");
require_once("Employee.php"); // Chỉnh sửa đường dẫn nếu cần thiết

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_nv = $_POST["ma_nv"];
    $ten_nv = $_POST["ten_nv"];
    $phai = $_POST["phai"];
    $noi_sinh = $_POST["noi_sinh"];
    $ma_phong = $_POST["ma_phong"];
    $luong = $_POST["luong"];

    $result = Employee::editEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);
    if ($result) {
        echo "Cập nhật thông tin nhân viên thành công!";
    } else {
        echo "Đã xảy ra lỗi khi cập nhật thông tin nhân viên!";
    }
} elseif (isset($_GET["ma_nv"])) {
    $ma_nv = $_GET["ma_nv"];
    $db = new Db();
    $sql = "SELECT * FROM nhanvien WHERE Ma_Nv='$ma_nv'";
    $employee = $db->select_to_array($sql);
    if (count($employee) > 0) {
        $employee = $employee[0];
    } else {
        echo "Không tìm thấy nhân viên!";
        exit();
    }
} else {
    echo "Thiếu thông tin nhân viên cần cập nhật!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
</head>
<body>
    <h2>Cập nhật thông tin nhân viên</h2>
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
