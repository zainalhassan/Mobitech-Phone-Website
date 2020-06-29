$(document).ready(function()
{
    $("#addNew").on('click', function(){
        $('#viewContent').fadeOut();
        $('#editContent').fadeIn();
        $('.modal-title').html("Insert a User: ");
        $('#userFName').val('');
        $('#userLName').val('');
        $('#userAL1').val('');
        $('#userAL2').val('');
        $('#userPostCode').val('');
        $('#userEmail').val('');
        $('#userDob').val('');
        $('#userPhone').val('');
        $('#userUsername').val('');
        $('#userPassword').val('');

        $('#userBtn').attr('value', 'Add User').attr('onclick',"manageData('addNew')");
        $('#closeBtn').fadeOut();
        $('#userBtn').fadeIn();
        $("#tableManager").modal('show');
    });

    getExistingData(0,10);
});

function getExistingData(start, limit)
{
    $.ajax({
        url: 'ajaxUsers.php',
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

    var userFName= $("#userFName");
    var userLName= $("#userLName");
    var userAL1= $("#userAL1");
    var userAL2= $("#userAL2");
    var userPostCode= $("#userPostCode");
    var userEmail= $("#userEmail");
    var userDob= $("#userDob");
    var userPhone= $("#userPhone");

    var userUsername= $("#userUsername");
    var userPassword= $("#userPassword");

    var editUserID= $("#editUserID");

    if(isNotEmpty(userFName) && isNotEmpty(userLName) && isNotEmpty(userAL1) && isNotEmpty(userAL2) && isNotEmpty(userPostCode) && isNotEmpty(userEmail) && isNotEmpty(userDob) && isNotEmpty(userPhone) && isNotEmpty(userUsername) && isNotEmpty(userPassword) )
    {
        $.ajax({
            url: 'ajaxUsers.php',
            method: 'POST',
            dataType: 'text',
            data:
                {
                    key: key,
                    userFName: userFName.val(),
                    userLName: userLName.val(),
                    userAL1: userAL1.val(),
                    userAL2: userAL2.val(),
                    userPostCode: userPostCode.val(),
                    userEmail: userEmail.val(),
                    userDob: userDob.val(),
                    userPhone: userPhone.val(),
                    userUsername: userUsername.val(),
                    userPassword: userPassword.val(),
                    editUserID: editUserID.val()
                },
            success: function(response)
            {
                if(response !== "Customer updated")
                {
                    alert(response);
                    $("#tableManager").modal('hide');
                }
                else
                {
                    $("#userFName" + editUserID.val()).html(userFName.val());
                    $("#userLName" + editUserID.val()).html(userLName.val());
                    $("#userAL1" + editUserID.val()).html(userAL1.val());
                    $("#userAL2" + editUserID.val()).html(userAL2.val());
                    $("#userPostCode" + editUserID.val()).html(userPostCode.val());
                    $("#userEmail" + editUserID.val()).html(userEmail.val());
                    $("#userDob" + editUserID.val()).html(userDob.val());
                    $("#userPhone" + editUserID.val()).html(userPhone.val());
                    $("#userUsername" + editUserID.val()).html(userUsername.val());
                    $("#userPassword" + editUserID.val()).html(userPassword.val());

                    $("#tableManager").modal('hide');

                    userLName.val('');
                    userFName.val('');
                    userAL1.val('');
                    userAL2.val('');
                    userPostCode.val('');
                    userEmail.val('');
                    userDob.val('');
                    userPhone.val('');
                    userUsername.val('');
                    userPassword.val('');

                    $('#userBtn').attr('value', 'Add User').attr('onclick',"manageData('addNew')");
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

function deleteUser(deleteID)
{
    if(confirm("Are you sure you want to delete?"))
    {
        $.ajax({
            url: 'ajaxUsers.php',
            method: 'POST',
            dataType: 'text',
            data:
                {
                    key: 'delete',
                    deleteID: deleteID
                },
            success: function (response)
            {
                $('#userUsername' + deleteID).parent().remove();
                alert(response);
            }
        });
    }
}

function editOrView(customerID, type)
{
    $.ajax({
        url: 'ajaxUsers.php',
        method: 'POST',
        dataType: 'json',
        data:
            {
                key: 'getRowData',
                customerID: customerID
            },
        success: function(response)
        {

            if(type === 'view')
            {
                $('.modal-title').html("User details: ");
                $('#editContent').fadeOut();
                $('#viewContent').fadeIn();
                $('#userFNameView').html(response.userFName);
                $('#userLNameView').html(response.userLName);
                $('#userAL1View').html(response.userAL1);
                $('#userAL2View').html(response.userAL2);
                $('#userPostCodeView').html(response.userPostCode);
                $('#userEmailView').html(response.userEmail);
                $('#userDobView').html(response.userDob);
                $('#userPhoneView').html(response.userPhone);
                $('#userUsernameView').html(response.userUsername);
                $('#userPasswordView').html(response.userPassword);
                $('#userBtn').fadeOut();
                $('#closeBtn').fadeIn();
            }
            else
            {
                console.log(response);
                $('#viewContent').fadeOut();
                $('#editContent').fadeIn();

                $('#editUserID').val(customerID);
                //populate edit fields
                $('#userFName').val(response.userFName);
                $('#userLName').val(response.userLName);
                $('#userAL1').val(response.userAL1);
                $('#userAL2').val(response.userAL2);
                $('#userPostCode').val(response.userPostCode);
                $('#userEmail').val(response.userEmail);
                $('#userDob').val(response.userDob);
                $('#userPhone').val(response.userPhone);
                $('#userUsername').val(response.userUsername);
                $('#userPassword').val(response.userPassword);
                $('#userBtn').attr('value', 'Save Changes').attr('onclick', "manageData('update')");
                $('.modal-title').html("Edit: " + response.userFName + " " + response.userLName);
                $('#closeBtn').fadeOut();
                $('#userBtn').fadeIn();
            }
            $("#tableManager").modal('show');
        }
    });
}