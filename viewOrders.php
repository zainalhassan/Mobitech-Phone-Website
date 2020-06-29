<?php

require_once "header.php";

if (isset($_SESSION['loggedIn']))
{
    echo <<<_END
<h1 class = "header1">Previous orders -  {$_SESSION['username']} </h1>
    
_END;
    $username = $_SESSION['username'];
    $sql =  "SELECT customerID FROM users WHERE usersUsername = '$username'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    if(!is_null($row) && $row != 0)
    {
        $customerID = $row['customerID'];
        $sql = "SELECT * FROM orders WHERE customerID = '$customerID';";
        $result = mysqli_query($connection, $sql);

        $n = mysqli_num_rows($result);

        if($n > 0)
        {
            foreach ($result as $order)
            {
                foreach ($order as $orderInfo)
                {
                    echo $orderInfo;

                }
                echo <<<_END
                <form action="orderDetails.php?orderID={$order['orderID']}" method="post">
                    <button class='mybtn'> View Order Details </button>";
                </form>
_END;
                echo "<br>";
            }
        }
    }
}
else
{
echo "NOT LOGGED IN";
}
