<?php
function CalculateProducts($conn, &$products_array, $dish_id, $amount_of_guests) {

    // Getting all products of the dish from database
    $selectStatement = "SELECT amount_of_products, amount_of_persons, name, unit
                        FROM dish_products INNER JOIN products 
                        ON dish_products.product_id = products.id
                        WHERE dish_id = '$dish_id';";
    $result = $conn->query($selectStatement);
    // Adding the products to $products_array
    FillProductsTable($result, $products_array, $amount_of_guests);
}
function FillProductsTable($result, &$products_array, $amount_of_guests) {
    while ($row = mysqli_fetch_assoc($result)) {
        $multiplier = floor($amount_of_guests / $row['amount_of_persons']);
        if ($amount_of_guests % $row['amount_of_persons'] > $row['amount_of_persons']/2) {
            $multiplier += 1;
        } else if ($amount_of_guests < $row['amount_of_persons']) {
            $multiplier += 1;
        }
        $amount = $multiplier * $row['amount_of_products'];
        $amount = round($amount*1000)/1000;

        if (!in_array($row['name'], array_column($products_array, 'name'))) {
            $inner_array = array('name' => $row['name'],
                'amount' => $amount,
                'unit' => $row['unit']);
            array_push($products_array, $inner_array);
        } else {
            foreach ($products_array as &$inner_array) {
                if ($inner_array['name'] == $row['name']) {
                    $inner_array['amount'] += $amount;
                    break;
                }
            }
            unset($inner_array);
        }
    }
}