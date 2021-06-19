<?php
include_once '../CheckTimeActivity.php';

if (empty($_GET['dish_id'])) {
    header("location: OutputDishes.php");
    exit;
}

include_once '../../connectToTheDatabase.php';

if (isset($_GET['submit'])) {
    $sql = 'DELETE FROM dish_products WHERE dish_id = ' . $_GET['dish_id'] . ';';
    $conn->query($sql);
    $sql = 'DELETE FROM dishes WHERE id = ' . $_GET['dish_id'] . ';';
    $conn->query($sql);
    $conn->close();

    header("location: OutputDishes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../../productsTable.css" rel="stylesheet" type="text/css" media="all"/>
    <title>Delete Dish</title>
</head>
<body>
<button onclick="location.href='OutputDishes.php';"> Back</button>
<br/>
<?php
$sql = 'SELECT
                dishes.id,
                dishes.name AS dish_name,
                dishes.content,
                dishes.category,
                dishes.picture,
                dish_products.amount_of_persons,
                dish_products.amount_of_products,
                products.name AS product_name
            FROM
                dishes
            INNER JOIN dish_products ON dishes.id = dish_products.dish_id
            INNER JOIN products ON products.id = dish_products.product_id
            WHERE dishes.id =' . $_GET['dish_id'] . ';';

$result = $conn->query($sql);
$row = $result->fetch_all(MYSQLI_ASSOC);


$firstTime = true;
foreach ($row as $selected) {
    if ($firstTime) {
        echo '<img alt="" class="img-responsive" src="../../menu/' . $selected['picture'] . '"/>';
        echo '<br/>order id - ' . $selected['id'];
        echo '<br/>dish name - ' . $selected['dish_name'];
        if (isset($selected['content'])) {
            echo '<br/>content - ' . $selected['content'];
        }
        echo '<br/>category - ' . $selected['category'];
        echo '<br/>amount of persons - ' . $selected['amount_of_persons'];

        echo '<table>';
        echo '<tr>';
        echo '<th>Product Name</th>';
        echo '<th>Amount</th>';
        echo '<tr>';


        echo '<tr>';
        echo '<td>' . $selected['product_name'] . '</td>';
        echo '<td>' . $selected['amount_of_products'] . '</td>';
        echo '</tr>';

        $firstTime = false;
    } else {
        echo '<tr>';
        echo '<td>' . $selected['product_name'] . '</td>';
        echo '<td>' . $selected['amount_of_products'] . '</td>';
        echo '</tr>';
    }
}
echo '</table>';

$result->close();
unset($row, $previousOrderId, $sql);
?>
<form action="DeleteDish.php" method="get">
    <input type="hidden" name="dish_id" value="<?php echo $_GET['dish_id']; ?>">
    <input type="submit" name="submit" value="Delete Anyways">
</form>
</body>
</html>
