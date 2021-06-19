<?php
// Checking if submit button is clicked
if (isset($_POST['submit'])) {
    include 'connectToTheDatabase.php';
    include 'calculationAlgorithm.php';

    // Submit orders to database
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $wishes = $_POST['wishes'];
    $deadline = $_POST['deadline'];
    // Making insert statement
    $insertStatement = "INSERT INTO order_details (client_name, client_surname, client_contact, address, deadline, wishes )
                        VALUES ('$name', '$surname', '$contact', '$address', '$deadline', '$wishes');";
    // Executing statement
    $conn->query($insertStatement);
    // Getting last id from order_details
    $id = $conn->insert_id;
    $amount = $_POST['amount'];
    // Submitting main dishes order
    checkAndSubmit($conn, 'main0', $amount, $id);
    checkAndSubmit($conn, 'main1', $amount, $id);
    // Submitting salades order
    checkAndSubmit($conn, 'salades0', $amount, $id);
    checkAndSubmit($conn, 'salades1', $amount, $id);
    checkAndSubmit($conn, 'salades2', $amount, $id);
    checkAndSubmit($conn, 'salades3', $amount, $id);
    // Submitting snacks order
    checkAndSubmit($conn, 'snacks0', $amount, $id);
    checkAndSubmit($conn, 'snacks1', $amount, $id);
    checkAndSubmit($conn, 'snacks2', $amount, $id);
    checkAndSubmit($conn, 'snacks3', $amount, $id);
    // Submitting desserts order
    checkAndSubmit($conn, 'desserts0', $amount, $id);
    checkAndSubmit($conn, 'desserts1', $amount, $id);
    checkAndSubmit($conn, 'desserts2', $amount, $id);
    // Closing the connection
    $conn->close();
    // Closing the window
}

// Function that checks if dish is ordered, if yes submit
function checkAndSubmit($conn, $name, $amount, $order_id) {
    if (isset($_POST["$name"])) {
        $selectStatement = "SELECT id FROM dishes WHERE name = '" . $_POST["$name"] . "' limit 1;";
        $result = $conn->query($selectStatement);
        $dish_id = $result->fetch_assoc();

        if ($dish_id['id'] != 0) {
            $insertStatement = "INSERT INTO orders (amount, order_id, dish_id)
                                VALUES ($amount, $order_id, '" . $dish_id['id'] . "');";
            $conn->query($insertStatement);
        }
    }
}