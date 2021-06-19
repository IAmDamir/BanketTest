<?php
include_once '../../CheckTimeActivity.php';

include_once '../../../connectToTheDatabase.php';
include_once '../../SavePicture.php';

$product_names_array = explode(",", $_POST['products']);
$product_names_array = array_map('trim', $product_names_array);
$product_names_array = array_filter($product_names_array, 'strlen');
$product_names_array = array_unique($product_names_array);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Dish products</title>
</head>
<body>
<button onclick="location.href='../OutputDishes.php';"> Back</button>
<form action="UpdateDishDatabase.php" method="post">
    <input type="hidden" name="amount_of_persons" value="<?php echo $_POST['amount_of_persons']?>">
    <input type="hidden" name="dish_name" value="<?php echo $_POST['dish_name'];?>">
    <input type="hidden" name="category" value="<?php echo $_POST['category'];?>">
    <input type="hidden" name="products" value="<?php echo $_POST['products']?>">
    <input type="hidden" name="picture" value="<?php echo $_FILES["picture"]["name"]?>">
    <input type="hidden" name="content" value="<?php echo $_POST['content'];?>">
    <input type="hidden" name="dish_id" value="<?php echo $_POST['dish_id'];?>">
    <?php
    echo $messageAboutFile;


//    $allProducts = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT 
                amount_of_products,
                name
            FROM dish_products 
            INNER JOIN products 
            ON dish_products.product_id = products.id
            WHERE dish_id = '" . $_POST['dish_id'] . "';";
    $result = $conn->query($sql);
    $previousProducts = array();
    while ($row = $result->fetch_assoc()) {
        $previousProducts[$row['name']] = $row['amount_of_products'];
    }
    $result->free_result();

    $productsInDatabase = array();
    $productsNotInDatabase = array();
    foreach ($product_names_array as $product) {
        echo $product."<br/>";
        $sql = "SELECT name FROM products WHERE name = '$product' LIMIT 1;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $tempStr = '<div class="label">
                    <label for="' . $product . '">Amount of ' . $product . '</label>
                </div>
                <div class="content">
                    <input type="number" id="' . $product . '" name="' . str_replace(' ', '_',$product) . '" min="1" ';

            if (array_key_exists($product, $previousProducts)) {
                $tempStr .= 'value="' . $previousProducts[$product] . '" ';
            }
            // closing input and div
            $tempStr .= 'required></div>';

            array_push($productsInDatabase, $tempStr);
        } else {
            $tempStr = 'there is no ' . $product . $product . ' in products table, try to add it first.';
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
