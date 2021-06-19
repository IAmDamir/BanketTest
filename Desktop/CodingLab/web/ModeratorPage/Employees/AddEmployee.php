<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $job = $_POST['job'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];

    $sql = "INSERT INTO employees (name, job, contact_number, email)
            VALUES ('$name', '$job', '$contact_number', '$email');";
    $conn->query($sql);

    header('location: OutputEmployees.php');
    exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Add Employee</title>
</head>
<body>
<button onclick="location.href='OutputEmployees.php';"> Back </button>
<form action="AddEmployee.php" method="post">
    <div class="label">
        <label for="name">Employee Name</label>
    </div>
    <div class="content">
        <input type="text" id="name" name="name" required>
    </div>
    <!-- Unit -->
    <div class="label">
        <label for="job">Job</label>
    </div>
    <input type="text" id="job" name="job" required>
    <br/>
    <!-- Unit -->
    <div class="label">
        <label for="contact_number">Contact number</label>
    </div>
    <input type="text" id="contact_number" name="contact_number" required>
    <br/>
    <!-- Unit -->
    <div class="label">
        <label for="email">Email</label>
    </div>
    <input type="email" id="email" name="email">
    <br/>
    <input type="submit" name="submit">
</form>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</html>