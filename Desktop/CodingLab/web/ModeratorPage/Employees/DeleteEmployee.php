<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if(empty($_GET['employee_id'])) {
    header("location: OutputEmployees.php");
    exit;
}

if (isset($_GET['submit'])) {
    $id = $_GET['employee_id'];

    $sql = "DELETE FROM employees WHERE id = $id";
    $conn->query($sql);

    header('location: OutputEmployees.php');
    exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Add Employee</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<button onclick="location.href='OutputEmployees.php';"> Back </button>
<table id="ProductsTable">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Job</th>
        <th>Number</th>
        <th>Email</th>
    </tr>
    <?php
    $sql = 'SELECT  id,
                name,
                job,
                contact_number,
                email
        FROM employees 
        WHERE id = ' . $_GET['employee_id'] . ';';
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();


    echo '<tr>';
    echo '<td>' . $result['id'] . '</td>';
    echo '<td>' . $result['name'] . '</td>';
    echo '<td>' . $result['job'] . '</td>';
    echo '<td>' . $result['contact_number'] . '</td>';
    echo '<td>' . $result['email'] . '</td>';
    echo '</tr>';
    ?>
</table>
<form action="DeleteEmployee.php" method="get">
    <input type="hidden" name="employee_id" value="<?php echo $_GET['employee_id'];?>">
    <input type="submit" name="submit" value="Delete anyways">
</form>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</html>