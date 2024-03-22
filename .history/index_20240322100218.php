<?php
session_start(); // Bắt đầu session để có thể truy cập vào biến session

// Kiểm tra xem vai trò của người dùng có phải là admin hay không
if ($_SESSION['role'] === 'admin') {
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

// Lấy trang hiện tại từ tham số truyền vào
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán vị trí bắt đầu của dữ liệu trên mỗi trang
$start = ($current_page - 1) * $employeesPerPage;

require_once("entities/employee.class.php");
require_once("config/db.class.php");
$employees = Employee::list_employee($start, $employeesPerPage);

$totalEmployees = Employee::count_employees(); // Tính tổng số nhân viên
$totalPages = ceil($totalEmployees / $employeesPerPage); // Tính tổng số trang

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
                echo "<a href='employee_information.php?id=" . $employee['Ma_Nv'] . "' onclick='return confirmDelete()'>Delete</a>"; // Delete link with confirmation and employee ID
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
  
  <!-- Phân trang -->
  <div>
    <?php
      // Hiển thị liên kết đến các trang trước nếu trang hiện tại không phải là trang đầu tiên
      if ($current_page > 1) {
        echo "<a href='employee_information.php?page=1'>First</a>";
        echo "<a href='employee_information.php?page=".($current_page - 1)."'>Previous</a>";
      }
      
      // Hiển thị các liên kết tới các trang
      for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $current_page) {
          echo "<span>$i</span>";
        } else {
          echo "<a href='employee_information.php?page=$i'>$i</a>";
        }
      }
      
      // Hiển thị liên kết đến các trang tiếp theo nếu trang hiện tại không phải là trang cuối cùng
      if ($current_page < $totalPages) {
        echo "<a href='employee_information.php?page=".($current_page + 1)."'>Next</a>";
        echo "<a href='employee_information.php?page=$totalPages'>Last</a>";
      }
    ?>
  </div>
  
  <script>
    function confirmDelete() {
      // Display confirmation message before deleting
      return confirm("Are you sure you want to delete this employee?");
    }
  </script>
</body>
</html>
