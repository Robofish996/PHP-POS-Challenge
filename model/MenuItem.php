<?php

class MenuItem {
    // Properties
    private $barcode;
    private $name;
    private $price;

    // Constructor
    public function __construct($barcode, $name, $price) {
        $this->barcode = $barcode;
        $this->name = $name;
        $this->price = $price;
    }

    // Methods
    public function convertToHTML() {
        // Generate HTML representation of the menu item
        $html = '<div class="menu-item">';
        $html .= '<h3>' . $this->name . '</h3>';
        $html .= '<p>Barcode: ' . $this->barcode . '</p>';
        $html .= '<p>Price: $' . $this->price . '</p>';
        $html .= '</div>';

        return $html;
    }

    public static function loadData($data) {
        // Convert array data to MenuItem objects
        $menuItems = [];
        foreach ($data as $item) {
            $menuItem = new MenuItem($item['barcode'], $item['name'], $item['price']);
            $menuItems[] = $menuItem;
        }
        return $menuItems;
    }
}
