<?php
session_start(); // Bắt đầu session để có thể truy cập vào biến session

// Kiểm tra xem vai trò của người dùng có phải là admin hay không
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $isAdmin = true;
} else {
    $isAdmin = false;
}

// Kiểm tra xem có sự cố xảy ra khi lưu vai trò trong session không
if (!isset($_SESSION['role'])) {
    // Nếu không, đặt vai trò mặc định
    $_SESSION['role'] = 'user';
}

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Số lượng nhân viên trên mỗi trang
$employeesPerPage = 5;

// Lấy số trang hiện tại từ tham số truyền vào, mặc định là trang 1
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Tính chỉ số bắt đầu và kết thúc của nhân viên trên trang hiện tại
$start = ($current_page - 1) * $employeesPerPage;

// Include file entities/employee.class.php và config/db.class.php
require_once("entities/employee.class.php");
require_once("config/db.class.php");

// Lấy số lượng nhân viên
$totalEmployees = Employee::count_employees();

// Tính tổng số trang
$totalPages = ceil($totalEmployees / $employeesPerPage);

// Lấy danh sách nhân viên cho trang hiện tại
$employees = Employee::list_employee_paginated($start, $employeesPerPage);

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
              <a href='employee_information.php?id=<?php echo $employee['Ma_Nv']; ?>' onclick='return confirmDelete()'>Delete</a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Phân trang -->
  <?php if ($totalPages > 1) : ?>
    <div>
      <?php if ($current_page > 1) : ?>
        <a href="?page=<?php echo $current_page - 1; ?>">Previous</a>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <?php if ($i == $current_page) : ?>
          <span><?php echo $i; ?></span>
        <?php else : ?>
          <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
      <?php endfor; ?>
      <?php if ($current_page < $totalPages) : ?>
        <a href="?page=<?php echo $current_page + 1; ?>">Next</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <script>
    function confirmDelete() {
      // Display confirmation message before deleting
      return confirm("Are you sure you want to delete this employee?");
    }
  </script>
</body>
</html>
