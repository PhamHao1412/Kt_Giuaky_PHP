<?php
require_once("config/db.class.php");

session_start(); // Start a session to store error messages (optional)

if (isset($_POST['submit'])) {
  // Validate form data (improvements based on feedback)
  $errors = [];

  $ma_nv = trim($_POST['ma_nv']);
  if (empty($ma_nv)) {
    $errors['ma_nv'] = 'Employee ID is required.';
  } else if (!preg_match('/^[A-Z0-9]+$/', $ma_nv)) {
    $errors['ma_nv'] = 'Employee ID can only contain uppercase letters and numbers.';
  }

  $ten_nv = trim($_POST['ten_nv']);
  if (empty($ten_nv)) {
    $errors['ten_nv'] = 'Employee name is required.';
  }

  $phai = $_POST['phai']; // Assuming dropdown or radio button selection, validation might not be needed

  $noi_sinh = trim($_POST['noi_sinh']);
  if (empty($noi_sinh)) {
    $errors['noi_sinh'] = 'Place of birth is required.';
  }

  $ma_phong = $_POST['ma_phong']; // Assuming dropdown or radio button selection, validation might be needed

  $luong = trim($_POST['luong']);
  if (empty($luong)) {
    $errors['luong'] = 'Salary is required.';
  } else if (!is_numeric($luong) || $luong <= 0) {
    $errors['luong'] = 'Salary must be a positive number.';
  }

  if (empty($errors)) {
    try {
      // Improved database interaction with prepared statements for security
      $db = new Db();
      $sql = "INSERT INTO nhanvien (Ma_Nv, Ten_Nv, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ssssss', $ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
        $_SESSION['success'] = 'Employee added successfully!'; // Optional success message for session
        header('Location: index.php'); // Redirect to a suitable page (e.g., employee list)
        exit;
      } else {
        $errors['general'] = 'An error occurred while adding the employee.'; // Generic error if insertion fails
      }

      $stmt->close(); // Close the prepared statement
    } catch (Exception $e) {
      $errors['general'] = 'Database error: ' . $e->getMessage(); // Handle database errors more gracefully
    }
  }
}

// Retrieve department list (assuming `phongban` table exists)
$db = new Db();
$sql = "SELECT Ma_Phong, Ten_Phong FROM phongban";
$departments = $db->select_to_array($sql);

include("templates/addEmployee_form.php"); // Include the form template
