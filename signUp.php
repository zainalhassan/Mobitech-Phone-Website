<?php

// Things to notice:
// The main job of this script is to execute an INSERT statement to add the submitted username, password and email address
// However, the assignment specification tells you that you need more fields than this for each user.
// So you will need to amend this script to include them. Don't forget to update your database (create_data.php) in tandem so they match
// This script does client-side validation using "password","text" inputs and "required","maxlength" attributes (but we can't rely on it happening!)
// we sanitise the user's credentials - see helper.php (included via header.php) for the sanitisation function
// we validate the user's credentials - see helper.php (included via header.php) for the validation functions
// the validation functions all follow the same rule: return an empty string if the data is valid...
// ... otherwise return a help message saying what is wrong with the data.
// if validation of any field fails then we display the help messages (see previous) when re-displaying the form

// execute the header script:
require_once "header.php";

$dateRestriction = date("Y-m-d");

// default values we show in the form:
$username = "";
$password = "";
$email = "";
$firstName = "";
$lastName = "";
$addressLine1 = "";
$addressLine2 = "";
$addressPostcode = "";
$dob = "";
$telephone = "";


// strings to hold any validation error messages:
$username_val = "";
$password_val = "";
$email_val = "";
$firstName_val = "";
$lastName_val = "";
$addressLine1_val = "";
$addressLine2_val = "";
$addressPostcode_val = "";
$dob_val = "";
$telephone_val = "";

// should we show the signup form?:
$show_signup_form = false;
// message to output to user:
$message = "";

if (isset($_SESSION['loggedIn']))
{
    // user is already logged in, just display a message:
    echo "You are already logged in, please log out if you wish to create a new account<br>";

}
elseif (isset($_POST['username']))
{
    // user just tried to sign up:

    // connect directly to our database (notice 4th argument) we need the connection for sanitisation:
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    // SANITISATION (see helper.php for the function definition)

    // take copies of the credentials the user submitted, and sanitise (clean) them:
    $username = sanitise($_POST['username'], $connection);
    $password = sanitise($_POST['password'], $connection);
    $email = sanitise($_POST['email'], $connection);
    $firstName = sanitise($_POST['firstName'], $connection);
    $lastName = sanitise($_POST['lastName'], $connection);
    $addressLine1 = sanitise($_POST['addressLine1'], $connection);
    $addressLine2 = sanitise($_POST['addressLine2'], $connection);
    $addressPostcode = sanitise($_POST['addressPostcode'], $connection);
    $dob = sanitise($_POST['dob'], $connection);
    $telephone = sanitise($_POST['telephone'],$connection);


    // VALIDATION (see helper.php for the function definitions)

    // now validate the data (both strings must be between 1 and 16 characters long):
    // (reasons: we don't want empty credentials, and we used VARCHAR(16) in the database table for username and password)
    // firstname is VARCHAR(32) and lastname is VARCHAR(64) in the DB
    // email is VARCHAR(64) and telephone is VARCHAR(16) in the DB
    $username_val = validateString($username, 1, 16);
    $password_val = validateString($password, 1, 16);
    //the following line will validate the email as a string, but maybe you can do a better job...
    $email_val = validateString($email, 1, 64);
    $firstName_val = validateString($firstName,1, 20);
    $lastName_val = validateString($lastName,1,30);
    $lastName_val = validateString($lastName,1,30);
    $addressLine1_val = validateString($addressLine1,1,150);
    $addressLine2_val = validateString($addressLine2,1,100);
    $addressPostcode_val = validateString($addressPostcode,1,11);
    $telephone_val = validateString($telephone,1,16);
    $dob_val = validateString($dob,10,10);

    // concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
    $errors = $username_val . $password_val . $email_val . $firstName_val . $lastName_val . $addressLine1_val . $addressLine2_val . $addressPostcode_val . $dob_val . $telephone_val;

    // check that all the validation tests passed before going to the database:
    if ($errors == "")
    {

        // try to insert the new details:
        $query = "INSERT INTO customers (customerFirstName, customerLastName, customerAddressLine1, customerAddressLine2, customerPostCode, customerEmail, customerDOB, customerPhone) VALUES ('$firstName', '$lastName', '$addressLine1', '$addressLine2', '$addressPostcode', '$email', '$dob', '$telephone');";

        $result = mysqli_query($connection, $query);

        // no data returned, we just test for true(success)/false(failure):
        if ($result)
        {
            $query = "SELECT customerID FROM customers WHERE customerEmail = '$email';";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);

            if(!is_null($row) && $row != 0)
            {
                $custID =  $row['customerID'];
                $query = "INSERT INTO users VALUES ('$custID','$username','$password');";
                $result1 = mysqli_query($connection, $query);
                if($result1)
                {
                    // show a successful signup message:
                    $message = "Signup was successful, please sign in<br>";
                }
            }
        }
        else
        {
            // show the form:
            $show_signup_form = true;
            // show an unsuccessful signup message:
            $message = "Sign up failed, please try again<br>";
        }

    }
    else
    {
        // validation failed, show the form again with guidance:
        $show_signup_form = true;
        // show an unsuccessful signin message:
        $message = "Sign up failed, please check the errors shown above and try again<br>";
    }

    // we're finished with the database, close the connection:
    mysqli_close($connection);

}
else
{
    // just a normal visit to the page, show the signup form:
    $show_signup_form = true;

}

