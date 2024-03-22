<?php
require_once("config/db.class.php");
        require_once("entities/employee.class.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_nv = $_POST["ma_nv"];
    $ten_nv = $_POST["ten_nv"];
    $phai = $_POST["phai"];
    $noi_sinh = $_POST["noi_sinh"];
    $ma_phong = $_POST["ma_phong"];
    $luong = $_POST["luong"];

    $result = Employee::addEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);
    if ($result) {
        echo "Thêm nhân viên thành công!";
    } else {
        echo "Đã xảy ra lỗi khi thêm nhân viên!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Employee</title>
</head>
<body>
    <h2>Thêm nhân viên mới</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Mã nhân viên: <input type="text" name="ma_nv"><br>
        Tên nhân viên: <input type="text" name="ten_nv"><br>
        Giới tính: <input type="text" name="phai"><br>
        Nơi sinh: <input type="text" name="noi_sinh"><br>
        Mã phòng: <input type="text" name="ma_phong"><br>
        Lương: <input type="text" name="luong"><br>
        <input type="submit" value="Thêm nhân viên">
    </form>
</body>
</html>
