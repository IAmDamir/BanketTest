<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if(empty($_GET['employee_id']) && empty($_POST['employee_id'])) {
    header("location: OutputEmployees.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id = $_POST['employee_id'];
    $name = $_POST['name'];
    $job = $_POST['job'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];

    $sql = "UPDATE employees
            SET name = '$name',
                job = '$job',
                contact_number = '$contact_number',
                email = '$email'
                WHERE id = $id;";
    $conn->query($sql);

    header('location: OutputEmployees.php');
    exit;
}

$sql = 'SELECT  name,
                job,
                contact_number,
                email
        FROM employees 
        WHERE id = ' . $_GET['employee_id'] . ';';
$result = $conn->query($sql);
$result = $result->fetch_assoc();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Add Employee</title>
</head>
<body>
<button onclick="location.href='OutputEmployees.php';"> Back </button>
<form action="UpdateEmployee.php" method="post">
    <input type="hidden" name="employee_id" value="<?php echo $_GET['employee_id'];?>">
    <div class="label">
        <label for="name">Employee Name</label>
    </div>
    <div class="content">
        <input type="text" id="name" name="name" value="<?php echo $result['name'];?>" required>
    </div>
    <!-- Unit -->
    <div class="label">
        <label for="job">Job</label>
    </div>
    <input type="text" id="job" name="job" value="<?php echo $result['job'];?>" required>
    <br/>
    <!-- Unit -->
    <div class="label">
        <label for="contact_number">Contact number</label>
    </div>
    <input type="text" id="contact_number" name="contact_number"
           value="<?php echo $result['contact_number'];?>" required>
    <br/>
    <!-- Unit -->
    <div class="label">
        <label for="email">Email</label>
    </div>
    <input type="email" id="email" name="email" value="<?php echo $result['email'];?>">
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