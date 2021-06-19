<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
<body>
    <button onclick="location.href='OutputProducts.php';"> Back </button>
    <form action="SubmitProduct.php" method="post">
        <div class="label">
            <label for="product_name">Product Name</label>
        </div>
        <div class="content">
            <input type="text" id="product_name" name="product_name"
                   value="<?php if (isset($_GET['product_name'])) { echo $_GET['product_name'];}?>" required>
        </div>
        <!-- Unit -->
        <div class="label">
            <label for="unit">Unit</label>
        </div>
            <input type="text" id="unit" name="unit"
                   value="<?php if (isset($_GET['unit'])) { echo $_GET['unit'];}?>" required>
        <br/>
        <!-- Amount of Main Dishes -->
        <div class="label">
            <label for="amount_of_dishes">Main Dishes</label>
        </div>
        <div class="content">
            <input type="number" min="0" value="0" id="amount_of_dishes" name="amount_of_main" required>
        </div>
        <!-- Amount of Salades -->
        <div class="label">
            <label for="amount_of_dishes">Amount of Salades</label>
        </div>
        <div class="content">
            <input type="number" min="0" value="0" id="amount_of_dishes" name="amount_of_salades" required>
        </div>
        <!-- Amount of Snacks -->
        <div class="label">
            <label for="amount_of_dishes">Amount of Snacks</label>
        </div>
        <div class="content">
            <input type="number" min="0" value="0" id="amount_of_dishes" name="amount_of_snacks" required>
        </div>
        <!-- Amount of Desserts -->
        <div class="label">
            <label for="amount_of_dishes">Amount of Desserts</label>
        </div>
        <div class="content">
            <input type="number" min="0" value="0" id="amount_of_dishes" name="amount_of_desserts" required>
        </div>
        <input type="submit" name="submit">
    </form>
</body>
<!-- Script that prevents form from resubmitting after reload -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</html>