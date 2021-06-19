<?php
include_once '../../CheckTimeActivity.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Update Dish</title>
</head>
<body>
<button onclick="location.href='../OutputDishes.php';"> Back</button>
<form action="AddProductsOfDish.php" method="post" enctype="multipart/form-data">
    <!-- New Dish Name -->
    <div class="label">
        <label for="dish_name">Dish Name</label>
    </div>
    <div class="content">
        <input type="text" id="dish_name" name="dish_name" required>
    </div>
    <!-- Amount of Persons -->
    <div class="label">
        <label for="amount_of_persons">Amount of Persons</label>
    </div>
    <div class="content">
        <input type="number" id="amount_of_persons" name="amount_of_persons" min="1" required>
    </div>
    <!-- Category of new Dish -->
    <div class="label">
        <label for="category">Category</label>
    </div>
    <input type="text" id="category" name="category" required>
    <br/>
    <!-- Content of new Dish -->
    <div class="label">
        <label for="content">Content</label>
    </div>
    <div class="content">
        <textarea id="content" name="content" cols="50" rows="5"></textarea>
    </div>
    <!-- Picture for new Dish -->
    <div class="label">
        <label for="content">Picture</label>
    </div>
    <div class="content">
        <input type="file" id="picture" name="picture">
    </div>
    <!-- Products of new Dish -->
    <div class="label">
        <label for="products">Products</label>
    </div>
    <div class="content">
        <textarea id="products" name="products" cols="50" rows="5"></textarea>
    </div>
    <input type="submit" id="submit" name="submit" value="Add">
</form>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>