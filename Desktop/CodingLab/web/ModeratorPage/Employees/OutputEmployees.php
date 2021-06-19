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
<form action="AddEmployee.php" method="get">
    <input type="submit" value="Add">
</form>
<form action="UpdateEmployee.php" method="get">
    <input type="hidden" name="employee_id" id="update" value="">
    <input type="submit" value="Update">
</form>
<form action="DeleteEmployee.php" method="get">
    <input type="hidden" name="employee_id" id="delete" value="">
    <input type="submit" value="Delete">
</form>

<table id="ProductsTable">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Job</th>
        <th>Number</th>
        <th>Email</th>
    </tr>
    <?php
    $sql = 'SELECT
                id,
                name,
                job,
                contact_number,
                email
            FROM
                employees
            ORDER BY id;';

    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);


    foreach ($rows as $row) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['job'] . '</td>';
        echo '<td>' . $row['contact_number'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '</tr>';
    }
    $result->close();
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
                document.getElementById("update").value = "";
                document.getElementById("delete").value = "";

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