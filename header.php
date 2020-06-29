<?php

// Things to notice:
// This script is called by every other script (via require_once)
// It begins the HTML output, with the customary tags, that will produce each of the pages on the web site
// It starts the session and displays a different set of menu links depending on whether the user is logged in or not...
// ... And, if they are logged in, whether or not they are the admin
// It also reads in the credentials for our database connection from credentials.php

// database connection details:
require_once "credentials.php";

// our helper functions:
require_once "helper.php";

// start/restart the session:
session_start();

if (isset($_SESSION['loggedIn']))
{
    // THIS PERSON IS LOGGED IN
    // show the logged in menu options:

    echo <<<_END
 <!DOCTYPE html>
        <html>
            <head>
                <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                
               
                <script src="jquery.js"></script>
                <script src="myScript.js"></script>
                
                <link rel="stylesheet" type="text/css" href="styling.css">
                <title>MobiTech</title>
            </head>
            <body>
_END;
                if(isset($_POST['darkMode']))
                {
                    $_SESSION['darkMode'] = true;
                }
                else if(isset($_POST['lightMode']))
                {
                    $_SESSION['darkMode'] = false;
                }
                if($_SESSION['darkMode'] === true)
                {
                    echo <<<_END
                    <link rel='stylesheet' type='text/css' href='darkMode.css'>
                    <form method="POST" style="height: 5%">
                        <button class="btn btn-outline-light darkModeBtn" name="lightMode" title="Light Mode"> <i class="fas fa-sun"></i> </button>
                        <a href="welcome.php"> <img id = "logoImage" src="resources/cover.png" alt="Logo"></a>
                    </form>
_END;
                }
                else
                {
                    echo <<<_END
                    <form method="POST" style="height: 5%">
                        <button class="btn btn-outline-dark darkModeBtn" name="darkMode" title = "Dark Mode"> <i class="fas fa-moon"></i> </button>
                        <a href="welcome.php"> <img id = "logoImage" src="resources/cover.png" alt="Logo"> </a>
                    </form>
_END;
                }
                echo <<<_END
                <div id="navBar" class = "sticky-top">
                    <form action = 'viewProduct.php' method = 'GET'>
_END;
                            $sql = "SELECT CONCAT(productCompany, ' ', productName) AS prodName FROM products;";
                            $result = mysqli_query($connection, $sql);
                            $n = mysqli_num_rows($result);
                            if($n > 0) {
                                $arrayData = array();
                                for ($i = 0; $i < $n; $i++) {
                                    $row = mysqli_fetch_assoc($result);
                                    foreach ($row as $data) {
                                        array_push($arrayData, $data);
                                    }
                                }
                                $json = json_encode($arrayData);
                            }
    echo <<<_END

                        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                            <script>
                                    $( function() {
                                        let listContent = {$json};
                                         $( 'input[name="productName"]' ).autocomplete({
                                            source: listContent
                                        });
                                       
                                    } );
                                </script>
                                
                        </form>
                        
                     <ul id = "nav" >
                        <li class="hvr-overline-from-center" style="" id="homeNav"> <a  href="welcome.php"> <i style="color: #006699" class="fas fa-home"></i> Home</a></li>
                        <li class="hvr-overline-from-center"> <a  href="phones.php"> Mobile Phones </a> </li>
                        <li class="hvr-overline-from-center"> <a href="tablets.php"> Tablets </a> </li>
                        <li class="hvr-overline-from-center"> <a href="accessories.php"> Accessories </a> </li>                    
_END;
                        if ($_SESSION['username'] == "admin")
                        {
                            echo "<li class='hvr-overline-from-center'> <a href='admin.php'> <i class='fas fa-user-shield'></i> Admin Tools</a> </li>";
                        }
                        $cartCount = count($_SESSION['cart']);
                        $favouritesCount = count($_SESSION['favourites']);
echo <<<_END
                        <li class="liRight "> <a href="#" class="dropdown-toggle hvr-overline-from-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hover="dropdown"> <i class="fas fa-user"></i> ({$_SESSION['username']}) </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="account.php">Account</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logOut.php"> Log Out </a>
                              </div>
                        </li>
                        
                        <li class = "liRight hvr-overline-from-center"> <a id= "cartLi" data-toggle="collapse" href="#cart" role="button" aria-expanded="false" aria-controls="collapseExample"> <i class="fas fa-shopping-cart"></i> Cart ({$cartCount})</a></li>
                        <li class="liRight hvr-overline-from-center"> <a href="favourites.php"> <i class="fas fa-star"></i> Favourites ({$favouritesCount})</a> </li>          
                        <form method="get" action="searchResults.php">
                            <li class="liRight hvr-overline-from-center" id="searchLi"> <button id = "searchIcon"> <i class="fas fa-search"> </i> </button> <input id="search" name = "productName" type = text placeholder="Search"> </li>  
                        </form>
                  </ul>
                </div>
                    <div class="collapse" id="cart">
                      <div class="card card-body">
                        <h1 id="cartTitle"> <i class="fas fa-shopping-cart"></i> Cart </h1>
_END;
                        $arrayIndex = 0;
                        foreach ($_SESSION['cart'] as $cartProd)
                        {
                            echo "<div class='cartProd alert alert-dark' >";
                            echo <<<_END
                                 <form method='post'>
                                      <button type="submit" data-dismiss="alert" name = 'removeFromCartBtn' value=$arrayIndex class="removeFromCartBtn close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                      <input id = 'hiddenRemove' name = 'hidRemove' value=$arrayIndex hidden>
                                </form>
_END;
                            echo "<h4 class='alert-heading'></h4>";
                            echo "<hr>";
                            echo "<strong class='qty'></strong>";
                            echo "<p class = 'specs'></p>";
                            echo "<hr>";
                            echo "<div class='cartPrice'>
                            </div>";
                            echo "</div>";
                            $arrayIndex++;
                        }
                        echo "<hr> <div id='totalDiv'>
                                <h2 id = 'totalPrice'> </h2>
                            </div>";
                        if(!empty($_SESSION['cart']))
                        {
                            echo "<form action = 'checkout.php' method='post'>
                                <button id = 'checkoutBtn' class='btn btn-warning'> Proceed to checkout </button>
                                </form>";
                        }
                        echo <<<_END
                      </div>
                    </div>
            </body>
_END;


}
else {
    // THIS PERSON IS NOT LOGGED IN
    // show the logged out menu options:
    echo <<<_END
 <!DOCTYPE html>
        <html>
            <head>
             <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
               
                  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                
                <link rel="stylesheet" type="text/css" href="styling.css">
                <script src="jquery.js"></script>
                <script src="myScript.js"></script>
                <title>Phone Website</title>
            </head>
            <body>
                <div id="top">
                    <a href="welcome.php">
                        <img id = "logoImage2" src="resources/cover.png" alt="Logo">
                    </a>
                </div>
                <div id="navBar" class = "sticky-top">
                    <ul id = "nav" >
                        <li> <a href="phones.php"> Mobile Phones </a> </li>
                        <li> <a href="tablets.php"> Tablets </a> </li>
                        <li> <a href="accessories.php"> Accessories </a> </li>
                        <li class ="liRight"> <a href="signUp.php"> Sign up </a></li>
                        <li class ="liRight"> <a href="signIn.php"> Sign in </a></li>
                        <form method="get" action="searchResults.php">
                            <li class="liRight hvr-overline-from-center" id="searchLi"> <button id = "searchIcon"> <i class="fas fa-search"> </i> </button> <input id="search" name = "productName" type = text placeholder="Search"> </li>  
                        </form>
                </ul>
                </div>
                </div>
            </body>
_END;
}

?>