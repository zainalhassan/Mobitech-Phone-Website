<?php

require_once "header.php";
if(isset($_GET['productID']))
{
    ?>


    <?php
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
if(!is_null($row) && $row != 0)
{
    echo "</div>";
    $cart = array();
    if(isset($_SESSION['loggedIn']))
    {

        $result = mysqli_query($connection, $getInfoQuery);
        $n = mysqli_num_rows($result);

        if(isset($_POST['addBtn']))
        {
            $row['productQuantity'] = $_POST['qtySelect'];
            $id = $row['productID'];
            array_push($_SESSION['cart'], $row);
            ?>
            <script type="text/javascript">
                window.location.href = 'viewProduct.php?productID=<?php echo $id ?>';
            </script>


<?php


        }
        if(isset($_POST['buyNowBtn']))
        {
            $row['productQuantity'] = $_POST['qtySelect'];

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
//$result2 = mysqli_query($connection, $getImageQuery);
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
                            <img id="c" src="$img" class="d-block w-100" alt="...">
                        </div>
_END;
        }
        else
        {
            echo <<<_END
                        
                        <div class="carousel-item">
                            <img id="c" src="$img" class="d-block w-100" alt="...">
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
$result2 = mysqli_query($connection, $getInfoQuery);
$rows = mysqli_fetch_assoc($result2);
$productCompany = $rows['productCompany'];
$productName = $rows['productName'];
$productSpecs = $rows['productSpecs'];
$productPrice = "£".$rows['productPrice'];
$cardTitle = $productCompany." ".$productName;

echo <<<_END
<div class="form-group col-md-1">
</div>
<div class="form-group col-md-5">
               <div class="card-body">
               <hr>
                <h2 class="card-title">{$cardTitle}</h2>
                <h4 class="card-text">{$productPrice}</h4>
                <hr>
                <p class="card-title">{$productSpecs}</p>
                
                
_END;
echo "<form method='post'>";

echo "<br>";

echo "<div class='form-row'><div class='form-group col-md-2'>";


if( $rows['productQuantity'] > 10)
{
    echo "<select name = 'qtySelect' class='btn btn-dark btn-block'>";
    for($i = 1; $i <= 10; $i++)
    {
        echo "<option> $i </option>";
    }
    echo "</select></div>";
}
else
{
    echo "<select name = 'qtySelect' class='btn btn-dark btn-block'>";
    for($i = 1; $i <= $row['productQuantity']; $i++)
    {
        echo "<option value = '$i'> $i </option>";
    }
    echo "</select></div>";
}
echo "<div class='form-group col-md-10'><input type='submit' id='addBtn' name='addBtn' value='add to cart' class='btn btn-info btn-block'></div>";
echo "<input type='submit' name='buyNowBtn' value='Buy Now' class='btn btn-lg btn-danger btn-block'>";
echo "</form>";

ECHO <<<_END
                
           </div>
            </div>
            </div>
        </div>
    </div>
_END;
echo "</div>";

echo "<br>";
require_once "footer.php";
?>