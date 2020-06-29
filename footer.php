<?php
echo <<<_END
<footer>
    <!-- Google fonts - Poppins-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700">
    <link rel='stylesheet' href='styling.css'>
    <div id="footer">
      <div class="copyrights">
        <div class="containerFooter">
          <div class="row d-flex align-items-center">
            <div class="text col-md-6">
              <p id = "footerP">© 2020 <a href="welcome.php"> MobiTech </a> All rights reserved.</p>
            </div>
            <div class="payment col-md-6 clearfix">
              <ul class="payment-list list-inline-item pull-right">
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-2/img/visa.svg" alt="visa"></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-2/img/mastercard.svg" alt="mastercard"></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-2/img/paypal.svg" alt="paypal"></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-2/img/western-union.svg" alt="western union"></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    <div>
</footer>
_END;
?>