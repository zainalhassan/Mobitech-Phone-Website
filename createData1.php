<?php

//retrieve details of MySQL server
require_once "credentials.php";

//connect to host
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}

// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

//condition to account for success/failure of database creation
if (mysqli_query($connection, $sql))
{
    echo "Database created successfully, or already exists<br>";
}
else
{
    die("Error creating database: " . mysqli_error($connection));
}

// connect to the database:
mysqli_select_db($connection, $dbname);


//remove old versions of tables when ran

$sql = "DROP TABLE IF EXISTS orderLine";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: orderLine<br>";
}
else
{
    die("Error checking for existing orderLine table: " . mysqli_error($connection));
}
$sql = "DROP TABLE IF EXISTS orders";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: orders<br>";
}
else
{
    die("Error checking for existing orders table: " . mysqli_error($connection));
}
$sql = "DROP TABLE IF EXISTS bannerImages";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: bannerImages<br>";
}
else
{
    die("Error checking for existing bannerImages table: " . mysqli_error($connection));
}
$sql = "DROP TABLE IF EXISTS banner";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: banner<br>";
}
else
{
    die("Error checking for existing banner table: " . mysqli_error($connection));
}
$sql = "DROP TABLE IF EXISTS productImages";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: productImages<br>";
}
else
{
    die("Error checking for existing productImages table: " . mysqli_error($connection));
}
$sql = "DROP TABLE IF EXISTS reviews";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: reviews<br>";
}
else
{
    die("Error checking for existing reviews table: " . mysqli_error($connection));
}
$sql = "DROP TABLE IF EXISTS products";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: products<br>";
}
else
{
    die("Error checking for existing products table: " . mysqli_error($connection));
}
$sql = "DROP TABLE IF EXISTS category";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: category<br>";
}
else
{
    die("Error checking for existing category table: " . mysqli_error($connection));
}

$sql = "DROP TABLE IF EXISTS users";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: users<br>";
}
else
{
    die("Error checking for existing users table: " . mysqli_error($connection));
}

$sql = "DROP TABLE IF EXISTS customers";

if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: customers<br>";
}
else
{
    die("Error checking for existing customers table: " . mysqli_error($connection));
}


//////////////////////CREATE TABLE/////////////
$sql = "CREATE TABLE customers (customerID INT(4) AUTO_INCREMENT, customerFirstName VARCHAR(60), customerLastName VARCHAR(60), customerAddressLine1 VARCHAR(150), customerAddressLine2 VARCHAR(100), customerPostCode VARCHAR(11), customerEmail VARCHAR(100) UNIQUE, customerDOB DATE, customerPhone VARCHAR(15), PRIMARY KEY (customerID));";

if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: customers<br>";
}
else
{
    die("Error creating customers table: " . mysqli_error($connection));
}
$sql = "CREATE TABLE users (customerID INT(4), usersUsername VARCHAR(16), usersPassword VARCHAR (16), PRIMARY KEY (usersUsername), FOREIGN KEY (customerID) REFERENCES customers(customerID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: users<br>";
}
else
{
    die("Error creating users table: " . mysqli_error($connection));
}


/////////////////////CREATE TABLE/////////////

$sql = "CREATE TABLE category (categoryID INT(4) AUTO_INCREMENT, categoryName VARCHAR(20), categoryDescription VARCHAR(200), categoryProductCount INT(4), PRIMARY KEY(categoryID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: category<br>";
}
else
{
    die("Error creating category table: " . mysqli_error($connection));
}

$sql = "CREATE TABLE products (productID INT(4) AUTO_INCREMENT, categoryID INT (4) ,productCompany VARCHAR(50), productName VARCHAR(100), productSpecs VARCHAR(200), productPrice DECIMAL(6,2), productQuantity INT(4), productSalePrice DECIMAL(6,2), PRIMARY KEY(productID),FOREIGN KEY (categoryID) REFERENCES category(categoryID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: products<br>";
}
else
{
    die("Error creating products table: " . mysqli_error($connection));
}

$sql = "CREATE TABLE reviews (reviewID INT(4) AUTO_INCREMENT, productID INT(4), reviewName VARCHAR(100), reviewDate DATE, reviewStars DECIMAL(2,1), reviewDescription VARCHAR(400), PRIMARY KEY (reviewID), FOREIGN KEY (productID) REFERENCES products(productID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: reviews<br>";
}
else
{
    die("Error creating reviews table: " . mysqli_error($connection));
}

$sql = "CREATE TABLE productImages (productID INT(4), productImageID INT(4) AUTO_INCREMENT, productImage VARCHAR(100), PRIMARY KEY (productImageID), FOREIGN KEY (productID) REFERENCES products(productID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: productImages<br>";
}
else
{
    die("Error creating productImages table: " . mysqli_error($connection));
}

$sql = "CREATE TABLE banner (bannerID INT(4) AUTO_INCREMENT, bannerLocation VARCHAR(50), PRIMARY KEY (bannerID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: banner<br>";
}
else
{
    die("Error creating banner table: " . mysqli_error($connection));
}

$sql = "CREATE TABLE bannerImages (bannerID INT(4), productID INT(4), bannerImageID INT(4) AUTO_INCREMENT, bannerImage VARCHAR(100), PRIMARY KEY (bannerImageID), FOREIGN KEY (bannerID) REFERENCES banner(bannerID), FOREIGN KEY (productID) REFERENCES products(productID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: bannerImages<br>";
}
else
{
    die("Error creating bannerImages table: " . mysqli_error($connection));
}

$sql = "CREATE TABLE orders (orderID INT(4) AUTO_INCREMENT, customerID INT(4),orderDate TIMESTAMP ,orderSubtotal DECIMAL(6,2), orderVAT DECIMAL(6,2), orderTotal DECIMAL(6,2), PRIMARY KEY (orderID), FOREIGN KEY (customerID) REFERENCES customers(customerID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: orders<br>";
}
else
{
    die("Error creating orders table: " . mysqli_error($connection));
}


