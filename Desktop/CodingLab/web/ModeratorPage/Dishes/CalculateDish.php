<?php
include_once '../CheckTimeActivity.php';

if (empty($_GET['dish_id'])) {
    header("location: OutputDishes.php");
    exit;
}

include_once '../../connectToTheDatabase.php';
include '../../calculateProducts.php';

$products_array = array();

CalculateProducts($conn, $products_array, $_GET['dish_id'], $_GET['amount']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../../productsTable.css" rel="stylesheet" type="text/css" media="all"/>
    <title>Calculate dish</title>
</head>
<body>
<button onclick="location.href='OutputDishes.php';"> Back</button>
<br/>
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
<form action="CalculateDish.php" method="get">
    <input type="hidden" name="dish_id" value=<?php echo '"' . $_GET['dish_id'] . '"'; ?>>
    <input type="number" name="amount" value="1" min="1" required>
    <input type="submit" value="Calculate">
</form>
</body>
</html>