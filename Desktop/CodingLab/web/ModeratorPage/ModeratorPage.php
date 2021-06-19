<?php
include_once 'CheckTimeActivity.php';

if (!isset($_SESSION["loggedin"])) {
    header("location: ModeratorPageLogin.php");
    exit;
}

include '../connectToTheDatabase.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            margin: 0; /* Reset default margin */
        }

        iframe {
            display: block; /* iframes are inline by default */
            border: none; /* Reset default border */
            height: 100vh; /* Viewport-relative units */
            width: 98vw;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

        #logout{
            position: absolute;
            right: 0;
            background-color: lightgray;
        }
    </style>
    <meta charset="UTF-8">
    <title>Moderator Page</title>
</head>
<body>
<!-- Tab links -->
<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'Orders')">Orders</button>
    <button class="tablinks" onclick="openTab(event, 'Dishes')">Dishes</button>
    <button class="tablinks" onclick="openTab(event, 'Products')">Products</button>
    <button class="tablinks" onclick="openTab(event, 'Employees')">Employees</button>
    <button class="tablinks" onclick="openTab(event, 'Reviews')">Reviews</button>
    <button class="tablinks" onclick="openTab(event, 'Questions')">Questions</button>
    <button class="tablinks" onclick="openTab(event, 'Dish Photos')">Dish Photos</button>
    <button id="logout" onclick="location.href='ModeratorPageLogout.php';"> LOG OUT </button>
</div>

<!-- Tab content -->
<div id="Orders" class="tabcontent">
    <iframe src="Orders/OutputOrders.php"></iframe>
</div>

<div id="Dishes" class="tabcontent">
    <iframe src="Dishes/OutputDishes.php"></iframe>
</div>

<div id="Products" class="tabcontent">
    <iframe src="Products/OutputProducts.php"></iframe>
</div>

<div id="Employees" class="tabcontent">
    <iframe src="Employees/OutputEmployees.php"></iframe>
</div>

<div id="Reviews" class="tabcontent">
    <iframe src="Reviews/OutputReviews.php"></iframe>
</div>

<div id="Questions" class="tabcontent">
    <iframe src="Questions/OutputQuestions.php"></iframe>
</div>

<div id="Dish Photos" class="tabcontent">
    <iframe src="Dish_Photos/OutputPhotos.php"></iframe>
</div>
</body>
<script>
    function openTab(evt, tabName) {
        // Declare all variables
        let i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<?php
foreach ($_SESSION as $key => $value) {
    unset($key);
}
$conn->close();
?>
</html>