<?php

require_once "header.php";

echo <<<_END
    <div class="topContainer">
        <div class="category"> <a href="searchResults.php?productName=iphone"> <img class="displayBlock" id="apple" src="resources/logo/apple.png" alt="apple logo"> </a> </div>
        <div class="category"> <a href="searchResults.php?productName=samsung"> <img class="displayBlock" id="samsung" src="resources/logo/samsung.png" alt="samsung logo"> </a></div>
        <div class="category"> <a href="searchResults.php?productName=huawei"><img class="displayBlock" id="huawei" src="resources/logo/huawei.png" alt="huawei logo"> </a></div>
        <div class="category"> <a href="searchResults.php?productName=oneplus"><img class="displayBlock" id="oneplus" src="resources/logo/oneplus.png" alt="oneplus logo"> </a> </div>
        <div class="category"> <a href="searchResults.php?productName=google"><img class="displayBlock" id="google" src="resources/logo/google.png" alt="google logo"> </a> </div>
    </div>
    <br>
    <div class = "wideSlider">
        <img class="fill" src="resources/slider/s20Ultra.jpg" alt="image slider">
        <img class="fill" src="resources/slider/iphone11.jpg" alt="image slider">
        <img class="fill" src="resources/slider/note10.png" alt="image slider">
        <img class="fill" src="resources/slider/s10.jpg" alt="image slider">
        <img class="fill" src="resources/slider/pixel%203.png" alt="image slider">
    </div>
    <script src="js/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="js/slick.js" type="text/javascript"></script>
    <script src="js/mySlick.js"></script>

    <div id="bestSelling">
        <hr>
        <h2 class="text-center"> Best Selling</h2>
        <div class=" h2Support text-center"> Once they're gone, they're gone!</div>
        <br>
    </div>
_END;
        $sql = "SELECT productID, sum(productQuantity) as timesBought FROM orderline group by productID order by timesBought DESC LIMIT 3";
        $result = mysqli_query($connection, $sql);
        $n = mysqli_num_rows($result);
        if ($n > 0)
        {
            echo "<div id='container'><div class='card-columns''>";
            for($i=0; $i < $n; $i++)    //get productid and times bought
            {
                $row = mysqli_fetch_assoc($result);
                $productID = $row['productID'];
                $productInfo = "SELECT * FROM products WHERE productID = '$productID'";
                $productInfoResult = mysqli_query($connection, $productInfo);
                $m = mysqli_num_rows($productInfoResult);
                if ($m > 0)
                {
                    $productInfoRow = mysqli_fetch_assoc($productInfoResult);
                    $getImagesQuery = "SELECT * FROM productimages WHERE productImage LIKE '%-1%' AND productID = '{$row['productID']}'";
                    $imagesResult = mysqli_query($connection, $getImagesQuery);
                    $imageRow = mysqli_fetch_assoc($imagesResult);
                    echo <<<_END
                        <div class="card grow">
                            <a href="one_prod.php?productID={$productInfoRow['productID']}"> <img src="{$imageRow['productImage']}" class="card-img-top" alt="mainImage"> </a>
                            <div class="card-body">
                                <h5 class="card-title">{$productInfoRow['productCompany']} {$productInfoRow['productName']} </h5>
                                <hr>
                                <h5 class="card-title">£{$productInfoRow['productPrice']}</h5>
                                <form action = 'one_prod.php?productID={$row['productID']}' method = 'POST'>
                                    <button class = "btn btn1 btn-md btn-block btn-dark hvr-overline-from-center" name = 'productID'> View </button>
                                </form>
                            </div>
                            
                        </div>
_END;

                }
            }
        }

    echo "</div>"; //bestSelling

    echo <<<_END
        <div id="newlyAdded">
             <hr>
            <h2 class="text-center"> Newly Added</h2>
            <div class=" h2Support text-center"> The latest, the greatest!</div>
            <br>
        </div>
