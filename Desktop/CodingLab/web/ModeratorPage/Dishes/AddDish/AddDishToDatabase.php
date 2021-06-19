<?php
include_once '../../CheckTimeActivity.php';

include_once '../../../connectToTheDatabase.php';

$sql = 'INSERT INTO dishes (name, category, content, picture)
            VALUES (\''.$_POST['dish_name'].'\', \''.$_POST['category'].
                   '\', \''.$_POST['content'].'\', \''.$_POST["picture"].'\');';
$conn->query($sql);

if (isset($_POST['products'])) {
    $products_array = explode(",", $_POST['products']);
    $products_array = array_map('trim', $products_array);
    $products_array = array_filter($products_array, 'strlen');
    $products_array = array_unique($products_array);

    $id = $conn->insert_id;
    foreach ($products_array as $product) {
        $sql = "SELECT id FROM products WHERE name = '$product' limit 1;";
        $result = $conn->query($sql);
        $product_id = $result->fetch_row()[0];
        if ($result->num_rows > 0) {
            $sql = 'INSERT INTO dish_products (dish_id, product_id,
                                               amount_of_persons,
                                               amount_of_products)
                    VALUES (' . $id . ', ' . $product_id .
                            ', ' . $_POST['amount_of_persons'] .
                            ', ' . $_POST[$product] . ');';
            $conn->query($sql);
        }
    }
}

header("location: ../OutputDishes.php");
exit;