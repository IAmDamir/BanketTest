<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if(empty($_GET['review_id'])) {
    header("location: OutputReviews.php");
    exit;
}

if (isset($_GET['submit'])) {
    $id = $_GET['review_id'];

    $sql = "DELETE FROM reviews WHERE id = $id";
    $conn->query($sql);

    header('location: OutputReviews.php');
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
<button onclick="location.href='OutputReviews.php';"> Back </button>
<table id="ProductsTable">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Review</th>
    </tr>
    <?php
    $sql = 'SELECT
                id,
                name,
                review
            FROM
                reviews
            WHERE id = ' . $_GET['review_id'] . ';';
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();


    echo '<tr>';
    echo '<td>' . $result['id'] . '</td>';
    echo '<td>' . $result['name'] . '</td>';
    echo '<td>' . $result['review'] . '</td>';
    echo '</tr>';
    ?>
</table>
<form action="DeleteReview.php" method="get">
    <input type="hidden" name="review_id" value="<?php echo $_GET['review_id'];?>">
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