_END;

    $sql = "SELECT * FROM products order by productID DESC LIMIT 3";
    $result = mysqli_query($connection, $sql);
    $n = mysqli_num_rows($result);
    if ($n > 0)
    {
        echo "<div id='container'><div class='card-columns''>";
        for($i=0; $i < $n; $i++)    //get productid and times bought
        {
            $row = mysqli_fetch_assoc($result);
            $productID = $row['productID'];
            $productInfo = "SELECT * FROM products WHERE productID = '$productID'";
            $productInfoResult = mysqli_query($connection, $productInfo);
            $m = mysqli_num_rows($productInfoResult);
            if ($m > 0)
            {
                $productInfoRow = mysqli_fetch_assoc($productInfoResult);
                $getImagesQuery = "SELECT * FROM productimages WHERE productImage LIKE '%-1%' AND productID = '{$row['productID']}'";
                $imagesResult = mysqli_query($connection, $getImagesQuery);
                $imageRow = mysqli_fetch_assoc($imagesResult);
                echo <<<_END
                            <div class="card grow">
                                <a href="one_prod.php?productID={$productInfoRow['productID']}"> <img src="{$imageRow['productImage']}" class="card-img-top" alt="mainImage"> </a>
                                <div class="card-body">
                                    <h5 class="card-title">{$productInfoRow['productCompany']} {$productInfoRow['productName']} </h5>
                                    <hr>
                                    <h5 class="card-title">£{$productInfoRow['productPrice']}</h5>
                                    <form action = 'one_prod.php?productID={$row['productID']}' method = 'POST'>
                                        <button class = "btn btn1 btn-md btn-block btn-dark hvr-overline-from-center" name = 'productID'> View </button>
                                    </form>
                                </div>
                                
                            </div>
_END;

            }
        }
    }

    echo "</div>";

echo <<<_END
        <div id="random">
             <hr>
            <h2 class="text-center"> Today's Picks </h2>
            <div class=" h2Support text-center"> Today it's on our website, tomorrow, in your pocket!</div>
            <br>
        </div>
_END;

$sql = "SELECT * FROM products order by rand() LIMIT 3";
$result = mysqli_query($connection, $sql);
$n = mysqli_num_rows($result);
if ($n > 0)
{
    echo "<div id='container'><div class='card-columns''>";
    for($i=0; $i < $n; $i++)    //get productid and times bought
    {
        $row = mysqli_fetch_assoc($result);
        $productID = $row['productID'];
        $productInfo = "SELECT * FROM products WHERE productID = '$productID'";
        $productInfoResult = mysqli_query($connection, $productInfo);
        $m = mysqli_num_rows($productInfoResult);
        if ($m > 0)
        {
            $productInfoRow = mysqli_fetch_assoc($productInfoResult);
            $getImagesQuery = "SELECT * FROM productimages WHERE productImage LIKE '%-1%' AND productID = '{$row['productID']}'";
            $imagesResult = mysqli_query($connection, $getImagesQuery);
            $imageRow = mysqli_fetch_assoc($imagesResult);
            echo <<<_END
                            <div class="card cardHeight grow">
                                <a href="one_prod.php?productID={$productInfoRow['productID']}"> <img src="{$imageRow['productImage']}" class="card-img-top" alt="mainImage"> </a>
                                <div class="card-body">
                                    <h5 class="card-title">{$productInfoRow['productCompany']} {$productInfoRow['productName']} </h5>
                                    <hr>
                                    <h5 class="card-title">£{$productInfoRow['productPrice']}</h5>
                                    <form action = 'one_prod.php?productID={$row['productID']}' method = 'POST'>
                                        <button class = "btn btn1 btn-md btn-block btn-dark hvr-overline-from-center" name = 'productID'> View </button>
                                    </form>
                                </div>
                                
                            </div>
_END;

        }
    }
}

echo "</div>";



echo "<br>";
require_once "footer.php";
?>