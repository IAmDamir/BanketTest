<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if (empty($_GET['photo_name'])) {
    header('location: OutputPhotos.php');
    exit;
}

if (isset($_GET['submit'])) {
    $path_to_picture = $_SERVER['DOCUMENT_ROOT'].'/CodingLab/web/menu/'.$_GET['photo_name'];
    unlink($path_to_picture);
    include_once '../SavePicture.php';

    if (isset($_GET['dish_name'])) {
        $selectStatement = "SELECT id FROM dishes WHERE name = '" . $_GET['dish_name'] . "' limit 1;";
        $result = $conn->query($selectStatement);
        $dish_id = $result->fetch_assoc()['id'];

        $sql = "UPDATE dishes 
                SET picture = NULL
                WHERE id = $dish_id;";
        $conn->query($sql);
    }

    header('location: OutputPhotos.php');
    exit;
}

$dish_name = $_GET['dish_name'];
$photo = $_GET['photo_name'];
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <link href="../tables.css" rel="stylesheet" type="text/css" media="all"/>
    <title>Output Dishes</title>
    <style>
        img {
            height: 250px;
            width: 250px;
        }
    </style>
</head>
<body>
<button onclick="location.href='OutputPhotos.php';"> Back</button>
<br/>
<?php
if (isset($dish_name)) {
    echo 'Dish Name - ' . $dish_name . '<br/>';
}
echo '<img alt="" class="img-responsive" src="../../menu/' . $photo . '"/>';
?>
<form action="DeletePhoto.php" method="get">
    <input type="hidden" name="dish_name" value="<?php echo $dish_name; ?>">
    <input type="hidden" name="photo_name" value="<?php echo $photo; ?>">
    <input type="submit" name="submit" value="Delete Anyways">
</form>
</body>
