<?php

require_once "header.php";
$searchName = $_GET['productName'];


$getPhonesQuery = "SELECT * FROM products WHERE  CONCAT(productCompany, ' ', productName) LIKE '%$searchName%' OR productCompany LIKE '%$searchName%' OR productName LIKE '%$searchName%' ;";

$result = mysqli_query($connection, $getPhonesQuery);

$n = mysqli_num_rows($result);


if ($n > 0)
{

    echo <<<_END
        <h2 class = "header1"> Displaying <strong>{$n}</strong> search result(s) for: <strong> {$searchName}</strong></h2>
<hr>
<br>
<br>
_END;


    echo "<div id='container'>";
    echo "<div id ='filters'>";
    $sql = "SELECT MAX(productPrice) as maxPrice FROM products;";
    $resultMax = mysqli_query($connection, $sql);
    $m = mysqli_num_rows($resultMax);
    if($m > 0)
    {
        $rowMax = mysqli_fetch_assoc($resultMax);
        $max = $rowMax['maxPrice'];

        $sql = "SELECT MIN(productPrice) as minPrice FROM products;";
        $resultMin = mysqli_query($connection, $sql);
        $m = mysqli_num_rows($resultMin);
        if($m > 0)
        {
            $rowMin = mysqli_fetch_assoc($resultMin);
            $min = $rowMin['minPrice'];
        }
    }

    echo <<<_END
    <script>
        $( function() {
            $( "#slider-range" ).slider({
                range: true,
                min: $min,
                max: $max,
                values: [ $min, $max ],
                slide: function( event, ui ) {
                    $( "#amount" ).val( "£" + ui.values[ 0 ] + " - £" + ui.values[ 1 ] );
                    $("#jqSlider").prop('value', ui.values[0]);
                    $("#hiddenMax").prop('value', ui.values[1]);
                }
            });
            $( "#amount" ).val( "£" + $( "#slider-range" ).slider( "values", 0 ) +
                " - £" + $( "#slider-range" ).slider( "values", 1 ) );
        } );
    </script>
    <label for="amount">Price range:</label>
    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
<div id="slider-range"></div>
<form method="POST">
<button class = "btn btn-dark btn-block hvr-overline-from-center" name = "jqSlider"> Search </button>
<input type="hidden" name="hiddenMax">
</form>
_END;
    if(isset($_POST['jqSlider']))
    {
        echo $_POST['jqSlider'];
        echo $_POST['hiddenMax'];
    }
    echo "</div> <br><br><br>";
    echo "<div class='card-columns''>";
    for($i=0; $i<$n; $i++)
    {
        // fetch one row as an associative array (elements named after columns):
        $row = mysqli_fetch_assoc($result);
        $getImagesQuery = "SELECT * FROM productimages WHERE productImage LIKE '%-1%' AND productID = '{$row['productID']}'";
        $imagesResult = mysqli_query($connection, $getImagesQuery);
        $imageRow = mysqli_fetch_assoc($imagesResult);
        echo <<<_END
<div class="card grow">
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
        <h1 class = "header1">No search results found for: <strong> {$searchName}</strong></h1>
<hr>
<br>
<br>
_END;
}

echo "<br> <br> </div>";
require_once "footer.php";
?>