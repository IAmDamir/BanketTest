<!DOCTYPE html>
<html lang="en">
<?php
include 'connectToTheDatabase.php';
?>

<head>
    <link href="order.css" rel="stylesheet" type="text/css" media="all"/>
    <title>order page</title>
</head>
<body>
<form id="ordersForm" action="submitOrders.php" method="post">

    <h3>Make an order</h3>
    <!-- Name -->
    <div class="label">
        <label for="name">Name</label>
    </div>
    <div class="content">
        <input type="text" id="name" name="name" placeholder="Please enter your name" required>
    </div>
    <br/>
    <!-- Surname -->
    <div class="label">
        <label for="surname">Surname</label>
    </div>
    <div class="content">
        <input type="text" id="surname" name="surname" placeholder="Please enter your surname">
    </div>
    <br/>
    <!-- Contact -->
    <div class="label">
        <label for="contact">Contact</label>
    </div>
    <div class="content">
        <input type="text" id="contact" name="contact" placeholder="Please enter your contacts" required>
    </div>
    <br/>
    <!-- Address -->
    <div class="label">
        <label for="address">Address</label>
    </div>
    <div class="content">
        <input type="text" id="address" name="address" placeholder="Please enter your address" required>
    </div>
    <br/>
    <!-- Deadline -->
    <div class="label">
        <label for="deadline">Due date</label>
    </div>
    <div class="content">
        <input type="datetime-local" id="deadline" name="deadline" required>
    </div>
    <br/>
    <!-- Wishes -->
    <div class="label">
        <label for="wishes">Wishes</label>
    </div>
    <div class="content">
        <textarea cols="35" rows="3" id="wishes" name="wishes" placeholder="Enter your wishes here"></textarea><br>
    </div>
    <!-- Amount of guests -->
    <div class="label">
        <label for="amount">Amount of guests</label>
    </div>
    <div class="content">
        <input type="number" min="1" id="amount" name="amount" required>
    </div>
    <br/>
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
    ?>

    <!-- Main dishes 2 -->
    <div class="label">
        <label>Main dishes</label>
    </div>
    <div class="content">
        <?php
        $i = 0;
        while ($i < 2) {
            echo "<select name=\"main$i\">";
            echo "<option selected value> -- select an option -- </option>";
            foreach ($main_name_array as $row) {
                echo "<option value=\"$row\">$row</option>";
            }
            unset($row);
            echo '</select>';
            $i++;
        }
        ?>
    </div>

    <!-- Salades 4 -->
    <div class="label">
        <label>Salades</label>
    </div>
    <div class="content">
        <?php
        $i = 0;
        while ($i < 4) {
            echo "<select name=\"salades$i\">";
            echo "<option selected value> -- select an option -- </option>";
            foreach ($salad_name_array as $row) {
                echo "<option value=\"$row\">$row</option>";
            }
            unset($row);
            echo '</select>';
            $i++;
        }
        ?>
    </div>
    <!-- Snacks 4 -->
    <div class="label">
        <label>Snacks</label>
    </div>
    <div class="content">
        <?php
        $i = 0;
        while ($i < 4) {
            echo "<select name=\"snacks$i\">";
            echo "<option selected value> -- select an option -- </option>";
            foreach ($snack_name_array as $row) {
                echo "<option value=\"$row\">$row</option>";
            }
            unset($row);
            echo '</select>';
            $i++;
        }
        ?>
    </div>

    <!-- Desserts 3 -->
    <div class="label">
        <label>Desserts</label>
    </div>
    <div class="content">
        <?php
        $i = 0;
        while ($i < 3) {
            echo "<select name=\"desserts$i\">";
            echo "<option selected value> -- select an option -- </option>";
            foreach ($dessert_name_array as $row) {
                echo "<option value=\"$row\">$row</option>";
            }
            unset($row);
            echo '</select>';
            $i++;
        }
        ?>
    </div>

    <input type="submit" name="submit" onclick="SubmitForm()">
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
