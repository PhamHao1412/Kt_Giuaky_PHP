<?php
require_once("config/db.class.php");

// Check if ID is provided
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve employee details
    $employee = Employee::getEmployeeById($id);

    if($employee) {
        // Display edit form
        echo "<form action='edit_employee.php' method='post'>";
        echo "ID: <input type='text' name='ma_nv' value='" . $employee['Ma_Nv'] . "' readonly><br>";
        echo "Name: <input type='text' name='ten_nv' value='" . $employee['Ten_Nv'] . "'><br>";
        echo "Gender: <input type='text' name='phai' value='" . $employee['Phai'] . "'><br>";
        echo "Place of Birth: <input type='text' name='noi_sinh' value='" . $employee['Noi_Sinh'] . "'><br>";
        echo "Department: <input type='text' name='ma_phong' value='" . $employee['Ma_Phong'] . "'><br>";
        echo "Salary: <input type='text' name='luong' value='" . $employee['Luong'] . "'><br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    } else {
        echo "Employee not found.";
    }
} else {
    echo "ID not provided.";
}

// Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    // Update employee record
    $result = Employee::updateEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);
    if($result) {
        echo "Employee updated successfully.";
    } else {
        echo "Error updating employee.";
    }
}

?>
