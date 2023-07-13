<?php

require_once './model/MenuItem.php';

session_start();

function addItem(MenuItem $menuItem) {
    // Add the selected item to the session order
    $_SESSION['order'][] = $menuItem;
    // Update the order total
    $_SESSION['orderTotal'] += $menuItem->getPrice();
}

if (isset($_POST['selectedItemValue'])) {
    // Get the selected item value
    $selectedItemValue = $_POST['selectedItemValue'];

    // Find the selected item from the $items array
    $selectedItem = null;
    foreach ($items as $item) {
        if ($item['barcode'] == $selectedItemValue) {
            $selectedItem = new MenuItem($item['barcode'], $item['name'], $item['price']);
            break;
        }
    }

    if ($selectedItem) {
        // Call the addItem() function to add the selected item to the order
        addItem($selectedItem);
    }
}

// Redirect back to the index page after adding the item
header("Location: ./../index.php");
exit;
?>
