<?php

require_once "header.php";

if (isset($_SESSION['loggedIn']))
{
    $username = $_SESSION['username'];
    $sql = "SELECT customerID FROM users WHERE usersUsername = '$username';";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    if(!is_null($row) && $row != 0)
    {
        $customerID = $row['customerID'];
        $sql = "SELECT * FROM customers WHERE customerID = '$customerID';";
        echo $sql;
        $result = mysqli_query($connection, $sql);
        $n = mysqli_num_rows($result);
        if($n > 0)
        {
            echo <<<_END
            
_END;

            $row = mysqli_fetch_assoc($result);
            $index = 0;
            foreach ($row as $item)
            {
                echo "<br>";
//                echo $item;
                if($index < 7)
                {
                    echo "<input type='text' value = '$item'> ";
                }
                else if ($index == 7)
                {
                    echo "<input type='date' value = '$item'> ";
                }
                else if ($index == 8)
                {
                    echo "<input type='number' value = '$item'> ";
                }
                $index++;
            }

        }
        else
        {

        }
    }
    else
    {

    }
}
else
{
    echo "You do not have permission, log in";
}