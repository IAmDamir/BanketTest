<?php
include_once '../../CheckTimeActivity.php';

include_once '../../../connectToTheDatabase.php';

$sql = 'UPDATE dishes
            SET name = \'' . $_POST['dish_name'] . '\', 
                category = \'' . $_POST['category'] . '\', 
                content = \'' . $_POST['content'] . '\', 
                picture = \'' . $_POST["picture"] . '\'
            WHERE id = ' . $_POST['dish_id'] . ';';
$conn->query($sql);

if (isset($_POST['products'])) {
    $product_names_array = explode(",", $_POST['products']);
    $product_names_array = array_map('trim', $product_names_array);
    $product_names_array = array_filter($product_names_array, 'strlen');
    $product_names_array = array_unique($product_names_array);

    $sql = 'DELETE FROM dish_products WHERE dish_id = ' . $_POST['dish_id'] . ';';
    $conn->query($sql);

    foreach ($product_names_array as $product) {
        $sql = "SELECT id FROM products WHERE name = '$product' limit 1;";
        $result = $conn->query($sql);
        $product_id = $result->fetch_row()[0];
        if ($result->num_rows > 0) {
            $sql = 'INSERT INTO dish_products (dish_id, product_id,
                                               amount_of_persons,
                                               amount_of_products)
                    VALUES (' . $_POST['dish_id'] . ', ' . $product_id .
                ', ' . $_POST['amount_of_persons'] .
                ', ' . $_POST[str_replace(' ', '_',$product)] . ');';
            $conn->query($sql);
        }
    }
}

header("location: ../OutputDishes.php");
exit;