$sql = "CREATE TABLE orderLine (orderID INT(4), productID INT(4), productQuantity INT(2), productLineCost DECIMAL(6,2), FOREIGN KEY (orderID) REFERENCES orders(orderID), FOREIGN KEY (productID) REFERENCES products(productID));";
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: orderLine<br>";
}
else
{
    die("Error creating orderLine table: " . mysqli_error($connection));
}



/////////////////////////////////////////////////////////////////INSERTION////////////////////////////////////////////////////////////////////////////

$customerFirstNames[] = 'Admin'; $customerLastNames[] = 'istrator'; $customerAddressLine1[] = '4 Kirkby Close'; $customerAddressLine2[] = 'Bury'; $customerPostcodes[] = 'KJ5 4WS'; $customerEmails[] = 'admin@mail.com'; $customerDOBs[] = '1984-02-09'; $customerPhones[] = '07700909264';
$customerFirstNames[] = 'Tom'; $customerLastNames[] = 'Collard'; $customerAddressLine1[] = '4 Ribble Path'; $customerAddressLine2[] = 'Lancashire'; $customerPostcodes[] = 'KY1 2SH'; $customerEmails[] = 'tom.c@mail.com'; $customerDOBs[] = '1984-11-09'; $customerPhones[] = '07700900537';
$customerFirstNames[] = 'Malcolm'; $customerLastNames[] = 'Nye'; $customerAddressLine1[] = '45 Fleetwood Ridge'; $customerAddressLine2[] = 'Burnley'; $customerPostcodes[] = 'SG15 6SH'; $customerEmails[] = 'malcolm.n@mail.com'; $customerDOBs[] = '1998-11-19'; $customerPhones[] = '07700900539';
$customerFirstNames[] = 'Essa'; $customerLastNames[] = 'Carroll'; $customerAddressLine1[] = '42 Charnwood Rowans'; $customerAddressLine2[] = 'Bradford'; $customerPostcodes[] = 'DA8 3ET'; $customerEmails[] = 'essa.c@mail.com'; $customerDOBs[] = '2000-03-20'; $customerPhones[] = '07700900511';
$customerFirstNames[] = 'Iwan'; $customerLastNames[] = 'Major'; $customerAddressLine1[] = '141 Elsfred Road'; $customerAddressLine2[] = 'Birmingham'; $customerPostcodes[] = 'G81 4QJ'; $customerEmails[] = 'iwan.m@mail.com'; $customerDOBs[] = '2001-03-20'; $customerPhones[] = '07700900540';
$customerFirstNames[] = 'Chardonnay'; $customerLastNames[] = 'Rice'; $customerAddressLine1[] = '242 Central Village'; $customerAddressLine2[] = 'Wolverhampton'; $customerPostcodes[] = 'BN3 3PP'; $customerEmails[] = 'chardonnay.r@mail.com'; $customerDOBs[] = '2004-03-20'; $customerPhones[] = '07700900437';
$customerFirstNames[] = 'Ben'; $customerLastNames[] = 'Ford'; $customerAddressLine1[] = '8 Broadfield Top'; $customerAddressLine2[] = 'Liverpool'; $customerPostcodes[] = 'WS8 7JU'; $customerEmails[] = 'ben.f@mail.com'; $customerDOBs[] = '1980-04-12'; $customerPhones[] = '07700900008';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($customerFirstNames); $i++)
{
    $sql = "INSERT INTO customers (customerFirstName, customerLastName, customerAddressLine1, customerAddressLine2, customerPostcode, customerEmail, customerDOB, customerPhone) VALUES ('$customerFirstNames[$i]', '$customerLastNames[$i]', '$customerAddressLine1[$i]', '$customerAddressLine2[$i]', '$customerPostcodes[$i]', '$customerEmails[$i]','$customerDOBs[$i]', '$customerPhones[$i]')";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}

/////////////////////////////////////////////////////////////////INSERTION////////////////////////////////////////////////////////////////////////////
$customerIDs[] = '1'; $usersUsernames[] = 'admin'; $usersPasswords[] = 'secret';
$customerIDs[] = '2'; $usersUsernames[] = 'TomC123'; $usersPasswords[] = 'Collard1';
$customerIDs[] = '3'; $usersUsernames[] = 'ManMalc'; $usersPasswords[] = 'manlikemalcolm';
$customerIDs[] = '4'; $usersUsernames[] = 'eazzy'; $usersPasswords[] = 'tester';


for ($i=0; $i<count($customerIDs); $i++)
{
    $sql = "INSERT INTO users VALUES ('$customerIDs[$i]','$usersUsernames[$i]', '$usersPasswords[$i]');";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}


/////////////////////////////////////////////////////////////////INSERTION////////////////////////////////////////////////////////////////////////////

$categoryNames[] = 'Phones'; $categoryDescriptions[] = 'We sell the latest and highest specced phones, so you dont have to search for the best deals, when we have them all, right here!'; $categoryProductCount[] = '4';
$categoryNames[] = 'Tablets'; $categoryDescriptions[] = 'We sell the latest and highest specced tablets, so you dont have to search for the best deals, when we have them all, right here!'; $categoryProductCount[] = '5';
$categoryNames[] = 'Accessories'; $categoryDescriptions[] = 'Accessories of a wide range suitable for the many, not the few'; $categoryProductCount[] = '5';

for ($i=0; $i<count($categoryNames); $i++)
{
    $sql = "INSERT INTO category (categoryName, categoryDescription, categoryProductCount)VALUES ('$categoryNames[$i]','$categoryDescriptions[$i]', '$categoryProductCount[$i]');";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}

