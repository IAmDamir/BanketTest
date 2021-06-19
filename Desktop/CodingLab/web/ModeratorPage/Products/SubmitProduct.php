<?php
include_once '../CheckTimeActivity.php';
include_once '../../connectToTheDatabase.php';

if (isset($_POST['submitProduct'])) {
    // Updating order_details table
    $name = $_POST['product_name'];
    $unit = $_POST['unit'];
    $amount_of_dishes = $_POST['amount_of_dishes'];

    $sql = "INSERT INTO products (name, unit)
            VALUES ('$name', '$unit')";
    $conn->query($sql);
    $id = $conn->insert_id;

    $index = 0;
    while($index < $_POST['amount_of_main']) {
        $amount_of_main_products = $_POST['amount_of_main_products'.$index];
        $amount_of_main_persons = $_POST['amount_of_main_persons'.$index];
        checkAndSubmit($conn, $id, 'main'.$index, $amount_of_main_products, $amount_of_main_persons);
        $index++;
    }
    unset($amount_of_main_products, $amount_of_main_persons, $index);

    $index = 0;
    while($index < $_POST['amount_of_salades']) {
        $amount_of_salades_products = $_POST['amount_of_salades_products'.$index];
        $amount_of_salades_persons = $_POST['amount_of_salades_persons'.$index];
        checkAndSubmit($conn, $id, 'salades'.$index, $amount_of_salades_products, $amount_of_salades_persons);
        $index++;
    }
    unset($amount_of_salades_products, $amount_of_salades_persons, $index);

    $index = 0;
    while($index < $_POST['amount_of_snacks']) {
        $amount_of_snacks_products = $_POST['amount_of_snacks_products'.$index];
        $amount_of_snacks_persons = $_POST['amount_of_snacks_persons'.$index];
        checkAndSubmit($conn, $id, 'snacks'.$index, $amount_of_snacks_products, $amount_of_snacks_persons);
        $index++;
    }
    unset($amount_of_snacks_products, $amount_of_snacks_persons, $index);

    $index = 0;
    while($index < $_POST['amount_of_desserts']) {
        $amount_of_desserts_products = $_POST['amount_of_desserts_products'.$index];
        $amount_of_desserts_persons = $_POST['amount_of_desserts_persons'.$index];
        checkAndSubmit($conn, $id, 'desserts'.$index, $amount_of_desserts_products, $amount_of_desserts_persons);
        $index++;
    }
    unset($amount_of_desserts_products, $amount_of_desserts_persons, $index);

    header("location: OutputProducts.php");
    exit;
}

function checkAndSubmit($conn, $id, $name, $amount_of_products, $amount_of_persons) {
    if (isset($_POST["$name"])) {
        $selectStatement = "SELECT id FROM dishes WHERE name = '" . $_POST["$name"] . "' limit 1;";
        $result = $conn->query($selectStatement);

        if ($result->num_rows > 0) {
            $dish_id = $result->fetch_assoc();
            $insertStatement = "INSERT INTO dish_products (amount_of_persons, amount_of_products, product_id, dish_id)
                                VALUES ($amount_of_persons, $amount_of_products, "
                                . $id . ", " . $dish_id['id'] . ");";
            $conn->query($insertStatement);
        }
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
<body>
<button onclick="location.href='OutputProducts.php';"> Back </button>
<form action="SubmitProduct.php" method="post">
    <input type="hidden" name="amount_of_dishes" value="<?php echo $_POST['amount_of_dishes']?>">
    <input type="hidden" name="product_name" value="<?php echo $_POST['product_name']?>">
    <input type="hidden" name="unit" value="<?php echo $_POST['unit']?>">
    <input type="hidden" name="amount_of_main" value="<?php echo $_POST['amount_of_main']?>">
    <input type="hidden" name="amount_of_salades" value="<?php echo $_POST['amount_of_salades']?>">
    <input type="hidden" name="amount_of_snacks" value="<?php echo $_POST['amount_of_snacks']?>">
    <input type="hidden" name="amount_of_desserts" value="<?php echo $_POST['amount_of_desserts']?>">


    <!-- Dishes -->
    <?php
    // Getting all dishes from database
    $select_statement = "SELECT category, name FROM dishes;";
    $result = $conn->query($select_statement);
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

    function outputSelects($category, $name_array, $times) {
        $i = 0;
        while ($i < $times) {
            echo "<select name=\"$category$i\">";
            echo "<option selected value> -- select an option -- </option>";
            foreach ($name_array as $row) {
                echo "<option value=\"$row\">$row</option>";
            }
            unset($row);
            echo '</select>';
            echo '<!-- Amount of Products -->
                    <div class="label">
                        <label for="amount_of_' . $category . '_products' . $i . '">Amount of Products</label>
                    </div>
                    <div class="content">
                        <input type="number" min="1" id="amount_of_' . $category . '_products' . $i . '"
                         name="amount_of_' . $category . '_products' . $i . '" required>
                    </div>';
            echo '<!-- Amount of Persons -->
                    <div class="label">
                        <label for="amount_of_' . $category . '_persons' . $i . '">Amount of Persons</label>
                    </div>
                    <div class="content">
                        <input type="number" min="1" id="amount_of_' . $category . '_persons' . $i . '"
                         name="amount_of_' . $category . '_persons' . $i . '" required>
                    </div>';
            $i++;
        }
        unset($i);
    }

    echo'<div class="label">
            <label>Main dishes</label>
         </div>
         <div class="content">';
    if ($_POST['amount_of_main'] > 0) {
        outputSelects('main', $main_name_array, $_POST['amount_of_main']);
    }
    echo '</div>';

    if($_POST['amount_of_salades'] > 0){
        echo'<div class="label">
                <label>Salades</label>
             </div>
             <div class="content">';
        outputSelects('salades', $salad_name_array, $_POST['amount_of_salades']);
    }
        echo '</div>';

        echo'<div class="label">
                <label>Snacks</label>
             </div>
             <div class="content">';
        if($_POST['amount_of_snacks'] > 0){
            outputSelects('snacks', $snack_name_array, $_POST['amount_of_snacks']);
        }
        echo '</div>';

        echo'<div class="label">
                <label>Desserts</label>
             </div>
             <div class="content">';
        if($_POST['amount_of_desserts'] > 0){
            outputSelects('desserts', $dessert_name_array, $_POST['amount_of_desserts']);
        }
        echo '</div>';
        ?>

    <input type="submit" name="submitProduct">
</form>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<!-- Closing connection -->
<?php
// Close the connection
$conn->close();
?>
</html>
