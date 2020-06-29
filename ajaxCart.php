<?php
require_once "credentials.php";
session_start();

if(isset($_POST['key']))
{
    if($_POST['key'] == 'cart')
    {
        exit(json_encode($_SESSION['cart']));
    }
    if($_POST['key'] == 'cartDelete')
    {
        $index = $connection->real_escape_string($_POST['index']);
        unset($_SESSION['cart'] [$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        exit(json_encode($_SESSION['cart']));
    }
}
?>