if ($show_signup_form)
{
    // show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:

    echo <<<_END
        <div class = "signInBox">
            <h1> Sign up </h1>
            <form action="signUp.php" method="post">
                <div class = "textBox">
                    <i class="fas fa-user"></i>
                    <input type="text" title = "Username" name="username" minlength = "1" maxlength="16" value="$username" placeholder = "Username" required> $username_val 
                </div>
                <div class = "textBox">
                    <i class="fas fa-lock"></i>
                    <input type="password" title = "Password" name="password" minlength = "6" maxlength="16" value="$password" placeholder = "Password" required> $password_val
                </div>
                <div class = "textBox">
                    <i class="fas fa-at"></i>
                    <input type="email" title = "Email" name="email" minlength = "1" maxlength="64" value="$email" placeholder = "Email" required> $email_val
                </div>
                <div class = "textBox">
                    <i class="fas fa-chevron-right"></i>
                    <input type="text" title = "First Name" name="firstName" minlength = "1" maxlength="20" value="$firstName" placeholder = "First Name" required> $firstName_val
                </div>
                <div class = "textBox">
                    <i class="fas fa-chevron-right"></i>
                    <input type="text" title = "Last Name" name="lastName" minlength = "1" maxlength="30" value="$lastName" placeholder = "Last Name" required> $lastName_val
                </div>
                <div class = "textBox">
                    <i class="fas fa-address-card"></i>
                    <input type="text" title = "Address Line 1" name="addressLine1" minlength = "1" maxlength="150" value="$addressLine1" placeholder = "Address Line 1" required> $addressLine1_val
                </div>
                <div class = "textBox">
                    <i class="far fa-address-card"></i>
                    <input type="text" title = "Address Line 2" name="addressLine2" minlength = "1" maxlength="100" value="$addressLine2" placeholder = "Address Line 2" required> $addressLine2_val
                </div>
                <div class = "textBox">
                    <i class="fas fa-map-pin"></i>
                    <input type="text" title = "Post Code" name="addressPostcode" minlength = "1" maxlength="11" value="$addressPostcode" placeholder = "Address Postcode" required> $addressPostcode
                </div>
                <div class = "textBox">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" title = "Date of Birth" name="dob" maxlength = "10"  max = "$dateRestriction" value="$dob" placeholder = "Date of Birth" required> $dob_val
                </div>
                <div class = "textBox">
                    <i class="fas fa-mobile-alt"></i>
                    <input type="text" title = "Telephone" name="telephone" minlength = "1" maxlength="16" value="$telephone" placeholder = "Telephone" required> $telephone_val
                </div>
                <button class="mybtn button-fill-bottom"> Sign up </button>
            </form>
        </div>  
_END;
}

// display our message to the user:
echo $message;

echo "<br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";
require_once "footer.php";
?>
