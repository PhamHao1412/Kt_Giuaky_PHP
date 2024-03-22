<?php
require_once("config/db.class.php");

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin nhân viên từ form
    $ma_nv = $_POST["ma_nv"];
    $ten_nv = $_POST["ten_nv"];
    $phai = $_POST["phai"];
    $noi_sinh = $_POST["noi_sinh"];
    $ma_phong = $_POST["ma_phong"];
    $luong = $_POST["luong"];

    // Tạo đối tượng nhân viên mới
    $new_employee = new Employee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);

    // Thêm nhân viên vào cơ sở dữ liệu
    addEmployee($new_employee);
}

// Hàm thêm nhân viên vào cơ sở dữ liệu
function addEmployee($employee) {
    $db = new Db();
    $sql = "INSERT INTO nhanvien (Ma_Nv, Ten_Nv, Phai, Noi_Sinh, Ma_Phong, Luong) 
            VALUES ('{$employee->ma_nv}', '{$employee->ten_nv}', '{$employee->phai}', 
            '{$employee->noi_sinh}', '{$employee->ma_phong}', '{$employee->luong}')";
    $db->query_execute($sql);
    // Redirect về trang danh sách nhân viên sau khi thêm thành công
    header("Location: listEmployees.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>
    <h2>Add Employee</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="ma_nv">Mã nhân viên:</label><br>
        <input type="text" id="ma_nv" name="ma_nv"><br>
        <label for="ten_nv">Tên nhân viên:</label><br>
        <input type="text" id="ten_nv" name="ten_nv"><br>
        <label for="phai">Phái:</label><br>
        <input type="text" id="phai" name="phai"><br>
        <label for="noi_sinh">Nơi sinh:</label><br>
        <input type="text" id="noi_sinh" name="noi_sinh"><br>
        <label for="ma_phong">Mã phòng:</label><br>
        <input type="text" id="ma_phong" name="ma_phong"><br>
        <label for="luong">Lương:</label><br>
        <input type="text" id="luong" name="luong"><br><br>
        <input type="submit" value="Thêm nhân viên">
    </form>
</body>
</html>
