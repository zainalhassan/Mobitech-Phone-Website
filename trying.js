$(document).ready(function(){
    $("select#selectedValue").one('change',(function()
    {
        var selectedCountry = $(this).children("option:selected").val();
        // alert("You have selected the country - " + selectedCountry);
        var secondSelect = "<p> second srtuff </p>";
        $('#selects').append(secondSelect);
    }));
});