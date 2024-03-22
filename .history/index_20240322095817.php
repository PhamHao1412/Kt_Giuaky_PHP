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
        // Đặt số lượng nhân viên hiển thị trên mỗi trang
        $employeesPerPage = 5;

        // Tính tổng số nhân viên
        $totalEmployees = count($employees);

        // Tính tổng số trang
        $totalPages = ceil($totalEmployees / $employeesPerPage);

        // Lấy trang hiện tại từ tham số truyền vào URL, mặc định là trang 1
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

        // Tính chỉ số bắt đầu và kết thúc của danh sách nhân viên trên trang hiện tại
        $startIndex = ($currentPage - 1) * $employeesPerPage;
        $endIndex = $startIndex + $employeesPerPage;

        // Lấy danh sách nhân viên cho trang hiện tại
        $currentEmployees = array_slice($employees, $startIndex, $employeesPerPage);

        // Hiển thị danh sách nhân viên
        if (!empty($currentEmployees)) {
          foreach ($currentEmployees as $employee) {
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

  <!-- Hiển thị liên kết phân trang -->
  <?php if ($totalPages > 1): ?>
    <div>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
      <?php endfor; ?>
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