/////////////////////////////////////////////////////////////////INSERTION////////////////////////////////////////////////////////////////////////////
$categoryIDs[] = '1'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy S10'; $productSpecs[] = 'Weight: 157g,Dimensions: 149.9 x 70.4 x 7.8mm,OS: Android 9,Screen size: 6.1-inch,Resolution: QHD+,CPU: Octa-core chipset,RAM: 8GB,Storage: 128/512GB.'; $productPrices[] = '799.00'; $productQuantities[] = '78'; $productSalePrices[] = '699.99';
$categoryIDs[] = '1'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy S10 Plus'; $productSpecs[] = 'Weight: 175g,Dimensions: 157.6 x 74.1 x 7.8mm,OS: Android 9,Screen size: 6.4-inch,Resolution: QHD+,CPU: Octa-core chipset,RAM: 8GB/12GB,Storage: 128/512GB/1TB.'; $productPrices[] = '899.00'; $productQuantities[] = '134'; $productSalePrices[] = '799.99';
$categoryIDs[] = '1'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy S10 5G'; $productSpecs[] = 'Weight: 198g,Dimensions: 162.6 x 77.1 x 7.94mm,OS: Android 9,Screen size: 6.7-inch,Resolution: QHD+,CPU: Octa-core chipset,RAM: 8GB,Storage: 256GB/512GB.'; $productPrices[] = '1100.00'; $productQuantities[] = '24'; $productSalePrices[] = '1050.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy S20'; $productSpecs[] = 'Weight: 163g,Dimensions: 69.1 x 151.7 x 7.9 mm: Android 9,Screen size: 6.2-inch AMOLED ,Resolution: QHD+ Dynamic AMOLED:,RAM: 12/16 GB,Storage: up to 512 GB of expandable storage.'; $productPrices[] = '799.00'; $productQuantities[] = '10'; $productSalePrices[] = '599.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy Note 10'; $productSpecs[] = 'Weight: 198g,Dimensions: 151 x 71.8 x 7.9 mm,OS: Android 9,Screen size: 6.3-inch,Resolution: AMOLED display with a Full HD resolution:,RAM: 8GB,Storage: 256GB.'; $productPrices[] = '639.00'; $productQuantities[] = '5'; $productSalePrices[] = '539.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy A50'; $productSpecs[] = 'Weight: 166g,Dimensions: 158.5 mm x 74.5 mm x 7.7 mm: Android 9,Screen size: 6.4-inch AMOLED ,Resolution:AMOLED:,RAM:6 GB,Storage:128 GB.'; $productPrices[] = '309.95'; $productQuantities[] = '5'; $productSalePrices[] = '209.95';

$categoryIDs[] = '1'; $productCompanies[] = 'iPhone'; $productNames[] = 'XR'; $productSpecs[] = 'Weight: 194g,Dimensions: 150.9 x 75.7 x 8.3mm,OS: iOS 12,Screen size: 6.1-inch,Resolution: 1792 x 828,CPU: A12 Bionic,RAM: 8GB,Storage: 64/128/256'; $productPrices[] = '749.00'; $productQuantities[] = '345'; $productSalePrices[] = '700.00';
$categoryIDs[] = '1'; $productCompanies[] = 'iPhone'; $productNames[] = 'XS'; $productSpecs[] = 'Weight: 177g,Dimensions: 150.9 x 75.7 x 8.3mm,OS: iOS 12,Screen size: 6.1-inch,Resolution: 1792 x 828,CPU: A12 Bionic,RAM: 8GB,Storage: 64/128/256'; $productPrices[] = '999.00'; $productQuantities[] = '3'; $productSalePrices[] = '850.00';
$categoryIDs[] = '1'; $productCompanies[] = 'iPhone'; $productNames[] = 'XS MAX'; $productSpecs[] = 'Weight: 208g,Dimensions: 157.5 x 77.4 x 7.7mm,OS: iOS 12,Screen size: 6.5-inch,Resolution: 1242 x 2688,CPU: Apple A12 Bionic,RAM: 4GB,RAM: 8GB,Storage: 64/256/512GB.'; $productPrices[] = '1099.00'; $productQuantities[] = '56'; $productSalePrices[] = '1000.00';
$categoryIDs[] = '1'; $productCompanies[] = 'iPhone'; $productNames[] = '11'; $productSpecs[] = 'Weight: 194g,Dimensions: 150.9 x 75.7 x 8.3mm,OS: iOS 13,Screen size: 6.1-inch,Resolution: 828 x 1792,CPU: A13 Bionic,RAM: 8GB,Storage: 64/128/256GB'; $productPrices[] = '729.00'; $productQuantities[] = '35'; $productSalePrices[] = '600.00';
$categoryIDs[] = '1'; $productCompanies[] = 'iPhone'; $productNames[] = '11 Pro'; $productSpecs[] = 'Weight: 188g ,Dimensions: 144 x 71.4 x 8.1mm,OS: iOS 13,Screen size: 5.8-inch,Resolution: 1125 x 2436,CPU: A13 Bionic,RAM: 8GB,Storage: 64/256/512GB'; $productPrices[] = '1149.00'; $productQuantities[] = '3'; $productSalePrices[] = '1000.00';
$categoryIDs[] = '1'; $productCompanies[] = 'iPhone'; $productNames[] = '11 Pro MAX'; $productSpecs[] = 'Weight: 226g,Dimensions: 158 x 77.8 x 8.1mm,OS: iOS 13,Screen size: 6.5-inch,Resolution: 1242 x 2688,CPU: Apple A13 Bionic,RAM: 4GB,RAM: 8GB,Storage: 64/256/512GB.'; $productPrices[] = '1149.00'; $productQuantities[] = '5'; $productSalePrices[] = '1100.00';

