<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if(empty($_GET['review_id']) && empty($_POST['review_id'])) {
    header("location: OutputReviews.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id = $_POST['review_id'];
    $name = $_POST['name'];
    $review = $_POST['review'];

    $sql = "UPDATE reviews
            SET name = '$name',
                review = '$review'
            WHERE id = $id;";
    $conn->query($sql);

    header('location: OutputReviews.php');
    exit;
}

$sql = 'SELECT
            id,
            name,
            review
        FROM
            reviews
        WHERE id = ' . $_GET['review_id'] . ';';
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
<button onclick="location.href='OutputReviews.php';"> Back </button>
<form action="UpdateReview.php" method="post">
    <input type="hidden" name="review_id" value="<?php echo $_GET['review_id'];?>">
    <div class="label">
        <label for="name">Reviewer Name</label>
    </div>
    <div class="content">
        <input type="text" id="name" name="name" value="<?php echo $result['name'];?>" required>
    </div>
    <!-- Unit -->
    <div class="label">
        <label for="review">Review</label>
    </div>
        <textarea id="review" name="review" cols="50" rows="5"><?php echo $result['review'];?></textarea>
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