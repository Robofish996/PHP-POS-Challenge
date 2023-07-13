<?php
session_start();

// Include the data.php file
require_once './data/data.php';

if (isset($_POST['selectedItemValue'])) {
    // Get the selected item value
    $selectedItemValue = $_POST['selectedItemValue'];

    // Find the selected item from the $items array
    $selectedItem = null;
    foreach ($items as $item) {
        if ($item['barcode'] == $selectedItemValue) {
            $selectedItem = $item;
            break;
        }
    }

    if ($selectedItem) {
        // Add the selected item to the session order
        $_SESSION['order'][] = $selectedItem;
        // Update the order total
        $_SESSION['orderTotal'] += $selectedItem['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S&S POS</title>
    <link rel="stylesheet" href="./static/css/style.css">
</head>
<body>
    <h1>
        <span style="color:red">Select</span> and <span style="color:blue">Save</span>
    </h1>

    <hr>

    <div class="till__display">
        <div>
            <span class="till__console">
                Amount: R <span><?php echo $_SESSION['orderTotal'] ?? 0; ?></span>
            </span>
        </div>
    </div>

    <hr>

    <section>
        <form class="items" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <?php foreach ($items as $item): ?>
                <button type="submit" name="selectedItemValue" value="<?php echo $item['barcode']; ?>" class="item">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" />
                    <h3><?php echo $item['name']; ?></h3>
                    <p>Barcode: <?php echo $item['barcode']; ?></p>
                </button>
            <?php endforeach; ?>
        </form>
    </section>

    <form action="checkout.php" method="get" class="checkout">
        <input type="hidden" name="subTotal" value="<?php echo $_SESSION['orderTotal'] ?? 0; ?>">
        <button type="submit">
            Proceed to payment
        </button>
    </form>

</body>
</html>
