<?php
include_once '../CheckTimeActivity.php';

if(empty($_GET['product_id']) && empty($_POST['product_id'])) {
    header("location: OutputProducts.php");
    exit;
}

include_once '../../connectToTheDatabase.php';

$sql = 'SELECT
            products.name AS product_name,
            products.unit,
            dishes.name AS dish_name
        FROM
            products
        INNER JOIN dish_products ON products.id = dish_products.product_id
        INNER JOIN dishes ON dish_products.dish_id = dishes.id
        WHERE products.id = ' . $_GET['product_id'] . ';';
$result = $conn->query($sql);
$product = $result->fetch_assoc();
if (empty($product['dish_name'])) {
    $product_name = $product['product_name'];
    $unit = $product['unit'];

    header("location: AddProduct.php?product_name=$product_name&unit=$unit");
    exit;
}

if (isset($_POST['submit'])) {
    // Updating order_details table
    $name = $_POST['product_name'];
    $unit = $_POST['unit'];
    $id = $_POST['product_id'];

    $sql = "UPDATE products
            SET name = '$name',
                unit = '$unit'
            WHERE id = '$id';";
    $conn->query($sql);

    $sql = "DELETE FROM dish_products WHERE product_id = $id;";
    $conn->query($sql);

    $index = 0;
    while($index < $_POST['times']) {
        $amount_of_products = $_POST['amount_of_products'.$index];
        $amount_of_persons = $_POST['amount_of_persons'.$index];
        checkAndSubmit($conn, $id, 'dish'.$index,
            $amount_of_persons, $amount_of_products);
        $index++;
    }
    unset($amount_of_products, $amount_of_persons, $index);

    header("location: OutputProducts.php");
    exit;
}

function checkAndSubmit($conn, $id, $name, $amount_of_persons, $amount_of_products) {
    if (isset($_POST["$name"])) {
        $selectStatement = "SELECT id FROM dishes WHERE name = '" . $_POST["$name"] . "' limit 1;";
        $result = $conn->query($selectStatement);

        if ($result->num_rows > 0) {
            $dish_id = $result->fetch_assoc();
            $insertStatement = "INSERT INTO dish_products (amount_of_persons, amount_of_products, product_id, dish_id)
                                VALUES ($amount_of_products, $amount_of_persons, "
                . $id . ", " . $dish_id['id'] . ");";
            $conn->query($insertStatement);
        }
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <style>
        textarea {
            resize: none;
        }
    </style>
    <title>Update Products</title>
</head>
<body>
<button onclick="location.href='OutputProducts.php';"> Back </button>
<?php
if(isset($_GET['product_id'])) {
    // Getting all dishes from database
    $sql = "SELECT category, name FROM dishes;";
    $result = $conn->query($sql);
    // Throw message if there's no result
    if (!$result) die("Result is empty");
    // Preparing arrays to store dishes
    $main_name_array = array();
    $salad_name_array = array();
    $snack_name_array = array();
    $dessert_name_array = array();
    // Storing dishes in arrays by categories
    while ($row = $result->fetch_assoc()) {
        if ($row['category'] == 'горячее') {
            $main_name_array[] = $row['name'];
        } else if ($row['category'] == 'салат') {
            $salad_name_array[] = $row['name'];
        } else if ($row['category'] == 'закуски') {
            $snack_name_array[] = $row['name'];
        } else if ($row['category'] == 'десерт') {
            $dessert_name_array[] = $row['name'];
        }
    }

    $sql = 'SELECT
                products.id,
                products.name AS product_name,
                products.unit,
                dish_products.amount_of_products,
                dish_products.amount_of_persons,
                dishes.name AS dish_name,
                dishes.category
            FROM
                products
            INNER JOIN dish_products ON products.id = dish_products.product_id
            INNER JOIN dishes ON dish_products.dish_id = dishes.id
            WHERE products.id = ' . $_GET['product_id'] . ';';
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $firstTime = true;
    $dish_index = 0;
    foreach ($rows as $selected) {
        if ($firstTime) {
            echo '<form action="UpdateProduct.php" method="post">
                    <input type="hidden" name="product_id" value="' . $selected['id'] . '">
                    <div class="label">
                        <label for="product_name">Product Name</label>
                    </div>
                    <div class="content">
                        <input type="text" id="product_name" name="product_name" 
                        value="' . $selected['product_name'] . '" required>
                    </div>
                    <br/>
                    <!-- Unit -->
                    <div class="label">
                        <label for="unit">Unit</label>
                    </div>
                    <div class="content">
                        <input type="text" id="unit" name="unit" value="' . $selected['unit'] . '" required>
                    </div>
                    <br/>
                    <!-- Amount of Persons -->
                    <div class="label">
                        <label for="amount_of_persons' . $dish_index . '">Amount of Persons</label>
                    </div>
                    <div class="content">
                        <input type="number" 
                        id="amount_of_persons' . $dish_index . '" name="amount_of_persons' . $dish_index . '" 
                        min="1" value="' . $selected['amount_of_persons'] . '" required>
                    </div>
                    <!-- Amount of Products -->
                    <div class="label">
                        <label for="amount_of_products' . $dish_index . '">Amount of Products</label>
                    </div>
                    <div class="content">
                        <input type="number" 
                        id="amount_of_products' . $dish_index . '" name="amount_of_products' . $dish_index . '" 
                        min="1" value="' . $selected['amount_of_products'] . '" required>
                    </div>
                    
                    <select name="dish' . $dish_index . '">
                    <option selected value> '.$selected['dish_name'].' </option>';
            foreach ($main_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            foreach ($salad_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            foreach ($snack_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            foreach ($dessert_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            echo    '</select>';
            $firstTime = false;
        } else {

            echo '  <!-- Amount of Persons -->
                    <div class="label">
                        <label for="amount_of_persons' . $dish_index . '">Amount of Persons</label>
                    </div>
                    <div class="content">
                        <input type="number" 
                        id="amount_of_persons' . $dish_index . '" name="amount_of_persons' . $dish_index . '" 
                        min="1" value="' . $selected['amount_of_persons'] . '" required>
                    </div>
                    <!-- Amount of Products -->
                    <div class="label">
                        <label for="amount_of_products' . $dish_index . '">Amount of Products</label>
                    </div>
                    <div class="content">
                        <input type="number" 
                        id="amount_of_products' . $dish_index . '" name="amount_of_products' . $dish_index . '" 
                        min="1" value="' . $selected['amount_of_products'] . '" required>
                    </div>';
            echo '<select name="dish' . $dish_index . '">
                    <option selected value> '.$selected['dish_name'].' </option>';
            foreach ($main_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            foreach ($salad_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            foreach ($snack_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            foreach ($dessert_name_array as $names) {
                echo "<option value=\"$names\">$names</option>";
            }
            echo    '</select>';
        }
        $dish_index++;
    }
    echo            '<br/>
                         </div>
                             <input type="hidden" id="times" name="times" value="' . $dish_index . '">
                             <input type="submit" name="submit">
                         </form>';
}
?>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</html>
<?php
$result->close();
unset($rows, $previousOrderId, $sql, $selected);
?>