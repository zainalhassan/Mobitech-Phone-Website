<?php

require_once "header.php";

if(isset($_SESSION['loggedIn']) && $_SESSION['username'] == 'admin')
{
    $sql = "SELECT categoryName FROM category";
    $result = mysqli_query($connection, $sql);
    $n = mysqli_num_rows($result);
    echo "<div id = 'selects'>";
    if ($n > 0)
    {
        echo "<form>";
        echo "<select id = 'selectedValue'>";
        for($i = 0; $i < $n; $i++)
        {
            $row = mysqli_fetch_assoc($result);
            echo $row['categoryName'];
            echo "<br>";
            echo "<option> {$row['categoryName']}</option>";
        }
        echo "</select>";


            $second =
                "
                <select id = 'selectedValue'>
                    <option> hello </option>
                </select>
                ";
        echo <<<_END
        <script>
        $("select#selectedValue").one('change',(function()
            {
                var selectedCountry = $(this).children("option:selected").val();
                var secondSelect = "<p> second srtuff </p>";
                $('#selects').append("<select id = 'selectedValue'> <option> hello </option> </select>");
            }));
        </script>

_END;
        echo "</form>";
    }





    echo "</div>";
}
else
{
    echo "You do not have permission to view this page";
}
?>