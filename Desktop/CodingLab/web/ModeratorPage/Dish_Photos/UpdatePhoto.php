<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if (empty($_GET['photo_name']) && empty($_FILES['picture']) && empty($_GET['dish_name'])) {
    header('location: OutputPhotos.php');
    exit;
}

if (isset($_POST['submit'])) {
    $path_to_picture = $_SERVER['DOCUMENT_ROOT'].'/CodingLab/web/menu/'.$_POST['photo_name'];
    if (file_exists($path_to_picture)) {
        unlink($path_to_picture);
    }
    include_once '../SavePicture.php';

    if (isset($_POST['dish_name'])) {
        $selectStatement = "SELECT id FROM dishes WHERE name = '" . $_POST['dish_name'] . "' limit 1;";
        $result = $conn->query($selectStatement);
        $dish_id = $result->fetch_assoc()['id'];
        $file = $_FILES["picture"]["name"];

        $sql = "UPDATE dishes 
                SET picture = '$file'
                WHERE id = $dish_id;";
        $conn->query($sql);
    }

    header('location: OutputPhotos.php');
    exit;
}

// Getting all dishes from database
$select_statement = "SELECT name FROM dishes;";
$result = $conn->query($select_statement);
// Throw message if there's no result
if (!$result) die("Result is empty");
// Preparing arrays to store dishes
$dish_name_array = array();
// Storing dishes in arrays by categories
while ($row = $result->fetch_assoc()) {
    $dish_name_array[] = $row['name'];
}

if (!empty($_GET['dish_name'])) {
    $dish_name = $_GET['dish_name'];
} else {
    $dish_name = '';
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Add Photo</title>
</head>
<body>
<button onclick="location.href='OutputPhotos.php';"> Back</button>
<?php echo $_GET['photo_name'];?>
<form action="UpdatePhoto.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="photo_name" value="<?php echo $_GET['photo_name'];?>">
    <!-- New Dish Name -->
    <div class="label">
        <label for="dish_name">Dish Name</label>
    </div>
    <div class="content">
        <select id="dish_name" name="dish_name">
            <option selected value="<?php echo $dish_name;?>"><?php echo $dish_name;?></option>
            <?php
            $dish_name_array = array_diff($dish_name_array, [$dish_name]);
            foreach ($dish_name_array as $dish) {
                echo "<option value='$dish'>$dish</option>";
            }
            ?>
        </select>
    </div>
    <!-- Picture for the Dish -->
    <div class="label">
        <label for="content">Picture</label>
    </div>
    <div class="content">
        <input type="file" id="picture" name="picture" onchange="loadFile(event)" required>
        <img id="output"/>
    </div>
    <input type="submit" id="submit" name="submit" value="Update">
</form>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>