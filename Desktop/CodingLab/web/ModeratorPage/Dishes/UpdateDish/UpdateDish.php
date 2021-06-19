<?php
include_once '../../CheckTimeActivity.php';

if (empty($_GET['dish_id'])) {
    header("location: ../OutputDishes.php");
    exit;
}

include_once '../../../connectToTheDatabase.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Update Dish</title>
</head>
<body>
<button onclick="location.href='../OutputDishes.php';"> Back</button>
<form action="UpdateProductsOfDish.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="dish_id" value="<?php echo $_GET['dish_id'];?>">
<?php
$sql = 'SELECT
            dishes.name AS dish_name,
            dishes.content,
            dishes.category,
            dishes.picture,
            dish_products.amount_of_products,
            dish_products.amount_of_persons,
            products.unit,
            products.name AS product_name
        FROM
            dishes
        LEFT JOIN dish_products ON dishes.id = dish_products.dish_id
        LEFT JOIN products ON products.id = dish_products.product_id
        WHERE
            dishes.id = ' . $_GET['dish_id'] . ';';

$result = $conn->query($sql);
$row = $result->fetch_all(MYSQLI_ASSOC);


$firstTime = true;
foreach ($row as $selected) {
    if ($firstTime) {
        echo
        '   <!-- New Dish Name -->
            <div class="label">
                <label for="dish_name">Dish Name</label>
            </div>
            <div class="content">
                <input type="text" id="dish_name" name="dish_name" value="' . $selected['dish_name'] . '" required>
            </div>
            <!-- Amount of Persons -->
            <div class="label">
                <label for="amount_of_persons">Amount of Persons</label>
            </div>
            <div class="content">
                <input type="number" id="amount_of_persons" name="amount_of_persons" 
                min="1" value="' . $selected['amount_of_persons'] . '" required>
            </div>
            <!-- Category of new Dish -->
            <div class="label">
                <label for="category">Category</label>
            </div>
            <input type="text" id="category" name="category" value="' . $selected['category'] . '" required>
            <br/>
            <!-- Content of new Dish -->
            <div class="label">
                <label for="content">Content</label>
            </div>
            <div class="content">
                <textarea id="content" name="content" cols="50" rows="5">' . $selected['content'] . '</textarea>
            </div>
            <!-- Picture for new Dish -->
            <div class="label">
                <label for="content">Picture</label>
            </div>
            <div class="content">
                <input type="file" id="picture" name="picture" value="' . $selected['picture'] . '">
            </div>
            <!-- Products of new Dish -->
            <div class="label">
                <label for="products">Products</label>
            </div>
            <div class="content">
                <textarea id="products" name="products" cols="50" rows="5">' . $selected['product_name'];
        $firstTime = false;
    } else {
        echo ', ' . $selected['product_name'];
    }
}
echo '            </textarea>
            </div>';
?>
    <input type="submit" id="submit" name="submit" value="Update">
</form>
</body>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>