$categoryIDs[] = '1'; $productCompanies[] = 'Huawei'; $productNames[] = 'P30'; $productSpecs[] = 'Weight: 192g,Dimensions: 1158 x 73.4 x 8.4mm ,OS:Android 9,Screen size:6.47-inch,Resolution: 1080 x 2340,CPU: Kirin 980,RAM:6/8GB,Storage: 64/128/256GB'; $productPrices[] = '999.00'; $productQuantities[] = '45'; $productSalePrices[] = '700.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Huawei'; $productNames[] = 'P20 Pro'; $productSpecs[] = 'Weight: 180g,Dimensions: 155 x 73.9 x 7.8mm,OS: Android 9,Screen size:6.1-inch,Resolution: 1080 x 2240,CPU: Kirin 970,RAM: 6GB,Storage: 128GB'; $productPrices[] = '379.00'; $productQuantities[] = '10'; $productSalePrices[] = '250.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Huawei'; $productNames[] = 'Mate 20 X'; $productSpecs[] = 'Weight: 232g,Dimensions: 174.6 x 85.4 x 8.2mm,OS: Android 9,Screen size: 7.2-inch,Resolution: 1080 x 2244,CPU: Kirin 980,RAM: 6/8GB,Storage:128/256GB.'; $productPrices[] = '1089.00'; $productQuantities[] = '6'; $productSalePrices[] = '1000.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Huawei'; $productNames[] = 'Mate 20'; $productSpecs[] = 'Weight: 188g,Dimensions: 158.2 x 77.2 x 8.3 mm,OS: Android 9.0,Screen size: 6.53 inch,Resolution: 1080 x 2244 pixels,CPU: Octa-core/Mali-G76 MP10,RAM: 6GB,Storage: 256GB'; $productPrices[] = '829.00'; $productQuantities[] = '3'; $productSalePrices[] = '680.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Huawei'; $productNames[] = 'Mate 10 Pr'; $productSpecs[] = 'Weight: 178gg ,Dimensions: 154.2 x 74.5 x 7.9mm,OS:Android 9.0,Screen size: 6.0-inch,Resolution:1080 x 2160,CPU: Kirin 970,RAM:6GB,Storage:128GB'; $productPrices[] = '329.00'; $productQuantities[] = '3'; $productSalePrices[] = '249.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Huawei'; $productNames[] = 'P20'; $productSpecs[] = 'Weight: 165g,Dimensions:149.1 x 70.8 x 7.7mm ,OS: Android 9,Screen size: 5.8-inch,Resolution: 1080 x 2240 8,CPU: Kirin 970,RAM: 4GB,Storage:128GB'; $productPrices[] = '399.00'; $productQuantities[] = '5'; $productSalePrices[] = '304.97';

$categoryIDs[] = '1'; $productCompanies[] = 'OnePlus'; $productNames[] = '7T Pro'; $productSpecs[] = 'Weight:206g,Dimensions: 162.6 x 75.9 x 8.8mm,OS:Android 10,Screen size:6.67-inch,Resolution: 1440 x 3120,CPU: Snapdragon 855 Plus,RAM:8/12GB,Storage: 256GB'; $productPrices[] = '699.00'; $productQuantities[] = '5'; $productSalePrices[] = '599.00';
$categoryIDs[] = '1'; $productCompanies[] = 'OnePlus'; $productNames[] = '7T'; $productSpecs[] = 'Weight:190g,Dimensions: 160.9 x 74.4 x 8.1mm,OS:Android 10,Screen size:6.55-inch,Resolution: 1080 x 2400,CPU: Snapdragon 855 Plus,RAM:8GB,Storage: 128/256GB'; $productPrices[] = '549.00'; $productQuantities[] = '5'; $productSalePrices[] = '479.00';
$categoryIDs[] = '1'; $productCompanies[] = 'OnePlus'; $productNames[] = '7 Pro'; $productSpecs[] = 'Weight:206g,Dimensions: 162.6 x 75.9 x 8.8mm,OS:Android 10,Screen size:6.67-inch,Resolution: 1440 x 3120,CPU: Snapdragon 855,RAM:8/12GB,Storage: 128GB/256GB'; $productPrices[] = '699.00'; $productQuantities[] = '5'; $productSalePrices[] = '549.00';
$categoryIDs[] = '1'; $productCompanies[] = 'OnePlus'; $productNames[] = '6T'; $productSpecs[] = 'Weight:185g,Dimensions: 157.5 x 74.8 x 8.2mm,OS:Android 10,Screen size:6.41-inch,Resolution: 1080 x 2340,CPU: Snapdragon 845,RAM: 6/8GB,Storage: 128GB/256GB'; $productPrices[] = '469.00'; $productQuantities[] = '5'; $productSalePrices[] = '349.99';
$categoryIDs[] = '1'; $productCompanies[] = 'OnePlus'; $productNames[] = '6'; $productSpecs[] = 'Weight:177g,Dimensions: 155.7 x 75.4 x 7.8mm,OS:Android 10,Screen size:6.28-inch,Resolution: 1080 x 2280,CPU: Snapdragon 845,RAM: 6/8GB,Storage: 64GB/128GB/256GB '; $productPrices[] = '469.00'; $productQuantities[] = '5'; $productSalePrices[] = '442.60';
$categoryIDs[] = '1'; $productCompanies[] = 'OnePlus'; $productNames[] = '7'; $productSpecs[] = 'Weight:182g,Dimensions: 157.7 x 74.8 x 8.2mm,OS:Android 10,Screen size:6.41-inch,Resolution: 1080 x 2340,CPU: Snapdragon 855,RAM: 6/8GB,Storage: 128GB/256GB '; $productPrices[] = '549.00'; $productQuantities[] = '5'; $productSalePrices[] = '449.00';

