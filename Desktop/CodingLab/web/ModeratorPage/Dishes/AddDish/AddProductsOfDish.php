<?php
include_once '../../CheckTimeActivity.php';

include_once '../../../connectToTheDatabase.php';
include_once '../../SavePicture.php';

$products_array = explode(",", $_POST['products']);
$products_array = array_map('trim', $products_array);
$products_array = array_filter($products_array, 'strlen');
$products_array = array_unique($products_array);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Dish products</title>
</head>
<body>
<button onclick="location.href='../OutputDishes.php';"> Back</button>
<form action="AddDishToDatabase.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="amount_of_persons" value="<?php echo $_POST['amount_of_persons']?>">
    <input type="hidden" name="dish_name" value="<?php echo $_POST['dish_name'];?>">
    <input type="hidden" name="category" value="<?php echo $_POST['category'];?>">
    <input type="hidden" name="products" value="<?php echo $_POST['products']?>">
    <input type="hidden" name="picture" value="<?php echo $_FILES["picture"]["name"]?>">
    <input type="hidden" name="content" value="<?php echo $_POST['content'];?>">
<?php
echo $messageAboutFile;

$productsInDatabase = array();
$productsNotInDatabase = array();
    foreach ($products_array as $product) {
        $sql = "SELECT id FROM products WHERE name = '$product' limit 1;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $tempStr = '<div class="label">
                    <label for="' . $product . '">Amount of ' . $product . '</label>
                </div>
                <div class="content">
                    <input type="number" min="1" id="' . $product . '" name="' . $product . '" >
                </div>';
            array_push($productsInDatabase, $tempStr);
        } else {
            $tempStr = 'there is no ' . $product . ' in products table, try to add it first.';
            array_push($productsNotInDatabase, $tempStr);
        }
    }
    sort($productsInDatabase, SORT_STRING );
    sort($productsNotInDatabase, SORT_STRING );

    foreach ($productsInDatabase as $product) {
        echo $product . '<br/>';
    }
    foreach ($productsNotInDatabase as $product) {
        echo $product . '<br/>';
    }
?>
    <input type="submit" id="submit" name="submit" value="Add">
</form>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
