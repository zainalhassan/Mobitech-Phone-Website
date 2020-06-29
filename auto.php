<?php
require_once "header.php";

$sql = "SELECT CONCAT(productCompany, ' ', productName) AS prodName FROM products;";
$result = mysqli_query($connection, $sql);
$n = mysqli_num_rows($result);
if($n > 0) {
    $arrayData = array();
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        foreach ($row as $data) {
            echo "<br>";
            array_push($arrayData, $data);
        }
    }
    $json = json_encode($arrayData);
    echo $json;
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Autocomplete - Default functionality</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            let som = <?php echo $json ?>;
            $( "#tags" ).autocomplete({
                source: som
            });
        } );
    </script>
</head>
<body>

<div class="ui-widget">
    <label for="tags">Tags: </label>
    <input id="tags">
</div>


</body>
</html>
