<?php

    if(isset($_POST['key']))
    {
        session_start();
        require_once "credentials.php";

        if($_POST['key'] == 'delete')
        {
            $deleteID = $connection->real_escape_string($_POST['deleteID']);
            $sql = "DELETE FROM products WHERE productID = '$deleteID';";
            if (mysqli_query($connection, $sql))
            {
                exit("Product Deleted");
            }
            else
            {
                die("Error deleting product: " . mysqli_error($connection));
            }
        }

        if($_POST['key'] == 'getRowData')
        {
            $editProdID = $connection->real_escape_string($_POST['productID']);
            $sql = "SELECT * FROM products WHERE productID = '$editProdID';";
            $result = mysqli_query($connection, $sql);
            $n = mysqli_num_rows($result);
            if($n == 1)
            {
                $row = mysqli_fetch_assoc($result);
                $jsonProduct = array(
                    'categoryID' => $row['categoryID'],
                    'productCompany' => $row['productCompany'],
                    'productName' => $row['productName'],
                    'productSpecs' => $row['productSpecs'],
                    'productPrice' => $row['productPrice'],
                    'productQuantity' => $row['productQuantity'],
                    'productSalePrice' => $row['productSalePrice']
                );
            }
            exit(json_encode($jsonProduct));

        }

        if($_POST['key'] == 'getExistingData')
        {
            $start = $connection->real_escape_string($_POST['start']);
            $limit = $connection->real_escape_string($_POST['limit']);

            $sql = "SELECT * FROM products LIMIT $start, $limit;";
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
                                <td>'. $row["productID"] .'</td>
                                <td id="catID'. $row["productID"] .'">'. $row["categoryID"] .'</td>
                                <td id="prodComp'. $row["productID"] .'">'. $row["productCompany"] .'</td>
                                <td id="prodName'. $row["productID"] .'">'. $row["productName"] .'</td>
                                <td id="prodSpecs'. $row["productID"] .'">'. $row["productSpecs"] .'</td>
                                <td id="prodPrice'. $row["productID"] .'">'. $row["productPrice"] .'</td>
                                <td id="prodQuantity'. $row["productID"] .'">'. $row["productQuantity"] .'</td>
                                <td id="prodSalePrice'. $row["productID"] .'">'. $row["productSalePrice"] .'</td>
                                <td>
                                    <input type="button" class="btn btn-info" value="View" onclick="editOrView('. $row['productID'] .', \'view\')">
                                    <hr>
                                    <input type="button" class="btn btn-success" value="Edit" onclick="editOrView('. $row['productID'] .', \'edit\')">
                                    <hr>
                                    <input type="button" class="btn btn-danger" value="Delete" onclick="deleteProduct('. $row['productID'] .')">
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

        $prodCat = $connection->real_escape_string($_POST['prodCat']);
        $prodComp = $connection->real_escape_string($_POST['prodComp']);
        $prodName = $connection->real_escape_string($_POST['prodName']);
        $prodSpecs = $connection->real_escape_string($_POST['prodSpecs']);
        $prodPrice = $connection->real_escape_string($_POST['prodPrice']);
        $prodQuantity = $connection->real_escape_string($_POST['prodQuantity']);
        $prodSalePrice = $connection->real_escape_string($_POST['prodSalePrice']);
        $productID = $connection->real_escape_string($_POST['editProdID']);

        if($_POST['key'] == 'update')
        {

            $sql = "UPDATE products SET categoryID = '$prodCat', productCompany = '$prodComp', productName = '$prodName', productSpecs = '$prodSpecs', productPrice = '$prodPrice', productQuantity = '$prodQuantity', productSalePrice = '$prodSalePrice' WHERE productID = '$productID';";
            if (mysqli_query($connection, $sql))
            {
                exit("Product updated");
            }
            else
            {
                die("Error updating product: " . mysqli_error($connection));
            }
        }

        if($_POST['key'] == 'addNew')
        {
            $sql = "SELECT productCompany, productName FROM products WHERE productCompany = '$prodComp' AND productName = '$prodName';";
            $result = mysqli_query($connection, $sql);
            $n = mysqli_num_rows($result);
            if ($n > 0)
            {
                exit("Product already exists");
            }
            else
            {
                $sql = "INSERT INTO products (categoryID, productCompany, productName, productSpecs, productPrice, productQuantity, productSalePrice) VALUES ('$prodCat', '$prodComp', '$prodName','$prodSpecs','$prodPrice','$prodQuantity','$prodSalePrice');";
                if (mysqli_query($connection, $sql))
                {
                    exit("Product inserted");
                }
                else
                {
                    die("Error inserting row: " . mysqli_error($connection));
                }
            }
        }
    }
?>