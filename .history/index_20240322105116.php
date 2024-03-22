<?php
require_once("config/db.class.php");
require_once("entities/employee.class.php");
session_start();

// Kiểm tra xem vai trò của người dùng có phải là admin hay không
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Đặt vai trò mặc định nếu không có trong session
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'user';
}

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Phân trang
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 5; // Số lượng nhân viên hiển thị trên mỗi trang
$start = ($page - 1) * $limit;

$employees = Employee::list_employee_paged($start, $limit); // Lấy dữ liệu từ cơ sở dữ liệu cho trang hiện tại
$total_pages = ceil(Employee::count_employees() / $limit); // Tính tổng số trang
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            text-align: left;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Employee Information</h1>
<?php if ($isAdmin) : ?>
    <!-- Nếu là admin, hiển thị liên kết Thêm nhân viên -->
    <a href="add_employee.php">Add Employee</a>
<?php endif; ?>
<table>
    <thead>
    <tr>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Gender</th>
        <th>Place of Birth</th>
        <th>Department</th>
        <th>Salary</th>
        <?php
        if ($isAdmin) {
            echo "<th>Action<th>";
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($employees)) {
        foreach ($employees as $employee) {
            echo "<tr>";
            echo "<td>" . $employee['Ma_Nv'] . "</td>";
            echo "<td>" . $employee['Ten_Nv'] . "</td>";
            echo "<td>" . $employee['Phai'] . "</td>";
            echo "<td>" . $employee['Noi_Sinh'] . "</td>";
            echo "<td>" . $employee['Ten_Phong'] . "</td>";
            echo "<td>" . $employee['Luong'] . "</td>";
            // Action column with edit and delete links
            echo "<td>";
            if ($isAdmin) {
                echo "<a href='edit_employee.php?id=" . $employee['Ma_Nv'] . "'>Edit</a> | "; // Edit link with employee ID
                echo "<a href='employee_delete.php?id=" . $employee['Ma_Nv'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa nhân viên này không?')\">Delete</a>";
            }
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No employees found!</td></tr>";
    }
    ?>
    </tbody>
</table>

<!-- Hiển thị phân trang -->
<div>
    <?php
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=".$i."' style='margin-right: 10px;' ";
        if($page == $i)
            echo "class='current'";
        echo ">".$i."</a>";
    }
    ?>
    </div>
</body>
</html>