$categoryIDs[] = '1'; $productCompanies[] = 'Google'; $productNames[] = 'Pixel 2'; $productSpecs[] = 'Weight:143g,Dimensions:145.7 x 69.7 x 7.8mm,OS:Android 8.0 ,Screen size:5-inch,Resolution: 1080 x 1920 pixels,CPU: Octa-core/Kryo,RAM: 4GB,Storage:64/128GB'; $productPrices[] = '549.00'; $productQuantities[] = '5'; $productSalePrices[] = '449.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Google'; $productNames[] = 'Pixel 2 XL'; $productSpecs[] = 'Weight:175g,Dimensions:157.9 x 76.7 x 7.9mm,OS:Android 8.0,Screen size: 6.0 inches,Resolution: 2880 x 1440 pixels,CPU: Octa-core/Kryo,RAM: 4GB,Storage:64/128GB'; $productPrices[] = '349.00'; $productQuantities[] = '2'; $productSalePrices[] = '249.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Google'; $productNames[] = 'Pixel 3'; $productSpecs[] = 'Weight:148g,Dimensions:145.6 x 68.2 x 7.9 mm,OS:Android 9.0,Screen size: 5.5 inches,Resolution: 1080 x 2160 pixels,CPU: Octa-core/Adreno 630,RAM: 4GB,Storage:64/128GB'; $productPrices[] = '449.00'; $productQuantities[] = '5'; $productSalePrices[] = '349.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Google'; $productNames[] = 'Pixel 3 XL'; $productSpecs[] = 'Weight:148g,Dimensions:158 x 76.7 x 7.9 mm,OS:Android 9.0,Screen size: 6.3 inches,Resolution: 1440 x 2960 pixels,CPU: Octa-core/Adreno 630,RAM: 4GB,Storage:64/128GB'; $productPrices[] = '459.00'; $productQuantities[] = '5'; $productSalePrices[] = '359.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Google'; $productNames[] = 'Pixel 4'; $productSpecs[] = 'Weight:162g,Dimensions:68.8 x 147.1 x 8.2 mm,OS:Android 10,Screen size:5.7 inches,Resolution: 1080 x 2280 pixels,CPU: Quad-core/Kryo,RAM: 6GB,Storage:64/128GB'; $productPrices[] = '769.00'; $productQuantities[] = '5'; $productSalePrices[] = '559.00';
$categoryIDs[] = '1'; $productCompanies[] = 'Google'; $productNames[] = 'Pixel 4'; $productSpecs[] = 'Weight:193 g,Dimensions:160.4 x 75.1 x 8.2mm,OS:Android 10,Screen size:6.3 inches,Resolution: 1440 x 2960 pixels,CPU: Quad-core/Kryo 485 Silver,RAM: 6GB,Storage:64/128GB'; $productPrices[] = '769.00'; $productQuantities[] = '5'; $productSalePrices[] = '679.00';

$categoryIDs[] = '2'; $productCompanies[] = 'iPad'; $productNames[] = 'Pro'; $productSpecs[] = 'A12X Bionic processor, Neural Engine, M12 coprocessor,64GB/256GB/512GB/1TB of storage,12.9in (2732x2048 at 264ppi) LED Liquid Retina screen, True Tone, ProMotion,12Mp rear-facing camera, f/1,8, flash, 4K video, slow-mo at 240fps.'; $productPrices[] = '769.00'; $productQuantities[] = '32'; $productSalePrices[] = '739.00';
$categoryIDs[] = '2'; $productCompanies[] = 'iPad'; $productNames[] = 'Pro 11'; $productSpecs[] = 'Weight: 468g,Dimensions: 247.6 x 178.5 x 5.9 mm, OS: iPadOS 13, Screen size: 11-inch, Resolution: 2388 x 1668 pixels, CPU: A12X Bionic, Storage: 64GB/256GB/512GB/1TB'; $productPrices[] = '719.00'; $productQuantities[] = '10'; $productSalePrices[] = '619.00';
$categoryIDs[] = '2'; $productCompanies[] = 'iPad'; $productNames[] = 'Pro 12'; $productSpecs[] = 'Weight: 632g, Dimensions: 280.6 x 214.9 x 5.9 mm, OS: iPadOS 13, Screen size: 12.9-inch, Resolution: 2048 x 2732 pixels, CPU: A12X Bionic, Storage: 64GB/256GB/512GB/1TB'; $productPrices[] = '939.00'; $productQuantities[] = '50'; $productSalePrices[] = '819.00';
$categoryIDs[] = '2'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy Tab S6'; $productSpecs[] = 'Display: 10.5-inch WQXGA 16:10 HDR OLED,Processor: Qualcomm Snapdragon 855,RAM: 6GB or 8GB,Storage: 128GB or 256GB, with microSD expansion,Cameras: 8-megapixel front, 13-megapixel standard rear, 8-megapixel ultrawide rear,Battery: 7,040mAh,802.11ac Wi-Fi,Bluetooth 5.0.'; $productPrices[] = '619.00'; $productQuantities[] = '100'; $productSalePrices[] = '600.00';
$categoryIDs[] = '2'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy Tab A 7 Inch '; $productSpecs[] = 'Weight: 283g, Dimensions: 187 x 109 x 9mm, OS: Android 5.1, Screen size: 7-inch, Resolution: 1280 x 800, RAM: 1.5GB, Storage: 8GB + MicroSD card slot'; $productPrices[] = '170.00'; $productQuantities[] = '10'; $productSalePrices[] = '139.00';
$categoryIDs[] = '2'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy Tab A 10 Inch'; $productSpecs[] = 'Weight: 525g, Dimensions: 254 x 155 x 8mm, OS: Android 6.0 , Screen size: 10.1-inch, Resolution: 1200 x 1920, RAM: 2GB, Storage: 16GB + MicroSD card slot'; $productPrices[] = '130.00'; $productQuantities[] = '10'; $productSalePrices[] = '99.00';
$categoryIDs[] = '2'; $productCompanies[] = 'Microsoft'; $productNames[] = 'Surface Pro 7'; $productSpecs[] = 'Display: 12.3-inch, 2736 x 1824 (267 PPI) touchscreen, 3:2 aspect ratio,Dimensions: 292 mm x 201 mm x 8.5 mm,Weight: 1.7lbs (i3 and i5) 1.74lbs (i7),Processor: Intel Core i3, i5, or i7,RAM: Up 16GB LPDDR4x (non-upgradable),Storage: Up to 1TB SSD.'; $productPrices[] = '799.00'; $productQuantities[] = '40'; $productSalePrices[] = '650.00';
$categoryIDs[] = '2'; $productCompanies[] = 'Microsoft'; $productNames[] = 'Surface Pro 6'; $productSpecs[] = 'CPU: 8th-generation Intel Core i5 - i7 ,Graphics: Intel UHD Graphics 620,RAM: 8GB - 16GB, Screen: 12.3-inch, 2,736 x 1,824 PixelSense display ,Storage: 128GB - 1TB SSD'; $productPrices[] = '699.00'; $productQuantities[] = '10'; $productSalePrices[] = '669.99';
$categoryIDs[] = '2'; $productCompanies[] = 'Microsoft'; $productNames[] = 'Surface Go'; $productSpecs[] = 'CPU: Intel Pentium Gold 4415Y ,Graphics: Intel HD Graphics 615, RAM: 4GB - 8GB, Screen: 10.5-inch 1,800 x 1,200 PixelSense touch display, Storage: 64GB eMMC - 128GB SSD'; $productPrices[] = '379.00'; $productQuantities[] = '40'; $productSalePrices[] = '359.00';

