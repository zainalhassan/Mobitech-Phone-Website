$(document).ready(function()
{
    $("#addNew").on('click', function(){
        $('#viewContent').fadeOut();
        $('#editContent').fadeIn();
        //reset values
        $('.modal-title').html("Insert a product: ");
        $('#prodCat').val('1');
        $('#prodComp').val('');
        $('#prodName').val('');
        $('#prodSpecs').val('');
        $('#prodPrice').val('');
        $('#prodQuantity').val('');
        $('#prodSalePrice').val('');
        $('#prodBtn').attr('value', 'Add Product').attr('onclick',"manageData('addNew')");
        $('#closeBtn').fadeOut();
        $('#prodBtn').fadeIn();
        $("#tableManager").modal('show');
    });
    getExistingData(0,10);
});

function deleteProduct(deleteID)
{
    if(confirm("Are you sure you want to delete?"))
    {
        $.ajax({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'text',
            data:
                {
                    key: 'delete',
                    deleteID: deleteID
                },
            success: function (response)
            {
                $('#prodName' + deleteID).parent().remove();
                alert(response);
            }
        });
    }
}

function editOrView(productID, type)
{
    $.ajax({
        url: 'ajax.php',
        method: 'POST',
        dataType: 'json',
        data:
        {
            key: 'getRowData',
            productID: productID
        },
        success: function(response)
        {

            if(type === 'view')
            {
                $('.modal-title').html("Product details: ");
                $('#editContent').fadeOut();
                $('#viewContent').fadeIn();
                $('#prodIDView').html(productID);
                $('#catIDView').html(response.categoryID);
                $('#prodCompView').html(response.productCompany);
                $('#prodNameView').html(response.productName);
                $('#prodSpecsView').html(response.productSpecs);
                $('#prodPriceView').html(response.productPrice);
                $('#prodQuantityView').html(response.productQuantity);
                $('#prodSalePriceView').html(response.productSalePrice);
                $('#prodBtn').fadeOut();
                $('#closeBtn').fadeIn();
            }
            else
            {
                console.log(response);
                $('#viewContent').fadeOut();
                $('#editContent').fadeIn();

                $('#editProdID').val(productID);
                //populate edit fields
                $('#prodCat').val(response.categoryID);
                $('#prodComp').val(response.productCompany);
                $('#prodName').val(response.productName);
                $('#prodSpecs').val(response.productSpecs);
                $('#prodPrice').val(response.productPrice);
                $('#prodQuantity').val(response.productQuantity);
                $('#prodSalePrice').val(response.productSalePrice);
                $('#prodBtn').attr('value', 'Save Changes').attr('onclick', "manageData('update')");
                $('.modal-title').html("Edit: " + response.productCompany + " " + response.productName);
                $('#closeBtn').fadeOut();
                $('#prodBtn').fadeIn();
            }
            $("#tableManager").modal('show');
        }
    });
}

function getExistingData(start, limit)
{
    $.ajax({
        url: 'ajax.php',
        method: 'POST',
        dataType: 'text',
        data:
        {
            key: 'getExistingData',
            start: start,
            limit: limit
        },
        success: function(response)
        {
            if(response != "reachedMax")
            {
                $('tbody').append(response);
                start = start + limit;
                getExistingData(start,limit);
            }
            else
            {
                $('.table').DataTable();
            }
        }
    });
}

function manageData(key)
{
    var select = document.getElementById("prodCat");
    var prodCat = select.options[select.selectedIndex].value;
    var prodComp = $("#prodComp");
    var prodName = $("#prodName");
    var prodSpecs = $("#prodSpecs");
    var prodPrice = $("#prodPrice");
    var prodQuantity = $("#prodQuantity");
    var prodSalePrice = $("#prodSalePrice");
    var editProdID = $("#editProdID");

    if(isNotEmpty(prodComp) && isNotEmpty(prodName) && isNotEmpty(prodSpecs) && isNotEmpty(prodPrice) && isNotEmpty(prodQuantity) && isNotEmpty(prodSalePrice))
    {
       $.ajax({
           url: 'ajax.php',
           method: 'POST',
           dataType: 'text',
           data:
           {
               key: key,
               prodCat: prodCat,
               prodComp: prodComp.val(),
               prodName: prodName.val(),
               prodSpecs: prodSpecs.val(),
               prodPrice: prodPrice.val(),
               prodQuantity: prodQuantity.val(),
               prodSalePrice: prodSalePrice.val(),
               editProdID: editProdID.val()
           },
           success: function(response)
           {
               if(response !== "Product updated")
               {
                   alert(response);
                   $("#tableManager").modal('hide');
               }
               else
               {

                   $("#catID" + editProdID.val()).html(prodCat);
                   $("#prodComp" + editProdID.val()).html(prodComp.val());
                   $("#prodName" + editProdID.val()).html(prodName.val());
                   $("#prodSpecs" + editProdID.val()).html(prodSpecs.val());
                   $("#prodPrice" + editProdID.val()).html(prodPrice.val());
                   $("#prodQuantity" + editProdID.val()).html(prodQuantity.val());
                   $("#prodSalePrice" + editProdID.val()).html(prodSalePrice.val());
                   $("#tableManager").modal('hide');

                   // $prodCat = 1;
                   $('#prodComp').val('');
                   prodComp.val('');
                   prodName.val('');
                   prodSpecs.val('');
                   prodPrice.val('');
                   prodQuantity.val('');
                   prodSalePrice.val('');

                   $('#prodBtn').attr('value', 'Add Product').attr('onclick',"manageData('addNew')");
               }

           }
       });

    }
    function isNotEmpty(caller)
    {
        if(caller.val() === '')
        {
            caller.css('border', '1px solid red');
            return false;
        }
        else
        {
            caller.css('border', '1px solid green');
        }
        return true;
    }
}