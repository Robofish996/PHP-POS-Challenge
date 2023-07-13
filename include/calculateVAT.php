<?php

function calculateVAT($PurchasedItemsTotal) {
    $vatAmount = $PurchasedItemsTotal * 0.15;
    return $vatAmount;
}

?>
