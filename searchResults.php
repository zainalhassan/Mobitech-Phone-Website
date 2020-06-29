<?php

require_once "header.php";
$searchName = $_GET['productName'];

$sql = "SELECT * FROM products WHERE  CONCAT(productCompany, ' ', productName) LIKE '%$searchName%' OR productCompany LIKE '%$searchName%' OR productName LIKE '%$searchName%' ";

$result = mysqli_query($connection, $sql);
$n = mysqli_num_rows($result);

if ($n > 0)
{
    if($searchName == "")
    {
        echo <<<_END
        <h2 class = "header1"> Displaying all products </h2>
        <hr>
        <br>
_END;
    }
    else
    {
        echo <<<_END
        <h2 class = "header1"> Displaying <strong>{$n}</strong> search result(s) for: <strong> {$searchName}</strong>
_END;
        if($searchName == "iphone")
        {
            echo "<img class='displayBlock' id='apple' src='resources/logo/apple.png' alt='apple logo'>";
        }
        elseif ($searchName == "samsung")
        {
            echo "<img class='displayBlock' id='samsung' src='resources/logo/samsung.png' alt='samsung logo'>";
        }
        elseif ($searchName == "huawei")
        {
            echo "<img class='displayBlock' id='huawei' src='resources/logo/huawei.png' alt='huawei logo'>";
        }
        elseif ($searchName == "oneplus")
        {
            echo "<img class='displayBlock' id='oneplus' src='resources/logo/oneplus.png' alt='oneplus logo'>";
        }
        elseif ($searchName == "google")
        {
            echo "<img class='displayBlock' id='google' src='resources/logo/google.png' alt='google logo'>";
        }
        echo <<<_END
        </h2>
        <hr>
        <br>
_END;
    }
    echo "<div id='container'>";
    echo <<<_END
        <div id="filters">
                <form method="POST">
                <div id="sort">
                        <select  style="font-family: 'Titillium Web'" id = "sortSelect" name = 'sortSelect'  class='btn btn-dark btn-block '>
                            <option value=""> Sort By (Default)</option>
                            <option value="ORDER BY productPrice DESC;"> Price(High to low) </option>
                            <option value="ORDER BY productPrice ASC"> Price(Low to High) </option>
                            <option value="ORDER BY productID DESC"> Newest </option>
                            <option value="ORDER BY productID ASC"> Oldest </option>
                        </select>
                        <br>
                        <div style="text-align: center; font-family: 'Titillium Web'"><button class="btn btn-dark hvr-overline-from-center"> Search</button></div>
                    </form>
                </div>
    </div>
        <br>
_END;

    if(isset($_POST['sortSelect']))
    {
        $sql = $sql . $_POST['sortSelect'];
        $result = mysqli_query($connection,$sql);
    }

    echo "<div class='card-columns''>";
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
    echo <<<_END
        <h2 class = "header1">No search results found for: <strong> {$searchName}</strong></h2>
<hr>
<br>
<br>
_END;
}

echo "<br> <br> </div>";
require_once "footer.php";
?>