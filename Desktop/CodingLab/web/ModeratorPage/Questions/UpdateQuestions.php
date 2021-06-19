<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if(empty($_GET['question_id']) && empty($_POST['question_id'])) {
    header("location: OutputQuestions.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id = $_POST['question_id'];
    $contact = $_POST['contact'];
    $question = $_POST['question'];

    $sql = "UPDATE questions
            SET contact = '$contact',
                question = '$question'
            WHERE id = $id;";
    $conn->query($sql);

    header('location: OutputQuestions.php');
    exit;
}

$sql = 'SELECT
            id,
            contact,
            question
        FROM
            questions
        WHERE id = ' . $_GET['question_id'] . ';';
$result = $conn->query($sql);
$result = $result->fetch_assoc();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Add Employee</title>
    <style>
        textarea {
            resize: none;
        }
    </style>
</head>
<body>
<button onclick="location.href='OutputQuestions.php';"> Back </button>
<form action="UpdateQuestions.php" method="post">
    <input type="hidden" name="question_id" value="<?php echo $_GET['question_id'];?>">
    <!-- Contact -->
    <div class="label">
        <label for="contact">Contact</label>
    </div>
    <div class="content">
        <input type="text" id="contact" name="contact" value="<?php echo $result['contact'];?>" required>
    </div>
    <!-- Question -->
    <div class="label">
        <label for="question">question</label>
    </div>
    <textarea id="question" name="question" cols="50" rows="5" required>
        <?php echo $result['question'];?>
    </textarea>
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