$categoryIDs[] = '3'; $productCompanies[] = 'Logitech'; $productNames[] = 'MX Master'; $productSpecs[] = 'Connectivity Technology. wireless,2.4 GHz, Bluetooth,Movement Detection Technology. laser,Movement Resolution. 1600 dpi,Performance. realtime sensitivity switching 400 - 1600 dpi,Max Operating Distance. Up to 33 ft.'; $productPrices[] = '99.00'; $productQuantities[] = '40'; $productSalePrices[] = '79.99';
$categoryIDs[] = '3'; $productCompanies[] = 'Logitech'; $productNames[] = 'Craft'; $productSpecs[] = 'Solid, but clunky. The Craft measures just short of 17 inches across, 5.88 inches from front to back, and about 1.13 inches thick. According to Logitech, the pitch—the distance from the center of one key to the next—is 19 millimeters'; $productPrices[] = '179.00'; $productQuantities[] = '3'; $productSalePrices[] = '149.99';
$categoryIDs[] = '3'; $productCompanies[] = 'Logitech'; $productNames[] = 'Folio Case with Bluetooth Keyboard'; $productSpecs[] = 'Logitechs Slim Folio Case with Integrated Bluetooth Keyboard lets you experience laptop-style typing on your iPad (7th gen.) wherever you go. This all-in-one case has a slim, light design that makes it easy to use and carry'; $productPrices[] = '89.95'; $productQuantities[] = '3'; $productSalePrices[] = '59.99';
$categoryIDs[] = '3'; $productCompanies[] = 'Samsung'; $productNames[] = 'Full HD Curved gaming monitor'; $productSpecs[] = 'Screen Size: 27-inch,Screen Curvature: 1800R,Resolution: 2560×1440 (WQHD),Panel Type: VA,Aspect Ratio: 16:9 (Widescreen),Refresh Rate: 144Hz,Response Time: 4ms (GtG),Ports: DisplayPort 1.2, HDMI 1.4, HDMI 2.0,Other Ports: Headphone Jack,Brightness: 300 cd/m2,Contrast Ratio: 3000:1 (static),Colors: 16.7 million (true 8-bit),VESA: Yes (75x75mm)'; $productPrices[] = '299.99'; $productQuantities[] = '67'; $productSalePrices[] = '249.99';
$categoryIDs[] = '3'; $productCompanies[] = 'Samsung'; $productNames[] = 'Galaxy S20 Clear View Cover'; $productSpecs[] = 'The Smart Clear View Cover is programmed to work seamlessly with your phone. It gives you notifications, lets you check alerts, answer or reject calls and view your battery level without ever opening the cover.'; $productPrices[] = '49.99'; $productQuantities[] = '7'; $productSalePrices[] = '29.99';
$categoryIDs[] = '3'; $productCompanies[] = 'Samsung'; $productNames[] = 'Gear S3 Wireless Charging Dock'; $productSpecs[] = 'Features a compact design and magnetised charging dock for optimal portability and reliability. Just pop it on and top it up whenever you’re on the go, and monitor battery status with its handy LED indicator.'; $productPrices[] = '34.99'; $productQuantities[] = '2'; $productSalePrices[] = '29.99';




for ($i=0; $i<count($productNames); $i++)
{
    $sql = "INSERT INTO products (categoryID, productCompany, productName, productSpecs, productPrice, productQuantity, productSalePrice) VALUES ('$categoryIDs[$i]','$productCompanies[$i]', '$productNames[$i]','$productSpecs[$i]','$productPrices[$i]','$productQuantities[$i]','$productSalePrices[$i]');";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}

$productIDs[] = '1'; $productImages[] = 'resources/s10-1.jpg';
$productIDs[] = '1'; $productImages[] = 'resources/s10-2.jpg';

