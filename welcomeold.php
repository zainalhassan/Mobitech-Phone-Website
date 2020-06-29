<?php

require_once "header.php";

    if(isset($_SESSION['username']))
    {
        echo <<<_END
        <h1 class="header1"> Welcome - {$_SESSION['username']}</h1>
_END;
    }
    else
    {
        echo <<<_END
       <h1 class="header1"> Welcome</h1>
_END;
    }

    echo <<<_END
    <div class = "thing" id="wrapper1">
        <img class="fill" src="images/s10promo.jpg" alt="image slider">
        <img class="fill" src="images/xswallpaper-header.jpg" alt="image slider">
        <img class="fill" src="images/iphone-xs-max-camera.png" alt="image slider">
    </div>
    <div id="bestSelling">
 <div class = 'three' id='wrapper2'>
_END;
        $sql = "SELECT productID, sum(productQuantity) as timesBought FROM orderline group by productID order by timesBought DESC";
        $result = mysqli_query($connection, $sql);
        $n = mysqli_num_rows($result);
        if ($n > 0)
        {
            ?>

                <?php
            for($i=0; $i < $n; $i++)
            {
                echo $i;
            }
//            for($i=0;$i <$n; $i++)
//            {
//                echo "hello";
//                $row = mysqli_fetch_assoc($result);
//                $productID = $row['productID'];
//                $sql = "SELECT * FROM products WHERE productID = '$productID'";
//                $result = mysqli_query($connection, $sql);
//                $m = mysqli_num_rows($result);
//                if ($m > 0)
//                {
//                    for($j=0;$j <$m; $j++)
//                    {
//                        $row = mysqli_fetch_assoc($result);
//                        $sql = "SELECT * FROM products INNER JOIN productimages USING (productID) GROUP by productID";
//                    }
//                }
//            }
        }
            echo <<<_END

                <img class="fill" src="images/s10promo.jpg" alt="image slider">
                <img class="fill" src="images/xswallpaper-header.jpg" alt="image slider">
                <img class="fill" src="images/xswallpaper-header.jpg" alt="image slider">
                <img class="fill" src="images/iphone-xs-max-camera.png" alt="image slider">
                <img class="fill" src="images/iphone-xs-max-camera.png" alt="image slider">
                <img class="fill" src="images/iphone-xs-max-camera.png" alt="image slider">
            
    </div>
    <script src="js/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="js/slick.js" type="text/javascript"></script>
    <script src="js/mySlick.js"></script>
_END;

echo "<br>";
require_once "footer.php";
?>