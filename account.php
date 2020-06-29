<?php

require_once "header.php";
if(isset($_SESSION['userUpdate'])) {
    if ($_SESSION['userUpdate'] == true) {
        ?>
        <div class="alert alert-success" role="alert">
            <strong>Your details are updated successfully!</strong>
        </div>


        <?php
        $_SESSION['userUpdate'] = false;
    }
}
if (isset($_SESSION['loggedIn']))
{
    $username = $_SESSION['username'];
    $sql = "SELECT customerID FROM users WHERE usersUsername = '$username';";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!is_null($row) && $row != 0)
    {
        $customerID = $row['customerID'];
        $sql = "SELECT * FROM customers INNER JOIN users USING(customerID) WHERE customerID = '$customerID';";
        $result = mysqli_query($connection, $sql);
        $n = mysqli_num_rows($result);
        if ($n ==1)
        {
            $row = mysqli_fetch_assoc($result);
            $fName = $row['customerFirstName'];
            $lName = $row['customerLastName'];
            $aL1 = $row['customerAddressLine1'];
            $aL2 = $row['customerAddressLine2'];
            $pC = $row['customerPostCode'];
            $email = $row['customerEmail'];
            $dob = $row['customerDOB'];
            $phone = $row['customerPhone'];
            $username = $row['usersUsername'];
            $password = $row['usersPassword'];
            echo <<<_END
<div class="containerAccount" >
  <div class="row">
    <div class="col-6">
      <div class="card mt-3 tab-card">
        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="editTab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Edit Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="orderTab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">View Orders</a>
            </li>
          </ul>
        </div>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="editTab">
            <h5 class="card-title">Edit Profile</h5>
                <form action="account.php" method="POST">
                   <div id="editContent" class="card-content">
                            <input type="text" title="First Name" class = "form-control" placeholder="Fist Name" name="userFName" value="$fName">
                            <br>
                            <input type="text" title = "Last Name" class = "form-control" placeholder="Last Name" name="userLName" value="$lName">
                            <br>
                            <input type="text" title = "Address Line 1" class = "form-control" placeholder="Address Line 1" name="userAL1" value = "$aL1">
                            <br>
                            <input type="text" title = "Address Line 2" class = "form-control" placeholder="Address Line 2" name="userAL2" value="$aL2">
                            <br>
                            <input type="text" title = "Post Code" class = "form-control" placeholder="Post Code" name="userPostCode" value="$pC">
                            <br>
                            <input type="text" title = "Email" class = "form-control" placeholder="Email" name="userEmail" value="$email">
                            <br>
                            <input type="date" title = "Date of Birth" class = "form-control" placeholder = "Date of Birth" name="userDob" value="$dob">
                            <br>
                            <input type="text" title = "Telephone" class = "form-control" placeholder = "Telephone" name="userPhone" value="$phone">
                            <hr>
                            <input type="text" title = "Username" class = "form-control" placeholder="Username" name="userUsername" readonly value="$username">
                            <br>
                            <input type="text" title = "Password" class = "form-control" placeholder="Password" name="userPassword" value="$password">
                            <br>
                            <input type="hidden" id="editUserID" value="0">
                    </div>
                            <input type="submit" class = "btn btn1 btn-md btn-block btn-dark hvr-overline-from-center" value="Save Changes" name = 'editButton'> 
                    </form>
          </div>
          <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="orderTab">
            <h5 class="card-title">View Orders</h5>
            <div id="viewContent" class="card-body">
_END;
            if($_SESSION['username'] == 'admin')
            {
                $sql = "SELECT * FROM orders";
            }
            else
            {
                $sql = "SELECT * FROM orders WHERE customerID = '$customerID';";
            }
            $result = mysqli_query($connection, $sql);


            $n = mysqli_num_rows($result);
            if($n > 0)
            {
                for($i=0; $i < $n; $i++)
                {
                    $row = mysqli_fetch_assoc($result);
                    $date = $row['orderDate'];
                    $total = $row['orderTotal'];
                    echo<<<_END
                        <div class="alert alert-light">
                          <p> </p><b> Order Date: </b> $date</p>
                          <p> </p><b> Total: £</b>$total</p>
                          <form action="orderDetails.php?orderID={$row['orderID']}" method="POST">
                            <input type="submit" class = "btn btn1 btn-md btn-block btn-dark hvr-overline-from-center" value="View Order" id = 'orderButton'>
                          </form>
                        </div>
                        <hr>
_END;
                }
            }
            else
            {
                echo <<<_END
                    <div class="alert alert-light" id="noOrder">
                      <p> </p><b> No Previous Orders </b> </p>
                    </div>
                    <hr>
_END;
            }
            echo <<<_END
                </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>
_END;

        }
    }
}
else
{
    echo "You do not have permission, log in";
}


if(isset($_POST['editButton'])){

    $userUsername = $_POST['userUsername'];
    $userPassword = $_POST['userPassword'];
    $userFName = $_POST['userFName'];
    $userLName = $_POST['userLName'];
    $userAL1 = $_POST['userAL1'];
    $userAL2 = $_POST['userAL2'];
    $userPostCode = $_POST['userPostCode'];
    $userEmail = $_POST['userEmail'];
    $userDob = $_POST['userDob'];
    $userPhone = $_POST['userPhone'];

    $sql = "UPDATE users SET usersUsername = '$userUsername', usersPassword = '$userPassword' WHERE customerID = '$customerID';";
    echo $sql;
    if (mysqli_query($connection, $sql))
    {
        $sql = "UPDATE customers SET customerFirstName = '$userFName', customerLastName = '$userLName', customerAddressLine1 = '$userAL1', customerAddressLine2 = '$userAL2', customerPostCode = '$userPostCode', customerEmail = '$userEmail', customerDOB = '$userDob', customerPhone = '$userPhone' WHERE customerID = '$customerID';";
        if (mysqli_query($connection, $sql))
        {
            $_SESSION['userUpdate'] = true;
            ?>
            <script type="text/javascript">
                window.location.href = 'account.php';
            </script>
            <?php
            exit("Customer updated");

        }
    }
    else
    {
        die("Error updating Customer: " . mysqli_error($connection));
    }

}
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
require_once "footer.php";
?>