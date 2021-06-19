<?php
include_once '../CheckTimeActivity.php';

if (!isset($_SESSION["loggedin"])) {
    exit;
}

include_once '../../connectToTheDatabase.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <link href="../tables.css" rel="stylesheet" type="text/css" media="all"/>
    <title>Output Dishes</title>
</head>
<body>
<form action="AddDish/AddDish.php" method="get">
    <input type="submit" value="Add">
</form>
<form action="UpdateDish/UpdateDish.php" method="get">
    <input type="hidden" name="dish_id" id="update" value="">
    <input type="submit" value="Update">
</form>
<form action="DeleteDish.php" method="get">
    <input type="hidden" name="dish_id" id="delete" value="">
    <input type="submit" value="Delete">
</form>
<form action="CalculateDish.php" method="get">
    <input type="hidden" name="amount" value="1">
    <input type="hidden" name="dish_id" id="calculate" value="">
    <input type="submit" value="Calculate">
</form>

<table id="DishesTable">
<tr>
<th style="width: 1%">ID</th>
<th>Dish Name</th>
<th>Content</th>
<th>Category</th>
<th>Amount of persons</th>
<th style="width: 30%">Products</th>
</tr>
<?php
$sql = 'SELECT
                dishes.id,
                dishes.name AS dish_name,
                dishes.content,
                dishes.category,
                dishes.picture,
                dish_products.amount_of_persons,
                products.name AS product_name
            FROM
                dishes
            LEFT JOIN  dish_products ON dishes.id = dish_products.dish_id
            LEFT JOIN  products ON products.id = dish_products.product_id;';

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$previousOrderId = null;

foreach ($rows as $row) {
    if ($previousOrderId != $row['id']) {
        if (isset($previousOrderId)) {
            echo '</td>';
            echo '</tr>';
        }
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['dish_name'] . '</td>';
        echo '<td>' . $row['content'] . '</td>';
        echo '<td>' . $row['category'] . '</td>';
        echo '<td>' . $row['amount_of_persons'] . '</td>';
        echo '<td>' . $row['product_name'];
    } else {
        echo ', ' . $row['product_name'];
    }
    $previousOrderId = $row['id'];
}
$result->close();
$conn->close();
?>
</table>
</body>
<script>
    //  Select a Row from Table script
    var table = document.getElementById('DishesTable'), index;

    for (var i = 1; i < table.rows.length; i++) {
        table.rows[i].onclick = function () {
            if (!this.classList.contains("selected")) {
                // back side of select
                document.getElementById("update").value = this.cells[0].innerHTML;
                document.getElementById("delete").value = this.cells[0].innerHTML;
                document.getElementById("calculate").value = this.cells[0].innerHTML;

                // front side of select
                // remove the background from the previous selected row
                if (typeof index !== "undefined") {
                    table.rows[index].classList.remove("selected");
                }
                console.log(typeof index);
                // get the selected row index
                index = this.rowIndex;
                // add class selected to the row
                this.classList.toggle("selected");
                console.log(typeof index);
            } else {
                // back side of select
                document.getElementById("update").value = "";
                document.getElementById("delete").value = "";
                document.getElementById("calculate").value = "";

                // front side of select
                console.log(typeof index);
                index = this.rowIndex;
                this.classList.remove("selected");
                console.log(typeof index);
            }
        };
    }
    // Sort Table script
    const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

    const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
            v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
    )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

    // do the work...
    document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
        const table = th.closest('table');
        Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
            .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
            .forEach(tr => table.appendChild(tr) );
    })));
</script>
