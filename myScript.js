$(document).ready(function()
{
    $('#cartLi').on('click', function()
    {
        $(window).scrollTop(0);

        $.ajax({
            url: 'ajaxCart.php',
            method: 'POST',
            dataType: 'json',
            data:
                {
                    key: 'cart'
                },
            success: function (response)
            {
                // console.log("response length: " + response.length);
                var subTotal = 0;

                for(let i = 0; i < response.length; i++)
                {
                    // console.log(response[i]);
                    var x = document.getElementsByClassName("alert-heading");
                    x[i].innerHTML = response[i].productCompany + " " + response[i].productName;

                    x = document.getElementsByClassName("qty");
                    x[i].innerHTML = "<strong> Quantity: </strong>" + response[i].productQuantity;

                    x = document.getElementsByClassName("specs");
                    x[i].innerHTML = "<strong> Specs: </strong>" + response[i].productSpecs;

                    x = document.getElementsByClassName("cartPrice");
                    var price = response[i].productPrice * response[i].productQuantity;
                    x[i].innerHTML = "<strong> Price: </strong> £" + price;

                    subTotal = subTotal + price;
                }
                document.getElementById("totalPrice").innerHTML = "<strong> SubTotal: </strong>£" + subTotal + "<sup> (excluding VAT)</sup>";
            }
        });
    });

    $('.removeFromCartBtn').on('click', function()
    {
        var val = $(this).val();

            $.ajax({
                url: 'ajaxCart.php',
                method: 'POST',
                dataType: 'json',
                data:
                    {
                        key: 'cartDelete',
                        index: val
                    },
                success: function (response) {
                    document.getElementById("cartLi").innerHTML = "<i class='fas fa-shopping-cart'></i> Cart (" + response.length + ")";

                    console.log("response length: " + response.length);
                    var subTotal = 0;

                    for (let i = 0; i < response.length; i++) {
                        console.log(response[i]);
                        var x = document.getElementsByClassName("removeFromCartBtn");
                        x[i].setAttribute("value", i);

                        var x = document.getElementsByClassName("alert-heading");
                        x[i].innerHTML = response[i].productCompany + " " + response[i].productName;

                        x = document.getElementsByClassName("qty");
                        x[i].innerHTML = "<strong> Quantity: </strong>" + response[i].productQuantity;

                        x = document.getElementsByClassName("specs");
                        x[i].innerHTML = "<strong> Specs: </strong>" + response[i].productSpecs;

                        x = document.getElementsByClassName("cartPrice");
                        var price = response[i].productPrice * response[i].productQuantity;
                        x[i].innerHTML = "<strong> Price: </strong> £" + price;

                        subTotal = subTotal + price;
                    }
                    document.getElementById("totalPrice").innerHTML = "<strong> SubTotal: </strong>£" + subTotal + "<sup> (excluding VAT)</sup>";
                }
            });
    });

});