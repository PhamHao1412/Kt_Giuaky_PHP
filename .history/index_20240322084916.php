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
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Gender</th>
                <th>Place of Birth</th>
                <th>Department</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            require_once("entities/employee.class.php"); // Replace "Employee.class.php" with the actual path if different
                require_once("config/db.class.php");
                $employees = Employee::list_employee();
                if (!empty($employees)) {
                    foreach ($employees as $employee) {
                        echo "<tr>";
                        echo "<td>" . $employee['Ma_Nv'] . "</td>";
                        echo "<td>" . $employee['Ten_Nv'] . "</td>";
                        echo "<td>" . $employee['Phai'] . "</td>";
                        echo "<td>" . $employee['Noi_Sinh'] . "</td>";
                        echo "<td>" . $employee['Ten_Phong'] . "</td>";
                        echo "<td>" . $employee['Luong'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No employees found!</td></tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>