<!DOCTYPE html>
<html lang="en">
<?php
include_once 'connectToTheDatabase.php';
include 'calculateProducts.php';
// Making dish associative array (id => name)
$selectStatement = "SELECT id, name FROM dishes;";
$result = $conn->query($selectStatement);
$dish_id_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $dish_id_array[$row['id']] = $row['name'];
}
$result->close();
// Making products 2D array (array(name, amount, unit))
$products_array = array();

CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['main0'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['main1'], $_POST['amount']);
// Submitting salades order
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['salades0'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['salades1'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['salades2'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['salades3'], $_POST['amount']);
// Submitting snacks order
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['snacks0'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['snacks1'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['snacks2'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['snacks3'], $_POST['amount']);
// Submitting desserts order
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['desserts0'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['desserts1'], $_POST['amount']);
CheckAndCalculate($conn, $products_array, $dish_id_array, $_POST['desserts2'], $_POST['amount']);

function CheckAndCalculate($conn, &$products_array, $dish_id_array, $dish, $amount) {
    if (isset($dish)) {
        // Getting dish id
        $dish_id = array_search($dish, $dish_id_array);

        CalculateProducts($conn, $products_array, $dish_id, $amount);
    }
}
?>
<head>
    <link href="productsTable.css" rel="stylesheet" type="text/css" media="all"/>
    <title>calculation page</title>
</head>
<body>
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
?>
</body>
</html>
