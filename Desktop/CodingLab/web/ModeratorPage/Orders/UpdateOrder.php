<?php
include_once '../CheckTimeActivity.php';

if(empty($_GET['order_id']) && empty($_POST['order_id'])) {
    header("location: OutputOrders.php");
    exit;
}

include_once '../../connectToTheDatabase.php';

if (isset($_POST['submit'])) {
    // Updating order_details table
    $order_id = $_POST['order_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $wishes = $_POST['wishes'];
    $deadline = $_POST['deadline'];
    // Making insert statement
    $updateStatement = "UPDATE order_details
                        SET client_name = '$name',
                            client_surname = '$surname',
                            client_contact = '$contact',
                            address = '$address',
                            deadline = '$deadline',
                            wishes = '$wishes'
                        WHERE id = '$order_id';";
    // Executing statement
    $conn->query($updateStatement);
    // Updating orders table
    // Getting id for order_details
    $amount = $_POST['amount'];
    $dishes = $_POST['dishes'];

    $sql = "DELETE FROM orders WHERE order_id = $order_id;";
    $conn->query($sql);

    $selectStatement = "SELECT id, name FROM dishes;";
    $result = $conn->query($selectStatement);
    $dish_id_array = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $dish_id_array[$row['id']] = $row['name'];
    }
    $result->close();

    $dishes_array = explode(",", $dishes);
    $dishes_array = array_map('trim', $dishes_array);
    $dishes_array = array_filter($dishes_array, 'strlen');

    foreach ($dishes_array as $dish) {
        $sql = "SELECT id FROM dishes WHERE name = '$dish' limit 1;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Getting all products of the dish from database
            $selectStatement = "SELECT id FROM dishes WHERE name = '$dish' limit 1;";
            $result = $conn->query($selectStatement);
            $dish_id = $result->fetch_assoc();

            if ($dish_id['id'] != 0) {
                $insertStatement = "INSERT INTO orders (amount, dish_id, order_id)
                                VALUES ('$amount', '" . $dish_id['id'] . "', '$order_id');";
                $conn->query($insertStatement);
            }
        }
    }

    header("location: OutputOrders.php");
    exit;
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
    <title>Update Order</title>
</head>
<body>
<button onclick="location.href='OutputOrders.php';"> Back </button>
<?php
if(isset($_GET['order_id'])) {
    $selectStatement = 'SELECT
                            order_details.id,
                            order_details.client_name,
                            order_details.client_surname,
                            order_details.client_contact,
                            order_details.address,
                            order_details.deadline,
                            order_details.wishes,
                            orders.amount,
                            dishes.name AS dish_name
                        FROM
                            order_details
                        INNER JOIN orders ON order_details.id = orders.order_id
                        INNER JOIN dishes ON dishes.id = orders.dish_id
                        WHERE
                            order_details.id = ' . $_GET['order_id'] . ';';

    $result = $conn->query($selectStatement);

    $row = $result->fetch_all(MYSQLI_ASSOC);

    $firstTime = true;
    foreach ($row as $selected) {
        if ($firstTime) {
            echo '<form action="UpdateOrder.php" method="post">
    <input type="hidden" name="order_id" value="' . $selected['id'] . '">
    <div class="label">
        <label for="name">Name</label>
    </div>
    <div class="content">
        <input type="text" id="name" name="name" value="' . $selected['client_name'] . '" required>
    </div>
    <br/>
    <!-- Surname -->
    <div class="label">
        <label for="surname">Surname</label>
    </div>
    <div class="content">
        <input type="text" id="surname" name="surname" value="' . $selected['client_surname'] . '">
    </div>
    <br/>
    <!-- Contact -->
    <div class="label">
        <label for="contact">Contact</label>
    </div>
    <div class="content">
        <input type="text" id="contact" name="contact" value="' . $selected['client_contact'] . '" required>
    </div>
    <br/>
    <!-- Address -->
    <div class="label">
        <label for="address">Address</label>
    </div>
    <div class="content">
        <input type="text" id="address" name="address" value="' . $selected['address'] . '" required>
    </div>
    <br/>
    <!-- Deadline -->
    <div class="label">
        <label for="deadline">Due date</label>
    </div>
    <div class="content">
        <input type="datetime-local" id="deadline" name="deadline" 
        value="' . date('Y-m-d\TH:i', strtotime($selected['deadline'])) . '" required>
    </div>
    <br/>
    <!-- Wishes -->
    <div class="label">
        <label for="wishes">Wishes</label>
    </div>
    <div class="content">
        <textarea cols="50" rows="5" id="wishes" name="wishes">' . $selected['wishes'] . '</textarea><br>
    </div>
    <!-- Amount of guests -->
    <div class="label">
        <label for="amount">Amount of guests</label>
    </div>
    <div class="content">
        <input type="number" min="1" id="amount" name="amount" value="' . $selected['amount'] . '" required>
    </div>
    <br/>
    <!-- Wishes -->
    <div class="label">
        <label for="wishes">Wishes</label>
    </div>
    <div class="content">
        <textarea cols="50" rows="5" id="dishes" name="dishes">' . $selected['dish_name'];
            $firstTime = false;
        } else {
            echo ', ' . $selected['dish_name'];
        }
    }
    echo '</textarea><br>
    </div>
    <input type="submit" name="submit">
        </form>';

    $result->close();
    unset($row, $previousOrderId, $sql);
}
?>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
