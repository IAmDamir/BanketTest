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
    <style>
        img {
            height: 250px;
            width: 250px;
        }
    </style>
</head>
<body>
<form action="AddPhoto.php" method="get">
    <input type="submit" value="Add">
</form>
<form action="UpdatePhoto.php" method="get">
    <input type="hidden" name="photo_name" id="updatePhoto" value="">
    <input type="hidden" name="dish_name" id="updateDish" value="">
    <input type="submit" value="Update">
</form>
<form action="DeletePhoto.php" method="get">
    <input type="hidden" name="photo_name" id="deletePhoto" value="">
    <input type="hidden" name="dish_name" id="deleteDish" value="">
    <input type="submit" value="Delete">
</form>

<table id="DishesTable">
    <tr>
        <th style="width: 1%">ID</th>
        <th>Photo</th>
        <th>Photo Name</th>
        <th style="width: 1%">Dish ID</th>
        <th>Dish Name</th>
        <th>Content</th>
        <th>Category</th>
    </tr>
    <?php
    $sql = 'SELECT
                id,
                picture,
                name,
                category,
                content
            FROM
                dishes;';

    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $id = 1;
    $photos_array = scandir($_SERVER['DOCUMENT_ROOT'].'/CodingLab/web/menu/');

    foreach ($rows as $row) {
        echo '<tr>';
        echo '<td>' . $id . '</td>';
        echo '<td><img alt="" class="img-responsive" src="../../menu/' . $row['picture'] . '"/></td>';
        echo '<td>' . $row['picture'] . '</td>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['content'] . '</td>';
        echo '<td>' . $row['category'] . '</td>';
        echo '</tr>';

        $photos_array = array_diff($photos_array, [$row['picture']]);
        $id++;
    }

    foreach ($photos_array as $photo) {
        echo '<tr>';
        echo '<td>' . $id . '</td>';
        echo '<td><img alt="" class="img-responsive" src="../../menu/' . $photo . '"/></td>';
        echo '<td>' . $photo . '</td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '</tr>';
        $id++;
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
                document.getElementById("updatePhoto").value = this.cells[2].innerHTML;
                document.getElementById("updateDish").value = this.cells[4].innerHTML;
                document.getElementById("deletePhoto").value = this.cells[2].innerHTML;
                document.getElementById("deleteDish").value = this.cells[4].innerHTML;

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
