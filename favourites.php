<?php
    require_once "header.php";


if (!empty($_SESSION['favourites']))
{
    echo <<<_END
        <h2 class="text-center"> Favourites</h2>
        <div class=" h2Support text-center">
        Don't just leave them here, add them to the cart!
        <br>
        <br>
        </div>
_END;

    echo "<div id='container'><div class='card-columns''>";
    for($i=0; $i<count($_SESSION['favourites']); $i++)
    {
        // fetch one row as an associative array (elements named after columns):
        $row = mysqli_fetch_assoc($result);
        $getImagesQuery = "SELECT * FROM productimages WHERE productImage LIKE '%-1%' AND productID = '{$_SESSION['favourites'][$i]['productID']}'";
        $imagesResult = mysqli_query($connection, $getImagesQuery);
        $imageRow = mysqli_fetch_assoc($imagesResult);
        echo <<<_END
            <div class="card grow">
                <a href="one_prod.php?productID={$_SESSION['favourites'][$i]['productID']}"> <img src="{$imageRow['productImage']}" class="card-img-top" alt="mainImage"> </a>
                    <div class="card-body">
                        <h5 class="card-title">{$_SESSION['favourites'][$i]['productCompany']} {$_SESSION['favourites'][$i]['productName']} </h5>
                        <hr>
                        <h5 class="card-title">£{$_SESSION['favourites'][$i]['productPrice']}</h5>
                        <form action = 'one_prod.php?productID={$_SESSION['favourites'][$i]['productID']}' method = 'POST'>
                            <button class = "btn btn1 btn-md btn-block btn-dark hvr-overline-from-center" name = 'productID'> View </button>
                        </form>
                    </div>
            </div>
_END;

    }
}
require_once "footer.php";
?>