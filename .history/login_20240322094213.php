<?php
    require_once("config/db.class.php");
// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and store username and password from the form
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Instantiate Db class
    $db = new Db();

    // SQL query to select user based on username and password
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";

    // Execute query and fetch result
    $user = $db->select_to_array($query);

    // Check if user exists
    if ($user) {
        // User exists, set session variables and redirect to dashboard or desired page
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user[0]['role']; // Assuming role is stored in the database
        header("Location: dashboard.php"); // Redirect to dashboard page
        exit();
    } else {
        // User does not exist or invalid credentials, display error message
        $error_message = "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    // Display error message if set
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