$productIDs[] = '2'; $productImages[] = 'resources/s10+-1.jpg';
$productIDs[] = '2'; $productImages[] = 'resources/s10+-2.jpg';
$productIDs[] = '2'; $productImages[] = 'resources/s10+-3.jpg';

$productIDs[] = '3'; $productImages[] = 'resources/s10+5g-1.jpg';
$productIDs[] = '3'; $productImages[] = 'resources/s10+5g-%202.jpg';

$productIDs[] = '4'; $productImages[] = 'resources/S20-1.jpg';
$productIDs[] = '4'; $productImages[] = 'resources/S20-2.jpg';
$productIDs[] = '4'; $productImages[] = 'resources/S20-3.jpg';

$productIDs[] = '5'; $productImages[] = 'resources/GalaxyNote10-1.jpg';
$productIDs[] = '5'; $productImages[] = 'resources/GalaxyNote10-2.jpg';
$productIDs[] = '5'; $productImages[] = 'resources/GalaxyNote10-3.jpg';

$productIDs[] = '6'; $productImages[] = 'resources/GalaxyA50-1.jpg';
$productIDs[] = '6'; $productImages[] = 'resources/GalaxyA50-2.jpg';
$productIDs[] = '6'; $productImages[] = 'resources/GalaxyA50-3.jpg';

$productIDs[] = '7'; $productImages[] = 'resources/iphone xr-1.jpg';
$productIDs[] = '7'; $productImages[] = 'resources/iphone xr-2.jpg';

$productIDs[] = '8'; $productImages[] = 'resources/iphone xs-1.jpg';
$productIDs[] = '8'; $productImages[] = 'resources/iphone xs-2.jpg';

$productIDs[] = '9'; $productImages[] = 'resources/iphone xs max-1.jpg';
$productIDs[] = '9'; $productImages[] = 'resources/iphone xs max-2.jpg';

$productIDs[] = '10'; $productImages[] = 'resources/Iphone11-1.jpg';
$productIDs[] = '10'; $productImages[] = 'resources/Iphone11-2.jpg';
$productIDs[] = '10'; $productImages[] = 'resources/Iphone11-3.jpg';

$productIDs[] = '11'; $productImages[] = 'resources/Iphone11pro-1.jpg';
$productIDs[] = '11'; $productImages[] = 'resources/Iphone11pro-2.jpg';
$productIDs[] = '11'; $productImages[] = 'resources/Iphone11pro-3.jpg';

$productIDs[] = '12'; $productImages[] = 'resources/iphone11pro max-1.jpg';
$productIDs[] = '12'; $productImages[] = 'resources/iphone11pro max-2.jpg';
$productIDs[] = '12'; $productImages[] = 'resources/iphone11pro max-3.jpg';

$productIDs[] = '13'; $productImages[] = 'resources/p30-1.jpg';
$productIDs[] = '13'; $productImages[] = 'resources/p30-2.jpg';

$productIDs[] = '14'; $productImages[] = 'resources/P20pro-1.jpg';
$productIDs[] = '14'; $productImages[] = 'resources/P20pro-2.jpg';

$productIDs[] = '15'; $productImages[] = 'resources/Mate20X-1.jpg';
$productIDs[] = '15'; $productImages[] = 'resources/Mate20X-2.jpg';

$productIDs[] = '16'; $productImages[] = 'resources/mate20-1.jpg';
$productIDs[] = '16'; $productImages[] = 'resources/mate20-2.jpg';

$productIDs[] = '17'; $productImages[] = 'resources/Mate10Pro-1.jpg';
$productIDs[] = '17'; $productImages[] = 'resources/Mate10Pro-2.jpg';

$productIDs[] = '18'; $productImages[] = 'resources/P20-1.jpg';
$productIDs[] = '18'; $productImages[] = 'resources/P20-2.jpg';

$productIDs[] = '19'; $productImages[] = 'resources/7TPro-1.jpg';
$productIDs[] = '19'; $productImages[] = 'resources/7TPro-2.jpg';

$productIDs[] = '20'; $productImages[] = 'resources/7T-1.jpg';
$productIDs[] = '20'; $productImages[] = 'resources/7T-2.jpg';

$productIDs[] = '21'; $productImages[] = 'resources/7Pro-1.jpg';
$productIDs[] = '21'; $productImages[] = 'resources/7Pro-2.jpg';

$productIDs[] = '22'; $productImages[] = 'resources/6T-1.jpg';
$productIDs[] = '22'; $productImages[] = 'resources/6T-2.jpg';

$productIDs[] = '23'; $productImages[] = 'resources/6-1.jpg';
$productIDs[] = '23'; $productImages[] = 'resources/6-2.jpg';

$productIDs[] = '24'; $productImages[] = 'resources/7-1.jpg';
$productIDs[] = '24'; $productImages[] = 'resources/7-2.jpg';

$productIDs[] = '25'; $productImages[] = 'resources/Pixel2-1.jpg';
$productIDs[] = '25'; $productImages[] = 'resources/Pixel2-2.jpg';

$productIDs[] = '26'; $productImages[] = 'resources/Pixel2xl-1.jpg';
$productIDs[] = '26'; $productImages[] = 'resources/Pixel2xl-2.jpg';

$productIDs[] = '27'; $productImages[] = 'resources/Pixel3-1.jpg';
$productIDs[] = '27'; $productImages[] = 'resources/Pixel3-2.jpg';

$productIDs[] = '28'; $productImages[] = 'resources/Pixel3xl-1.jpg';
$productIDs[] = '28'; $productImages[] = 'resources/Pixel3xl-2.jpg';

$productIDs[] = '29'; $productImages[] = 'resources/Pixel4-1.jpg';
$productIDs[] = '29'; $productImages[] = 'resources/Pixel4-2.jpg';

