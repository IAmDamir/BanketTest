<?php
include_once '../CheckTimeActivity.php';

if (empty($_GET['order_id'])) {
    header("location: OutputOrders.php");
    exit;
}

include_once '../../connectToTheDatabase.php';

if (isset($_GET['Delete anyways'])) {
    $sql = 'DELETE FROM orders WHERE order_id = ' . $_GET['order_id'] . ';';
    $conn->query($sql);
    $sql = 'DELETE FROM order_details WHERE id = ' . $_GET['order_id'] . ';';
    $conn->query($sql);
    $conn->close();

    header("location: OutputOrders.php");
    exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Delete Order</title>
</head>
<body>
<button onclick="location.href='OutputOrders.php';"> Back</button>
<?php
$sql = 'SELECT
            order_details.id,
            order_details.client_name,
            order_details.client_surname,
            order_details.client_contact,
            order_details.address,
            order_details.deadline,
            order_details.wishes,
            orders.amount,
            dishes.name
        FROM
            order_details
        INNER JOIN orders ON order_details.id = orders.order_id
        INNER JOIN dishes ON dishes.id = orders.dish_id
        WHERE
            order_details.id = ' . $_GET['order_id'] . ';';

$result = $conn->query($sql);
$row = $result->fetch_all(MYSQLI_ASSOC);

$firstTime = true;
foreach ($row as $selected) {
    if ($firstTime) {
        echo '<br/>order id - ' . $selected['id'];
        echo '<br/>client name - ' . $selected['client_name'];
        echo '<br/>client surname - ' . $selected['client_surname'];
        echo '<br/>client contact - ' . $selected['client_contact'];
        echo '<br/>address - ' . $selected['address'];
        echo '<br/>deadline - ' . $selected['deadline'];
        echo '<br/>wishes - ' . $selected['wishes'];
        echo '<br/>amount - ' . $selected['amount'];
        echo '<br/>name - ' . $selected['name'];

        $firstTime = false;
    } else {
        echo ', ' . $selected['name'];
    }
}

$result->close();
unset($row, $previousOrderId, $sql);
?>
<form action="DeleteOrder.php" method="get">
    <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>">
    <input type="submit" name="Delete anyways" value="Delete anyways">
</form>
</body>
