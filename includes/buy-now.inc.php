<?php

session_start();


// Gets items from form

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];
}

//include 'dbh.inc.php';

//$id = the product id
    
    if (isset($_SESSION['cart_system'][$id])) {
        $_SESSION['cart_system'][$id]['quantity'] += $quantity;
    } 
    else {
        // Add new product to the cart
        $_SESSION['cart_system'][$id] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity,
        ];
    }
    

    // Redirect to the checkout page
    header('Location: ../pages/top-of-home-page/checkout-page.php');
    exit;