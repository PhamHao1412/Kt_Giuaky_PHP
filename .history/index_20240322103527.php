<?php
require_once("entities/employee.class.php");
require_once("config/db.class.php");

// Định nghĩa số lượng bản ghi mỗi trang
$records_per_page = 10;

// Xác định trang hiện tại
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

// Tính toán OFFSET cho truy vấn
$offset = ($current_page - 1) * $records_per_page;

// Lấy tổng số nhân viên từ cơ sở dữ liệu
$total_records = count(Employee::list_employee());

// Tính toán số trang
$total_pages = ceil($total_records / $records_per_page);

// Lấy danh sách nhân viên cho trang hiện tại
$employees = Employee::list_employee_paged($records_per_page, $offset);

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
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            padding: 5px 10px;
            border: 1px solid #ddd;
            text-decoration: none;
            margin: 0 5px;
        }
        .pagination a.active {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Employee Information</h1>
<table>
    <thead>
    <tr>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Gender</th>
        <th>Place of Birth</th>
        <th>Department</th>
        <th>Salary</th>
        <?php if ($isAdmin) : ?>
            <th>Action</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($employees as $employee) : ?>
        <tr>
            <td><?php echo $employee['Ma_Nv']; ?></td>
            <td><?php echo $employee['Ten_Nv']; ?></td>
            <td><?php echo $employee['Phai']; ?></td>
            <td><?php echo $employee['Noi_Sinh']; ?></td>
            <td><?php echo $employee['Ten_Phong']; ?></td>
            <td><?php echo $employee['Luong']; ?></td>
            <?php if ($isAdmin) : ?>
                <td>
                    <a href='edit_employee.php?id=<?php echo $employee['Ma_Nv']; ?>'>Edit</a> |
                    <a href='employee_delete.php?id=<?php echo $employee['Ma_Nv']; ?>' onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này không?')">Delete</a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Phân trang -->
<div class="pagination">
    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
        <a href="?page=<?php echo $page; ?>" class="<?php echo ($page == $current_page) ? 'active' : ''; ?>"><?php echo $page; ?></a>
    <?php endfor; ?>
</div>
</body>
</html>
