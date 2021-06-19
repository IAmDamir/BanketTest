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
<form action="UpdateOrder.php" method="get">
    <input type="hidden" name="order_id" id="update" value="">
    <input type="submit" value="Update">
</form>
<form action="DeleteOrder.php" method="get">
    <input type="hidden" name="order_id" id="delete" value="">
    <input type="submit" value="Delete">
</form>
<form action="CalculateOrder.php" method="get">
    <input type="hidden" name="order_id" id="calculate" value="">
    <input type="submit" value="Calculate">
</form>

<table id="OrdersTable">
<tr>
<th style="width: 1%">ID</th>
<th style="width: 20%">Client Name</th>
<th>Deadline</th>
<th style="width: 20%">Wishes</th>
<th style="width: 1%">Amount of persons</th>
<th>Dish</th>
</tr>
<?php
$sql = 'SELECT
                order_details.id,
                order_details.client_name,
                order_details.client_surname,
                order_details.deadline,
                order_details.wishes,
                orders.amount,
                dishes.name
            FROM
                order_details
            INNER JOIN orders ON orders.order_id = order_details.id
            INNER JOIN dishes ON orders.dish_id = dishes.id;';

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
        echo '<td>' . $row['client_name'] . ' ' . $row['client_surname'] . '</td>';
        echo '<td>' . $row['deadline'] . '</td>';
        echo '<td>' . $row['wishes'] . '</td>';
        echo '<td>' . $row['amount'] . '</td>';
        echo '<td>' . $row['name'];
    } else {
        echo ', ' . $row['name'];
    }
    $previousOrderId = $row['id'];
}
echo '</td>';
echo '</tr>';
$result->close();
unset($rows, $row, $previousOrderId, $sql);
?>
</table>
</body>
<script>
    //  Select a Row from Table script
    var table = document.getElementById('OrdersTable'), index;

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