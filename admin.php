<?php

require_once "header.php";

if ($_SESSION['username'] == "admin")
{
    echo <<<_END
    <h2 class = "header1"> Admin Tools</h2>
    <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Manage Users</h5>
                <p class="card-text">Use this to manage existing users, change details, insert new users and also delete accounts</p>
                <a href="crudUsers.html" class="btn btn1 btn-md btn-block btn-dark hvr-overline-from-center">CRUD Users</a>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Manage Products</h5>
                <p class="card-text">Use this to manage existing products, change details, insert new products and also delete products</p>
                <a href="crud.html" class="btn btn1 btn-md btn-block btn-dark hvr-overline-from-center"> CRUD Products</a>
              </div>
            </div>
          </div>
        </div>
    </div>
_END;

}
else
{
    echo "You do not have permission to see this page";
}
echo "<br>";
require_once "footer.php";
?>