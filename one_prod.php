<?php
require_once 'header.php';
require_once 'credentials.php';

if(isset($_POST['addBtn']) && !(isset($_SESSION['loggedIn']))){

    ?>
    <div class="alert alert-warning" role="alert">
        <strong>Please<a href="signIn.php"> Log in</a> to add to Cart</strong>
    </div>


    <?php
}
if(isset($_SESSION['cartUpdate'])) {
    if ($_SESSION['cartUpdate'] == true) {
        ?>
        <div class="alert alert-success" role="alert">
            <strong>Item added to Cart!</strong>
        </div>


        <?php
        $_SESSION['cartUpdate'] = false;
    }
}

if(isset($_GET['productID']))
{
    $productID = $_GET['productID'];
    $sql = "SELECT * FROM products where productID = '$productID'";
}
else
{
    $productName= $_GET['productName'];
    $sql = "SELECT *, CONCAT(productCompany, ' ', productName) AS prodName FROM products HAVING prodName = '{$_GET['productName']}';";
    $result = mysqli_query($connection, $sql);
    $n = mysqli_num_rows($result);
    if($n> 0) {
        $row = mysqli_fetch_assoc($result);
        $productID = $row['productID'];
    }
}

$result = mysqli_query($connection, $sql);
$n = mysqli_num_rows($result);
if($n> 0) {
    $row = mysqli_fetch_assoc($result);
    $categoryID = $row['categoryID'];
    $sql2 = "SELECT * FROM category WHERE categoryID = '$categoryID'";
    $result2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $categoryName = $row2['categoryName'];
    $categoryDescription = $row2['categoryDescription'];
    ?>
    <div class="wrapper">
    <div class="breadcrumb-wrapper">
    <hr>
        <div class="breadcrumb-area breadcrumbs">
            <div class="container" >
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-content text-center">
                            <nav class="" role="navigation" aria-label="breadcrumbs">
                                <ul class="breadcrumb-list">
                                    <li><a class="catTitle"  href="<?php echo $categoryName?>.php"><h3><?php echo $categoryName ?></h3></a>
                                    </li>
                                    <span><h1
                                           style="color: #7a7a7a" class="breadmome-name breadcrumbs-title"><?php echo $categoryDescription ?></h1></span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <main>
    <?php
    $active = 0;
    $notActive = 0;

    for ($i = 0; $i < $n; $i++) {
        $productName = $row['productName'];
        $productCompany = $row['productCompany'];
        $productSpecs = $row['productSpecs'];
        $productPrice = $row['productPrice'];

        $sql2 = "SELECT * FROM productimages WHERE productID = '$productID'";
        $result3 = mysqli_query($connection, $sql2);
        $result4 = mysqli_query($connection, $sql2);
        $nImg = mysqli_num_rows($result3);
        if ($nImg > 0) {
            $rowImg = mysqli_fetch_assoc($result3);
            $productImage = $rowImg['productImage'];
            $productImageID = $rowImg['productImageID'];
        }

        ?>
        <div id="shopify-section-product-template" class="shopify-section">
        <div class="single-product-area mt-80 mb-80">
        <div class="container">
        <div class="row">
        <div id="c" class="form-group col-md-5">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <?php
                $getImageQuery = "SELECT productImage FROM productImages WHERE productID = '{$row['productID']}'";
                $result = mysqli_query($connection, $getImageQuery);
                //$result2 = mysqli_query($connection, $getImageQuery);
                $n = mysqli_num_rows($result);
                if ($n > 0)
                {

                ?>

                <ol class="carousel-indicators">
                    <li style="background-color: #5a5b5c" data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <?php
                    for ($i = 1; $i < $n; $i++) {


                        ?>

                        <li style="background-color: #5a5b5c" data-target="#carouselExampleIndicators" data-slide-to="{$i}"></li>

                    <?php } ?>

                </ol>
                <div class="carousel-inner">
                    <?php
                    $isActive = 0;
                    for ($i = 0; $i < $n; $i++) {

                        $rowImgs = mysqli_fetch_assoc($result4);
                        $productImage = $rowImgs['productImage'];
                        $productImageID = $rowImgs['productImageID'];

                        if ($isActive == 0) {
                            $isActive++;
                            ?>
                            <div class="carousel-item active">
                                <img id="prodImg" src="<?php echo $productImage ?>" class="d-block w-100 h-100"
                                     alt="...">
                            </div>
                            <?php
                        } else {
                            ?>

                            <div class="carousel-item">
                                <img id="prodImg" src="<?php echo $productImage ?>" class="d-block w-100 h-100"
                                     alt="...">
                            </div>
                            <?php
                        }
                    }
                    }
                    ?>
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

        <div class="col-md-7">
        <div class="single-product-content">
        <form method="post" id="AddToCartForm" accept-charset="UTF-8" class="shopify-product-form"
              enctype="multipart/form-data">
        <input type="hidden" name="form_type" value="product"/><input type="hidden" name="utf8" value="✓"/>
        <div class="product-details">
        <h1 class="single-product-name"><span><?php echo $productCompany ?><?php echo $productName ?></span></h1>

        <div class="single-product-reviews">
            <span class="shopify-product-reviews-badge" data-id="1912078270534"></span>
        </div>
        <div class="product-sku">SKU: <span class="variant-sku">YQT71020193</span></div>
        <div class="single-product-price">
            <div class="product-discount"><span class="price" id="ProductPrice"><span
                        class=money style="color: #5a5b5c">£<?php echo $productPrice ?></span></span></div>
        </div>
        <div class="product-info"><?php echo $productSpecs ?></div>
        <hr>
        <?php


        echo "<div class='form-row'><div class='form-group col-md-2'>";


        if ($row['productQuantity'] > 10) {
            echo "<select name = 'qtySelect' class='btn btn-dark btn-block'>";
            for ($i = 1; $i <= 10; $i++) {
                echo "<option> $i </option>";
            }
            echo "</select></div>";
        } else {
            echo "<select name = 'qtySelect' class='btn btn-dark btn-block'>";
            for ($i = 1; $i <= $row['productQuantity']; $i++) {
                echo "<option value = '$i'> $i </option>";
            }
            echo "</select></div>";
        }
        echo "<div class='form-group col-md-10'><button type='submit' id='addBtnFavourites' name='addBtnFavourites' class='btn btn-dark btn-block hvr-overline-from-center'> Add to Favourites <i class='fas fa-star'></i> </button></div>";
        echo "<button type='submit' id='addBtn' name='addBtn' value='add to cart' class='btn btn-info btn-block hvr-overline-from-center'> Add to Cart <i class='fas fa-shopping-cart'></i> </button>";
        echo "<div class='secure-payment '><img style='width: 60%' src='resources/securepayments-860x395.jpg'></div>";
        echo "</form>";

        ECHO <<<_END
                                               
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

            </div>
        </main>
    </div>
_END;
    }
    echo "<br>";
    require_once "footer.php";
}

 if(isset($_POST['addBtn']) && isset($_SESSION['loggedIn']))
        {
            $row['productQuantity'] = $_POST['qtySelect'];
            $id = $row['productID'];
            array_push($_SESSION['cart'], $row);
            $_SESSION['cartUpdate'] =true;
            ?>
            <script type="text/javascript">
                window.location.href = 'one_prod.php?productID=<?php echo $id ?>';
            </script>
<?php
        }

?>
<?php
            if(isset($_POST['addBtnFavourites']) && isset($_SESSION['loggedIn']))
            {
                $id = $row['productID'];
                if(!empty($_SESSION['favourites']))
                {
                    foreach ($_SESSION['favourites'] as $favourite)
                    {
                        if ($id == $favourite['productID'])
                        {
                            echo "<div class='header1'> <h2> Item already in Favourites </h2> </div>";
                        }
                        else
                        {
                            $row['productQuantity'] = 1;
                            array_push($_SESSION['favourites'], $row);
                            ?>
                            <script type="text/javascript">
                                window.location.href = 'one_prod.php?productID=<?php echo $id ?>';
                            </script>
                            <?php
                        }
                    }
                }
                else
                {
                    $row['productQuantity'] = 1;
                    array_push($_SESSION['favourites'], $row);
                    ?>
                    <script type="text/javascript">
                        window.location.href = 'one_prod.php?productID=<?php echo $id ?>';
                    </script>
                    <?php
                }
            }

?>
