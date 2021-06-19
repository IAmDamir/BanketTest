<?php
include_once '../CheckTimeActivity.php';

if (empty($_GET['product_id'])) {
    header("location: OutputProducts.php");
    exit;
}

include_once '../../connectToTheDatabase.php';

if (isset($_GET['submit'])) {
    $sql = 'DELETE FROM products WHERE id = ' . $_GET['product_id'] . ';';
    $conn->query($sql);
    $conn->close();

    header("location: OutputProducts.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../../productsTable.css" rel="stylesheet" type="text/css" media="all"/>
    <style>
        .img-responsive {
            height: 200px !important;
        }
    </style>
    <title>Delete product</title>
</head>
<body>
<button onclick="location.href='OutputProducts.php';"> Back</button>
<br/>
<table id="OrdersTable">
    <tr>
        <th>Product Name</th>
        <th>Unit</th>
        <th>Amount of Products</th>
        <th>Amount of Persons</th>
        <th>Dish ID</th>
        <th>Dish Name</th>
        <th>Category</th>
        <th>Picture</th>
    </tr>
    <?php
    $sql = 'SELECT
            products.name AS product_name,
            products.unit,
            dish_products.amount_of_products,
            dish_products.amount_of_persons,
            dishes.id,
            dishes.name AS dish_name,
            dishes.category,
            dishes.picture
        FROM
            products
        INNER JOIN dish_products ON products.id = dish_products.product_id
        INNER JOIN dishes ON dishes.id = dish_products.dish_id
        WHERE
            products.id = ' . $_GET['product_id'] . ';';

    // Outputting products 2D array (name, amount, unit)
    //  Scan through outer loop
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $firstTime = true;

    foreach ($rows as $row) {
        if ($row['category'] == 'горячее' || $row['category'] == 'салат' ||
            $row['category'] == 'закуски' || $row['category'] == 'десерт') {
            if ($firstTime) {
                echo '<tr>';
                echo '<td rowspan="0">' . $row['product_name'] . '</td>';
                echo '<td rowspan="0">' . $row['unit'] . '</td>';
                echo '<td>' . $row['amount_of_products'] . '</td>';
                echo '<td>' . $row['amount_of_persons'] . '</td>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['dish_name'] . '</td>';
                echo '<td>' . $row['category'] . '</td>';
                echo '<td><img alt="" class="img-responsive" src="../../menu/' . $row['picture'] . '"/></td>';
                echo '</tr>';
                $firstTime = false;
            } else {
                echo '<tr>';
                echo '<td>' . $row['amount_of_products'] . '</td>';
                echo '<td>' . $row['amount_of_persons'] . '</td>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['dish_name'] . '</td>';
                echo '<td>' . $row['category'] . '</td>';
                echo '<td><img alt="" class="img-responsive" src="../../menu/' . $row['picture'] . '"/></td>';
                echo '</tr>';
            }
        }
    }
    echo '</td>';
    echo '</tr>';
    $result->close();
    unset($rows, $row, $firstTime, $sql);
    ?>
</table>
<form action="DeleteProduct.php" method="get">
    <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
    <input type="submit" name="submit" value="Delete anyways">
</form>
</body>
</html>
