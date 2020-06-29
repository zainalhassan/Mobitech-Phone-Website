<?php

require_once "header.php";

if(isset($_SESSION['username']))
{
    echo <<<_END
        <h1 class = "header1"> Top Tablets for you - {$_SESSION['username']}</h1>
_END;
}
else
{
    echo <<<_END
        <h1 class = "header1"> View a list of tablets </h1>
_END;
}
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// if the connection fails, we need to know, so allow this exit:
if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}
$getTabletsQuery = "SELECT * FROM products WHERE categoryID = '2';";


$result = mysqli_query($connection, $getTabletsQuery);

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
<div class="card">
    <img src="{$imageRow['productImage']}" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title">{$row['productCompany']} {$row['productName']} </h5>
        <h5 class="card-title">£{$row['productPrice']}</h5>
        <form action = 'viewProduct.php?productID={$row['productID']}' method = 'POST'>
            <button class = "mybtn" name = 'productID' type = 'submit'> View </button>
        </form>
     
    </div>
</div>
_END;
    }
}
else
{
    echo " <br> no tablets found<br>";
}
echo "<br> </div>";
require_once "footer.php";
?>