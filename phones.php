<?php

require_once "header.php";

if(isset($_SESSION['loggedIn']))
{
    echo <<<_END
        <h2 class = "header1"> Top Phones for you - {$_SESSION['username']}</h2>
_END;
}
else
{
    echo <<<_END
        <h2 class="header1"> View a list of phones </h2>
_END;
}
$getPhonesQuery = "SELECT * FROM products WHERE categoryID = '1';";

$result = mysqli_query($connection, $getPhonesQuery);

$n = mysqli_num_rows($result);

echo "<div id='container'><div class='card-columns''>";
if ($n > 0)
{
    for($i=0; $i<$n; $i++)
    {
        // fetch one row as an associative array (elements named after columns):
        $row = mysqli_fetch_assoc($result);
        $getImagesQuery = "SELECT * FROM productimages WHERE productImage LIKE '%-1%' AND productID = '{$row['productID']}'";
        $imagesResult = mysqli_query($connection, $getImagesQuery);
        $imageRow = mysqli_fetch_assoc($imagesResult);
        echo <<<_END
            <div class="card cardHeight grow">
                <a href="one_prod.php?productID={$row['productID']}"> <img src="{$imageRow['productImage']}" class="card-img-top" alt="mainImage"> </a>
                    <div class="card-body">
                        <h5 class="card-title">{$row['productCompany']} {$row['productName']} </h5>
                        <hr>
                        <h5 class="card-title">£{$row['productPrice']}</h5>
                        <form action = 'one_prod.php?productID={$row['productID']}' method = 'POST'>
                            <button class = "btn btn1 btn-md btn-block btn-dark hvr-overline-from-center" name = 'productID'> View </button>
                        </form>
                    </div>
            </div>
_END;

    }
}
else
{
    echo " <br> no phones found<br>";
}

echo "<br> <br> </div>";
echo "<br><br><br>";
require_once "footer.php";
?>