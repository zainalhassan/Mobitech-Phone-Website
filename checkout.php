<?php
require_once "header.php";

if(empty($_SESSION['cart']))
{
    echo "<h2>Cart is empty</h2>";
//    echo '<pre>'; var_dump($_SESSION); echo '</pre>';
}
else {
    echo <<<_END
    <div class="row justify-content-center">
    <div class="col-md-4 order-md-2 mb-4">
        <h4 class="d-flex justify-content-center align-items-center mb-3">
            <span class="text-muted">Review your Order and Checkout</span>
<!--            <span class="badge badge-secondary badge-pill">3</span>-->
        </h4>
<ul class="list-group mb-3">
_END;
    $total = 0;
    $arrayIndex = 0;
    foreach ($_SESSION['cart'] as $cartProd) {
        $price = $cartProd['productPrice'] * $cartProd['productQuantity'];


        ?>

<!--        <div class="form-group col-md-0 ">-->
        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="col-md-8 ">
                <h5 class="my-0"><?php echo $cartProd['productCompany'] . ' ' . $cartProd['productName'] ?></h5>
                <h6 class="text-muted"><?php echo 'Qty: ' . $cartProd['productQuantity'] ?></h6>
            </div>
            <h6 class="text-muted"><?php echo "£" . $price ?></h6>
            <form method='post'>
                <button id='removeFromCartBtn' name='removeFromCartBtn' value='<?php echo $arrayIndex?>' class='btn btn-danger'>
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </li>
        <?php
        $total = $total + $price;
        $arrayIndex++;
    }
    $orderDate = date('Y-m-d H:i:s');
    $vat = $total * 0.2;
    $totalWithVAT = $total + $vat;

    ?>
    <li class="list-group-item d-flex justify-content-between">
        <span>SubTotal</span>
        <strong>£<?php echo $total ?></strong>
    </li>

    <li class="list-group-item d-flex justify-content-between">
        <span>VAT</span>
        <strong>£<?php echo $vat ?></strong>
    </li>


    <li class="list-group-item d-flex justify-content-between">
        <span>Total (GBP)</span>
        <strong>£<?php echo $totalWithVAT ?></strong>
    </li>
    </ul>


    <!--    </div>-->


    <button id = 'paymentBtn' name = 'paymentBtn' class='btn btn-success btn-block' data-toggle="modal" data-target="#exampleModal"> Proceed with Payment </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Please enter payment method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#nav-tab-card">
                                <i class="fa fa-credit-card"></i> Credit Card</a></li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#nav-tab-bank">
                                <i class="fa fa-university"></i>  Bank Transfer</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="nav-tab-card">
                            <form role="form" method="POST">
                                <div class="form-group">
                                    <label for="username">Full name (on the card)</label>
                                    <input type="text" class="form-control" name="username" placeholder="" required>
                                </div>

                                <div class="form-group">
                                    <label for="cardNumber">Card number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cardNumber" placeholder="" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text text-muted">
                                            <i class="fab fa-cc-visa"></i>   <i class="fab fa-cc-amex"></i>  
                                            <i class="fab fa-cc-mastercard"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label><span class="hidden-xs">Expiration</span> </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="MM" name="" required>
                                                <input type="number" class="form-control" placeholder="YY" name="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                            <input type="number" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="nav-tab-bank">
                            <dl class="param">
                                <dt>BANK: </dt>
                                <dd> Barclays Bank</dd>
                            </dl>
                            <dl class="param">
                                <dt>ACCOUNT NUMBER: </dt>
                                <dd> 8713872989027</dd>
                            </dl>
                            <dl class="param">
                                <dt>SORT CODE: </dt>
                                <dd> 34-03-54</dd>
                            </dl>
                            <p><strong>Note:</strong> Refunds will take around 3-5 working days, this is, upon obtaining the returning goods, in a resellable condition</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <form method="post">
                        <button name = "placeOrderBtn" id = "placeOrderBtn" class="btn btn-primary">Place order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php
    if (isset($_POST['removeFromCartBtn'])) {
        echo "asdad".$_POST['removeFromCartBtn'];
        unset($_SESSION['cart'] [$_POST['removeFromCartBtn']]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        ?>
        <script type="text/javascript">
            window.location.href = 'checkout.php';
        </script>
        <?php

    }



    $sql = "SELECT customerID FROM users WHERE usersUsername = '{$_SESSION['username']}';";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $customerID =  $row['customerID'];

    if(isset($_POST['placeOrderBtn']))
    {
        $sql = "INSERT INTO orders (customerID, orderDate, orderSubtotal, orderVAT, orderTotal) VALUES ('$customerID', '$orderDate', '$total', '$vat', '$totalWithVAT');";
        if (mysqli_query($connection, $sql))
        {

            $sql = "SELECT orderID FROM orders WHERE orderDate = '$orderDate' AND customerID = '$customerID';";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);

            if(!is_null($row) && $row != 0)
            {
                foreach ($_SESSION['cart'] as $cartProd)
                {
                    $orderID = $row['orderID'];
                    $productID = $cartProd['productID'];
                    $price = $cartProd['productPrice'] * $cartProd['productQuantity'];
                    $productQuantity = $cartProd['productQuantity'];
                    $sql = "INSERT INTO orderline VALUES ('$orderID','$productID','$productQuantity', '$price')";
                    if (mysqli_query($connection, $sql))
                    {

                        $sql = "UPDATE Products SET productQuantity = productQuantity - '$productQuantity' WHERE productId = '$productID'";
                        if (mysqli_query($connection, $sql)) {
                        }
                        else{

                        }

//
                        ?>

                        <script type="text/javascript">
                                 window.location.href = 'checkoutSuccessful.php';
                        </script>
                                <?php


                    }
                    else
                    {
                        die("Error inserting row: " . mysqli_error($connection));
                    }
                }
                //once order placed, empty cart
                $_SESSION['cart'] = array();
            }
        }
        else
        {
            die("not inserted" . mysqli_error($connection));
        }
    }

}

require_once "footer.php";