$productIDs[] = '30'; $productImages[] = 'resources/Pixel4xl-1.jpg';
$productIDs[] = '30'; $productImages[] = 'resources/Pixel4xl-2.jpg';

$productIDs[] = '31'; $productImages[] = 'resources/ipad pro-1.jpg';
$productIDs[] = '31'; $productImages[] = 'resources/ipad pro-2.jpg';

$productIDs[] = '32'; $productImages[] = 'resources/ipadpro11-1.jpg';
$productIDs[] = '32'; $productImages[] = 'resources/ipadpro11-2.jpg';

$productIDs[] = '33'; $productImages[] = 'resources/ipadpro12-1.jpg';
$productIDs[] = '33'; $productImages[] = 'resources/ipadpro12-1.jpg';

$productIDs[] = '34'; $productImages[] = 'resources/tabs6-1.jpg';
$productIDs[] = '34'; $productImages[] = 'resources/tabs6-2.jpg';

$productIDs[] = '35'; $productImages[] = 'resources/TabA7-1.jpg';
$productIDs[] = '35'; $productImages[] = 'resources/TabA7-2.jpg';

$productIDs[] = '36'; $productImages[] = 'resources/TabA10-1.jpg';
$productIDs[] = '36'; $productImages[] = 'resources/TabA10-2.jpg';

$productIDs[] = '37'; $productImages[] = 'resources/SurfacePro7-1.jpg';
$productIDs[] = '37'; $productImages[] = 'resources/SurfacePro7-2.jpg';

$productIDs[] = '38'; $productImages[] = 'resources/SurfacePro6-1.jpg';
$productIDs[] = '38'; $productImages[] = 'resources/SurfacePro6-2.jpg';

$productIDs[] = '39'; $productImages[] = 'resources/surfacego-1.jpg';
$productIDs[] = '39'; $productImages[] = 'resources/surfacego-2.jpg';

$productIDs[] = '40'; $productImages[] = 'resources/mxmaster-1.jpg';
$productIDs[] = '40'; $productImages[] = 'resources/mxmaster-2.jpg';

$productIDs[] = '41'; $productImages[] = 'resources/craft-1.jpg';
$productIDs[] = '41'; $productImages[] = 'resources/craft-2.jpg';

$productIDs[] = '42'; $productImages[] = 'resources/foliocase-1.jpg';
$productIDs[] = '42'; $productImages[] = 'resources/foliocase-2.jpg';

$productIDs[] = '43'; $productImages[] = 'resources/samsungmonitor-1.jpg';
$productIDs[] = '43'; $productImages[] = 'resources/samsungmonitor-2.jpg';

$productIDs[] = '44'; $productImages[] = 'resources/clearcase-1.jpg';
$productIDs[] = '44'; $productImages[] = 'resources/clearcase-2.jpg.jpg';

$productIDs[] = '45'; $productImages[] = 'resources/chargingdock-1.jpg';
$productIDs[] = '45'; $productImages[] = 'resources/chargingdock-2.jpg';

for ($i=0; $i<count($productImages); $i++)
{
    $sql = "INSERT INTO productImages (productID, productImage) VALUES ('$productIDs[$i]', '$productImages[$i]')";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}

$customerIDss[] = '4'; $orderDates[] = '2020-02-21 21:54:39'; $orderSubtotals[] = '2099.00'; $orderVATs[] = '419.80'; $orderTotals[] = '2518.80';
$customerIDss[] = '3'; $orderDates[] = '2020-01-01 21:54:39'; $orderSubtotals[] = '2647.00'; $orderVATs[] = '529.40'; $orderTotals[] = '3176.40';
$customerIDss[] = '1'; $orderDates[] = '2020-03-01 21:54:39'; $orderSubtotals[] = '1099.00'; $orderVATs[] = '219.80'; $orderTotals[] = '1318.10';




/////////////////////////////////////////////////////////////////INSERTION////////////////////////////////////////////////////////////////////////////
// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($customerIDss); $i++)
{
    $sql = "INSERT INTO orders (customerID, orderDate, orderSubTotal, orderVAT, orderTotal) VALUES ('$customerIDss[$i]', '$orderDates[$i]', '$orderSubtotals[$i]', '$orderVATs[$i]', '$orderTotals[$i]')";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}

$orderidss[] = '1'; $productIdss[] = '3'; $productQuantitys[] = '1'; $productLineCosts[] = '1100.00';
$orderidss[] = '1'; $productIdss[] = '5'; $productQuantitys[] = '1'; $productLineCosts[] = '999.00';
$orderidss[] = '2'; $productIdss[] = '4'; $productQuantitys[] = '1'; $productLineCosts[] = '749.00';
$orderidss[] = '2'; $productIdss[] = '2'; $productQuantitys[] = '1'; $productLineCosts[] = '899.00';
$orderidss[] = '2'; $productIdss[] = '5'; $productQuantitys[] = '1'; $productLineCosts[] = '999.00';
$orderidss[] = '3'; $productIdss[] = '6'; $productQuantitys[] = '1'; $productLineCosts[] = '1099.00';

for ($i=0; $i<count($orderidss); $i++)
{
    $sql = "INSERT INTO orderLine (orderID, productID, productQuantity, productLineCost) VALUES ('$orderidss[$i]', '$productIdss[$i]', '$productQuantitys[$i]','$productLineCosts[$i]')";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}





/////////////////////////////////////////////////////////////////INSERTION////////////////////////////////////////////////////////////////////////////
// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($customerIDss); $i++)
{
    $sql = "INSERT INTO orders (customerID, orderDate, orderSubTotal, orderVAT, orderTotal) VALUES ('$customerIDss[$i]', '$orderDates[$i]', '$orderSubtotals[$i]', '$orderVATs[$i]', '$orderTotals[$i]')";
    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}