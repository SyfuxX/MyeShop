<?php

require_once ('./inc/header.php');

    $page = "Profile Settings";

    if (!isConnect ())
    {
        header ('./login.php');
    }


?>


<!--    Form 

    Fill in user information such as pseudo, adress, old email password



 -->


 <!-- CHANGE ACCOUNT INFORMATION -->

 <!-- EMAIL -->
 <h3>Change your email adress</h3>
<form>
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" id="email" class="form-control" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="rEmail">Retype email adress</label>
    <input type="email" id="rEmail" class="form-control"placeholder="Retype Email">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


<!-- PSEUDO -->
<hr>
 <h3>Change your pseudo</h3>
<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Pseudo</label>
    <input type="email" class="form-control" placeholder="Enter Pseudo">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Retype new pseudo</label>
    <input type="email" class="form-control" placeholder="Retype Email">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


<!-- PASSWORD -->
<hr>
<h3>Change your password</h3>
<form>
  <div class="form-group">
    <label for="password">Old Password</label>
    <input type="password" id="password" class="form-control" placeholder="Enter old password">
  </div>
  <div class="form-group">
    <label for="nPassword">New Password</label>
    <input type="text" class="form-control" id="nPassword" placeholder="Enter new password">
  </div>
  <div class="form-group">
    <label for="rPassword">Re-type New Password</label>
    <input type="text" class="form-control" id="rPassword" placeholder="Retype old password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


<!-- ADRESS -->
<hr>
<h3>Change your Address</h3>
<form>
  <div class="form-group">
    <label for="password">Address</label>
    <input type="password" id="address" class="form-control" placeholder="Enter street">
  </div>
  <div class="form-group">
    <label for="city">City</label>
    <input type="text" class="form-control" id="city" placeholder="Enter city">
  </div>
  <div class="form-group">
    <label for="Zip-Code">Zip-Code</label>
    <input type="text" class="form-control" id="Zip-Code" placeholder="Enter old Zip-Code">
  </div>
  <button type="submit" class="btn btn-primary" style="margin-bottom: 2rem; ">Submit</button>
</form>





<?php 
    require_once ('./inc/footer.php');
?>