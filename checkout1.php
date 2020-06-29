<?php
require_once "header.php";

if(empty($_SESSION['cart']))
{
    echo "Cart is empty";
    echo '<pre>'; var_dump($_SESSION); echo '</pre>';
}
else
{
    echo <<<_END
    <div class= "card card-body">
        <h1> Checkout </h1>
        
        
        <br>
_END;
    $total = 0;
    $arrayIndex = 0;
    foreach ($_SESSION['cart'] as $cartProd)
    {
        echo "<div class='cartProd'>";
        echo $cartProd['productCompany'] . ' ' . $cartProd['productName'];
        echo "<br>" . 'Qty: ' . $cartProd['productQuantity'];
        $price = $cartProd['productPrice'] * $cartProd['productQuantity'];

        echo "<div class='cartPrice'> £{$price}
                            <form method='post'>
                                 <button id = 'removeFromCartBtn' name = 'removeFromCartBtn' value=$arrayIndex class='btn btn-danger'> Remove </button>
                            </form>
                            </div>";
        echo "</div>";
        echo "<br>";
        $total = $total + $price;
        $arrayIndex++;
    }
    if(isset($_POST['removeFromCartBtn']))
    {
        unset($_SESSION['cart'] [$_POST['removeFromCartBtn']]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        echo " deleted";
        echo "<br>";
        foreach ($_SESSION['cart'] as $a)
        {
            foreach ($a as $b)
            {
                echo $b;
            }
        }

    }
    $orderDate = date('Y-m-d H:i:s');
    $vat = $total * 0.2;
    $totalWithVAT = $total + $vat;
    echo "<div class='totalDiv'>
                            <h3 class='totalHeader'> subtotal: </h3>
                            <div class='innerPriceDiv'>  <h3 id = 'subTotal'> £$total </h3> </div>
                            </div>";
    echo "<div class='totalDiv'>
                            <h3 class='totalHeader'> VAT: </h3>
                            <div class='innerPriceDiv'>  <h3 id = 'vat'> £$vat </h3> </div>
                            </div>";
    echo "<div class='totalDiv'>
                            <h2 class='totalHeader'> Total: </h2>
                            <div class='innerPriceDiv'>  <h2 id = 'total'> £$totalWithVAT </h2> </div>
                            </div>";
    echo <<<_END
            <button id = 'paymentBtn' name = 'paymentBtn' class='btn btn-success' data-toggle="modal" data-target="#exampleModal"> Proceed with Payment </button>
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
                            <form role="form">
                            <div class="form-group">
                                <label for="username">Full name (on the card)</label>
                                <input type="text" class="form-control" name="username" placeholder="" required="">
                            </div>
                        
                            <div class="form-group">
                                <label for="cardNumber">Card number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cardNumber" placeholder="">
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
                                            <input type="number" class="form-control" placeholder="MM" name="">
                                            <input type="number" class="form-control" placeholder="YY" name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                        <input type="number" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            </form>
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

_END;



    $sql = "SELECT customerID FROM users WHERE usersUsername = '{$_SESSION['username']}';";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $customerID =  $row['customerID'];

    if(isset($_POST['placeOrderBtn']))
    {
        $sql = "INSERT INTO orders (customerID, orderDate, orderSubtotal, orderVAT, orderTotal) VALUES ('$customerID', '$orderDate', '$total', '$vat', '$totalWithVAT');";
        if (mysqli_query($connection, $sql))
        {
            echo "Inserted<br>";
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
                        echo "row inserted<br>";


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
echo "<br>";
require_once "footer.php";
?>
