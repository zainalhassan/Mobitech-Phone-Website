<?php
require_once "header.php";

echo <<<_END
        <h1 class = "header1"> Checkout Complete</h1>
<hr>
<div class="alert alert-info" role="alert">
    <h3 class="alert-heading">Your order has been placed</h3>
    <br>
    
    <h5>We aim to dispatch all standard service orders within 2 working days. After we have posted your order, it will be delivered within 1-2 days.</h5>
    <hr>
    <h6><a href="account.php">View orders </a> or <a href="welcome.php">continue shopping</a></h6>
</div>
_END;
