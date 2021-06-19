<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if(empty($_GET['question_id'])) {
    header("location: OutputQuestions.php");
    exit;
}

if (isset($_GET['submit'])) {
    $id = $_GET['question_id'];

    $sql = "DELETE FROM questions WHERE id = $id";
    $conn->query($sql);

    header('location: OutputQuestions.php');
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
<button onclick="location.href='OutputQuestions.php';"> Back </button>
<br/>

<?php
$sql = 'SELECT
            id,
            contact,
            question
        FROM
            questions
        WHERE id = ' . $_GET['question_id'] . ';';
$result = $conn->query($sql);
$result = $result->fetch_assoc();

echo 'id - ' . $result['id'] . '<br/>';
echo 'contact - ' . $result['contact'] . '<br/>';
echo 'question - ' . $result['question'] . '<br/>';
?>

<form action="DeleteQuestions.php" method="get">
    <input type="hidden" name="question_id" value="<?php echo $_GET['question_id'];?>">
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