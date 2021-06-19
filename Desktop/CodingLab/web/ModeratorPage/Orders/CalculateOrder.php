<?php
include_once '../CheckTimeActivity.php';

if (empty($_GET['order_id'])) {
    header("location: OutputOrders.php");
    exit;
}

include_once '../../connectToTheDatabase.php';
include '../../calculateProducts.php';

// Making products 2D array (array(name, amount, unit))
$products_array = array();

$selectStatement = "SELECT dish_id, amount FROM orders WHERE order_id = '" . $_GET['order_id'] . "';";
$result = $conn->query($selectStatement);
while ($row = mysqli_fetch_assoc($result)) {
    CalculateProducts($conn, $products_array, $row['dish_id'], $row['amount']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../../productsTable.css" rel="stylesheet" type="text/css" media="all"/>
    <title>Calculate order</title>
</head>
<body>
<button onclick="location.href='OutputOrders.php';"> Back</button>
<?php
array_multisort($products_array);
// Outputting products 2D array (name, amount, unit)
//  Scan through outer loop
echo '<table> 
        <tr>
        <th> Product Name </th>
        <th> Amount </th>
        <th> Unit </th>
        </tr>';
foreach ($products_array as $innerArray) {
    echo '<tr>';
    //  outputting inner loop
    foreach ($innerArray as $value) {
        echo "<td>$value</td>";
    }
    echo '</tr>';
}
// Closing the connection
$conn->close();
?>
</body>
</html>