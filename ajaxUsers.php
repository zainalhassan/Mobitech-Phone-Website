<?php
    if(isset($_POST['key']))
    {
        require_once "credentials.php";

        if($_POST['key'] == 'getExistingData')
        {
            $start = $connection->real_escape_string($_POST['start']);
            $limit = $connection->real_escape_string($_POST['limit']);

            $sql = "SELECT * FROM customers INNER JOIN users USING(customerID) LIMIT $start, $limit;";
            $result = mysqli_query($connection, $sql);
            $n = mysqli_num_rows($result);
            if ($n > 0)
            {
                $response = "";
                for($i=0;$i < $n; $i++)
                {
                    $row = mysqli_fetch_assoc($result);
                    $response = $response . '
                            <tr>
                            //dont need an id as im not going to change product id on update ever.
                                <td>'. $row["customerID"] .'</td>
                                <td id="userFName'. $row["customerID"] .'">'. $row["customerFirstName"] .'</td>
                                <td id="userLName'. $row["customerID"] .'">'. $row["customerLastName"] .'</td>
                                <td id="userAL1'. $row["customerID"] .'">'. $row["customerAddressLine1"] .'</td>
                                <td id="userAL2'. $row["customerID"] .'">'. $row["customerAddressLine2"] .'</td>
                                <td id="userPostCode'. $row["customerID"] .'">'. $row["customerPostCode"] .'</td>
                                <td id="userEmail'. $row["customerID"] .'">'. $row["customerEmail"] .'</td>
                                <td id="userDob'. $row["customerID"] .'">'. $row["customerDOB"] .'</td>
                                <td id="userPhone'. $row["customerID"] .'">'. $row["customerPhone"] .'</td>
                                <td id="userUsername'. $row["customerID"] .'">'. $row["usersUsername"] .'</td>
                                <td id="userPassword'. $row["customerID"] .'">'. $row["usersPassword"] .'</td>
                                <td>
                                    <input type="button" class="btn btn-info" value="View" onclick="editOrView('. $row['customerID'] .', \'view\')">
                                    <hr>
                                    <input type="button" class="btn btn-success" value="Edit" onclick="editOrView('. $row['customerID'] .', \'edit\')">
                                    <hr>
                                    <input type="button" class="btn btn-danger" value="Delete" onclick="deleteUser('. $row['customerID'] .')">
                                </td>
                            </tr>
                        ';
                }
                exit($response);
            }
            else
            {
                exit('reachedMax');
            }
        }

        if($_POST['key'] == 'delete')
        {
            $deleteID = $connection->real_escape_string($_POST['deleteID']);
            $sql = "DELETE FROM users WHERE customerID = '$deleteID';";
            if (mysqli_query($connection, $sql))
            {
                $sql = "DELETE FROM customers WHERE customerID = '$deleteID';";
                if (mysqli_query($connection, $sql))
                {
                    exit("Customer Deleted");
                }
            }
            else
            {
                die("Error deleting Customer: " . mysqli_error($connection));
            }
        }

        if($_POST['key'] == 'getRowData')
        {
            $editUserID = $connection->real_escape_string($_POST['customerID']);
            $sql = "SELECT * FROM customers INNER JOIN users USING(customerID) WHERE customerID = '$editUserID';";
            $result = mysqli_query($connection, $sql);
            $n = mysqli_num_rows($result);
            if($n == 1)
            {
                $row = mysqli_fetch_assoc($result);
                $jsonProduct = array(
                    'userFName' => $row['customerFirstName'],
                    'userLName' => $row['customerLastName'],
                    'userAL1' => $row['customerAddressLine1'],
                    'userAL2' => $row['customerAddressLine2'],
                    'userPostCode' => $row['customerPostCode'],
                    'userEmail' => $row['customerEmail'],
                    'userDob' => $row['customerDOB'],
                    'userPhone' => $row['customerPhone'],
                    'userUsername' => $row['usersUsername'],
                    'userPassword' => $row['usersPassword']
                );
            }
            exit(json_encode($jsonProduct));

        }

        //customers table data
        $userFName = $connection->real_escape_string($_POST['userFName']);
        $userLName = $connection->real_escape_string($_POST['userLName']);
        $userAL1 = $connection->real_escape_string($_POST['userAL1']);
        $userAL2 = $connection->real_escape_string($_POST['userAL2']);
        $userPostCode = $connection->real_escape_string($_POST['userPostCode']);
        $userEmail = $connection->real_escape_string($_POST['userEmail']);
        $userDob = $connection->real_escape_string($_POST['userDob']);
        $userPhone = $connection->real_escape_string($_POST['userPhone']);
        //users table data
        $customerID = $connection->real_escape_string($_POST['editUserID']);
        $userUsername = $connection->real_escape_string($_POST['userUsername']);
        $userPassword = $connection->real_escape_string($_POST['userPassword']);

        if($_POST['key'] == 'update')
        {

            $sql = "UPDATE users SET usersUsername = '$userUsername', usersPassword = '$userPassword' WHERE customerID = '$customerID';";
            if (mysqli_query($connection, $sql))
            {
                $sql = "UPDATE customers SET customerFirstName = '$userFName', customerLastName = '$userLName', customerAddressLine1 = '$userAL1', customerAddressLine2 = '$userAL2', customerPostCode = '$userPostCode', customerEmail = '$userEmail', customerDOB = '$userDob', customerPhone = '$userPhone' WHERE customerID = '$customerID';";
                if (mysqli_query($connection, $sql))
                {
                    exit("Customer updated");
                }
            }
            else
            {
                die("Error updating Customer: " . mysqli_error($connection));
            }
        }

        if($_POST['key'] == 'addNew')
        {
            $sql = "SELECT usersUsername FROM users WHERE usersUsername = '$userUsername';";
            $result = mysqli_query($connection, $sql);
            $n = mysqli_num_rows($result);
            if ($n > 0)
            {
                exit("User already exists");
            }
            else
            {
                $sql = "INSERT INTO customers (customerFirstName, customerLastName, customerAddressLine1, customerAddressLine2, customerPostCode, customerEmail, customerDOB, customerPhone) VALUES ('$userFName', '$userLName', '$userAL1', '$userAL2', '$userPostCode', '$userEmail', '$userDob', '$userPhone');";
                if (mysqli_query($connection, $sql))
                {
                    $sql = "SELECT customerID FROM customers WHERE customerEmail = '$userEmail';";
                    $result = mysqli_query($connection, $sql);
                    $n = mysqli_num_rows($result);
                    if ($n > 0)
                    {
                        $row = mysqli_fetch_assoc($result);
                        $userID = $row['customerID'];
                        $sql = "INSERT INTO users VALUES ('$userID','$userUsername','$userPassword');";
                        if (mysqli_query($connection, $sql))
                        {
                            exit("Customer & User created");
                        }
                    }
                }
                else
                {
                    die("Error inserting row into customers: " . mysqli_error($connection));
                }
            }
        }
    }
?>