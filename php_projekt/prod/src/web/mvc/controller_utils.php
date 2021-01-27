<?php

function &get_cart()
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; //pusty koszyk
    }

    return $_SESSION['cart'];
}
function &get_cartp()
{
    if (!isset($_SESSION['cartp'])) {
        $_SESSION['cartp'] = []; 
    }

    return $_SESSION['cartp'];
}
