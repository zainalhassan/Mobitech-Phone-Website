<?php

require_once "header.php";
if(isset($_GET['productID']))
{
    $getInfoQuery = "SELECT * FROM products WHERE productID = '{$_GET['productID']}';";

}
else
{
    $getInfoQuery = "SELECT *, CONCAT(productCompany, ' ', productName) AS prodName FROM products HAVING prodName = '{$_GET['productName']}';";
}

$result = mysqli_query($connection, $getInfoQuery);

$row = mysqli_fetch_assoc($result);
echo "<div id = 'productContainer'> ";
    echo "<div class = 'productLeft'>";
        echo "<br> <div class='productName'>";
        if(!is_null($row) && $row != 0) {
            echo "<h1 class='prodNameHeader'>{$row['productCompany']} {$row['productName']} </h1>";
            echo "</div>";
            $cart = array();
            if(isset($_SESSION['loggedIn']))
            {

                $result = mysqli_query($connection, $getInfoQuery);
                $n = mysqli_num_rows($result);
                echo "<form method='post'>";
                echo "<input type='submit' name='addBtn' value='add to cart' class='btn btn-primary'>";
                echo "<br>";
                if ($n > 0)
                {
                    if( $row['productQuantity'] > 10)
                    {
                        echo "<select name = 'qtySelect'>";
                        for($i = 1; $i <= 10; $i++)
                        {
                            echo "<option> $i </option>";
                        }
                        echo "</select>";
                    }
                    else
                    {
                        echo "<select name = 'qtySelect'>";
                        for($i = 1; $i <= $row['productQuantity']; $i++)
                        {
                            echo "<option value = '$i'> $i </option>";
                        }
                        echo "</select>";
                    }
                    echo "<input type='submit' name='buyNowBtn' value='Buy Now' class='btn btn-warning'>";
                    echo "</form>";
                    if(isset($_POST['addBtn']))
                    {
                        $row['productQuantity'] = $_POST['qtySelect'];
                        echo $row['productQuantity'];
                        array_push($_SESSION['cart'], $row);

                    }
                    if(isset($_POST['buyNowBtn']))
                    {
                        $row['productQuantity'] = $_POST['qtySelect'];
                        echo $row['productQuantity'];
                        array_push($_SESSION['cart'], $row);
                    }
                }
            }
            else
            {
                echo "<form action = 'signUp.php' method='post'> <input type='submit' name='signUp' value='Sign up to Buy' class='btn btn-primary'> </form>";
                echo "<form action = 'signIn.php' method='post'> <input type='submit' name='signIn' value='Sign in to Buy' class='btn btn-primary'> </form>";
            }
            echo <<<_END
            <div class="form-row">
            <div id="c" class="form-group col-md-5">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">    
_END;
            $getImageQuery = "SELECT productImage FROM productImages WHERE productID = '{$row['productID']}'";
            $result = mysqli_query($connection, $getImageQuery);
            $n = mysqli_num_rows($result);
            if ($n > 0)
            {
                echo <<<_END
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
_END;
                for($i = 1; $i < $n; $i++)
                {


                    echo <<<_END
                        
                        <li data-target="#carouselExampleIndicators" data-slide-to="{$i}"></li>
_END;
                }
                    echo <<<_END
                        
                    </ol>
                    <div class="carousel-inner">
_END;

                $isActive = 0;
                for($i = 0; $i < $n; $i++)
                {

                    $row = mysqli_fetch_assoc($result);
                    $img = $row['productImage'];
                    if($isActive ==0){
                        $isActive++;
                    echo <<<_END
                        <div class="carousel-item active">
                            <img src="$img" class="d-block w-100" alt="...">
                        </div>
_END;
                        }
                        else
                        {
                            echo <<<_END
                        
                        <div class="carousel-item">
                            <img src="$img" class="d-block w-100" alt="...">
                        </div>
_END;
                        }
                }
            }
            echo <<<_END
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
</div>
_END;


            echo <<<_END
               <div class="card-body">
                <h2 class="card-title">asfffffffffffffffff</h2>
                <h5 class="card-title">qwafasfasfasf</h5>
                <p class="card-text">sdfasdfsda</p>
           </div>
            </div>
            </div>
        </div>
    </div>
_END;
            echo "</div>";

        }
        else
        {
            echo "<h1> No such item </h1>";
        }
