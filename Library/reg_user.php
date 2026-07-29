<?php 

?>

<!DOCTYPE html>
<html>
<title> GeneClat Technologies</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script> 
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: center;
  background-size: cover;
  background-image: url("img/a.jpg");
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}
a{

    padding:50px;
}
</style>
<body>

<!-- Navbar (sit on top) -->

             <div class="row">
         <br><br>
<div class="col-md-9 col-md-offset-1">
               <div class="panel panel-danger">
                        <div class="panel-heading">
                           SINGUP FORM
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post" action="" onSubmit="return valid();">

                            	<div class="form-group">
<label>Email*</label>
<input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" placeholder="email" autocomplete="off" required  />
   <span id="user-availability-status" style="font-size:12px;"></span> 
</div>

<div class="form-group">
<label>Title</label>
<input type="text"  name="title" maxlength="5" autocomplete="off" placeholder="Title" required style="width: 150px; height: 25px;" />
</div>  

<div class="form-group">
<label>Name</label>
<input class="form-control" type="text" name="fullname" placeholder="Full Name" autocomplete="off" required />
</div>
                                        
<div class="form-group">
<label>Address</label>
<input class="form-control" type="text" name="address" placeholder="address" autocomplete="off" required />
</div>

<div class="form-group">
<label>Mobile Phone</label>
<input class="form-control" type="text" name="mobile" placeholder="+91 99900 02222 " autocomplete="off" required />
</div>


<div class="form-group">
<label>Company/Organization</label>
<input class="form-control" type="text" name="company" placeholder="company" autocomplete="off" required />
</div>

<div class="form-group">
<label>Designation</label>
<input class="form-control" type="text" name="des" placeholder="Designation" autocomplete="off" required />
</div>

<div class="form-group">
<label>Accomodation</label>
<input class="form-control" type="text" name="acc" placeholder="Accomodation" autocomplete="off" required />
</div>

<div class="form-group">
<label>Area of interests</label>
<input class="form-control" type="text" name="area" placeholder="Interests" autocomplete="off" required />
</div>

<div class="form-group">
<label>Transaction ID</label>
<input class="form-control" type="text" name="transaction_id" placeholder="Transaction ID" autocomplete="off" required />
</div>

                               
<button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now </button>

                                    </form>
                            </div>
                        </div>
                            </div>
    </div>
    </div>
</body>
</html>
