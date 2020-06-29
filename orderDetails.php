<?php

require_once "header.php";

if (isset($_SESSION['loggedIn']))
{
    $orderID = $_GET['orderID'];
    $sql = "SELECT customerID, orderDate, orderSubtotal, orderVAT, orderTotal FROM orders WHERE orderID = '{$orderID}';";
    $result = mysqli_query($connection, $sql);
    $n = mysqli_num_rows($result);
    if($n > 0)
    {
        $row = mysqli_fetch_assoc($result);
        $customerID = $row['customerID'];
        $orderDate = $row['orderDate'];
        $orderSubtotal = $row['orderSubtotal'];
        $orderVAT = $row['orderVAT'];
        $orderTotal = $row['orderTotal'];

        $nameSql = "SELECT usersUsername FROM users WHERE customerID =  '$customerID';";
        $nameResult = mysqli_query($connection, $nameSql);
        $nameN = mysqli_num_rows($nameResult);
        if($nameN > 0)
        {
            $nameRow = mysqli_fetch_assoc($nameResult);
            $name = $nameRow['usersUsername'];
        }
    }
    echo<<<_END

<div class = "container">
<h1 class = "header2"> Order Information -  {$orderID} - placed by {$name}</h1>
<h2 id="dateH1"> $orderDate</h2>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ProductID</th>
      <th scope="col">Product Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">LineCost</th>
    </tr>
  </thead>
  <tbody>
    

_END;



    $sql = "SELECT orderline.productID, CONCAT(productCompany, ' ', productName) AS prodName, orderline.productQuantity, orderline.productLineCost FROM orderline INNER JOIN products USING(productID) WHERE orderID = '{$orderID}';";
    $result = mysqli_query($connection, $sql);
    $n = mysqli_num_rows($result);
    if($n > 0)
    {
        for($i=0; $i<$n; $i++)
        {
            echo "<tr>";
            $row = mysqli_fetch_assoc($result);
            foreach ($row as $item)
            {
                echo "<td> $item </td>";
            }
            echo "</tr>";
        }
        echo "<tfoot>";
        echo "<tr> </tr><td> <b> SubTotal: </b> </td> <td></td> <td></td> <td> <b>£$orderSubtotal </b></td> </tr>";
        echo "<tr> </tr><td> <b> VAT: </b> </td> <td></td> <td></td> <td> <b>£$orderVAT </b></td> </tr>";
        echo "<tr> </tr><td> <b> Order Total: </b> </td> <td></td> <td></td> <td> <b>£$orderTotal </b></td> </tr>";
        echo "<tr> </tr><td> <b> Payment Method: </b> </td> <td></td> <td></td> <td> <b>Cash </b></td> </tr>";
        echo "</tfoot>";
    }
    echo <<<_END
          </tbody>
        </table>
</div>

_END;

}
else
{
    echo "NOT LOGGED IN";
}
echo "<br>";
require_once "footer.php";
?>