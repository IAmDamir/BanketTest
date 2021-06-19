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
    <title>Output orders</title>
</head>
<body>
<form action="AddProduct.php" method="get">
    <input type="submit" value="Add">
</form>
<form action="UpdateProduct.php" method="get">
    <input type="hidden" name="product_id" id="update" value="">
    <input type="submit" value="Update">
</form>
<form action="DeleteProduct.php" method="get">
    <input type="hidden" name="product_id" id="delete" value="">
    <input type="submit" value="Delete">
</form>
<form action="CalculateProduct.php" method="get">
    <input type="hidden" name="product_id" id="calculate" value="">
    <input type="submit" value="Calculate">
</form>

<table id="ProductsTable">
    <tr>
        <th onclick="sortTable(0)">ID</th>
        <th onclick="sortTable(1)">Product Name</th>
        <th onclick="sortTable(2)">Unit</th>
        <th onclick="sortTable(3)">Dishes</th>
    </tr>
    <?php
    $sql = 'SELECT
                products.id,
                products.name AS product_name,
                products.unit,
                dishes.name AS dish_name
            FROM
                products
            LEFT JOIN dish_products ON products.id = dish_products.product_id
            LEFT JOIN dishes ON dish_products.dish_id = dishes.id
            ORDER BY products.id;';

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
            echo '<td>' . $row['product_name'] . '</td>';
            echo '<td>' . $row['unit'] . '</td>';
            echo '<td>' . $row['dish_name'];
        } else {
            echo ', ' . $row['dish_name'];
        }
        $previousOrderId = $row['id'];
    }
    $result->close();
    unset($rows, $row, $previousOrderId, $sql);
    ?>
</table>
</body>
<script>
    //  Select a Row from Table script
    var table = document.getElementById('ProductsTable'), index;

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
                // get the selected row index
                index = this.rowIndex;
                // add class selected to the row
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