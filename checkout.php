<?php

// Display error codes and messages
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Include the calculateVAT.php file
require_once './include/calculateVAT.php';

// Redirect back to index if payment button is selected
if (isset($_GET['payment'])) {

    // Clear the session order and order total
    unset($_SESSION['order']);
    unset($_SESSION['orderTotal']);

    // Redirect back to the index page
    header("Location: ./index.php");
    exit;
}

// Generate a random order number
function generateOrderNumber()
{
    return 'ORDERNO' . rand(1000, 9999);
}

$orderNumber = generateOrderNumber();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S&S POS | Pay</title>
    <link rel="stylesheet" href="./static/css/checkout.css">
</head>
<body>
    <h1>
        <span style="color:red">Select</span> and <span style="color:blue">Save</span>
    </h1>

    <hr>

    <h2>Order Number: <?php echo $orderNumber; ?></h2>

    <h2>Items Purchased:</h2>

    <table>
        <tr>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price per item</th>
            <th>Total price</th>
        </tr>
        <?php
        // Display the purchased items from the session order with quantities
        if (isset($_SESSION['order'])) {
            $orderItems = [];

            foreach ($_SESSION['order'] as $item) {
                $itemKey = $item['name'];

                if (isset($orderItems[$itemKey])) {
                    $orderItems[$itemKey]['quantity']++;
                    $orderItems[$itemKey]['totalPrice'] += $item['price'];
                } else {
                    $orderItems[$itemKey] = [
                        'name' => $item['name'],
                        'quantity' => 1,
                        'price' => $item['price'],
                        'totalPrice' => $item['price'],
                        'image' => $item['image']
                    ];
                }
            }

            foreach ($orderItems as $item) {
                echo "<tr>";
                echo "<td><img src='{$item['image']}' alt='{$item['name']}' width='100'></td>";
                echo "<td>{$item['quantity']}</td>";
                echo "<td>R{$item['price']}</td>";
                echo "<td>R{$item['totalPrice']}</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <hr>

    <h2>
        Amount: R<span><?php echo $_SESSION['orderTotal'] ?? 0.00; ?></span>
        <br>
        VAT Amount: R<span><?php echo calculateVAT($_SESSION['orderTotal'] ?? 0.00); ?></span>
        <br>
        <br>
        Subtotal for all items: R<span><?php echo $_SESSION['orderTotal'] ?? 0.00; ?></span>
    </h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <button style="background-color:red" type="submit" name="payment">Pay with card</button>
        <button style="background-color:cornflowerblue" type="submit" name="payment">Pay with cash</button>
    </form>

</body>

</html>
