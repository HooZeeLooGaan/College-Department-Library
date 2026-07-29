<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<div class="navbar navbar-inverse set-radius-zero" style="opacity:0.9">
        <div class="container">
            <div class="navbar-header" >
			
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
					
                </button>
                <a class="navbar-brand" >

                    <img src="assets/img/image1.png" height=75 />
					<span><font size=30 color=#000000 ><b>Global Academy of Technology </font><font size=2 >Dept. of CSE</font></b></span>
					
                </a>

            </div>
			
<?php if($_SESSION['login'])
{
?> 
            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">LOG ME OUT</a>
            </div>
            <?php }?>
        </div>
    </div>

	
<?php if($_SESSION['login'])
{
?>    
<section class="menu-section">
        <div class="container"> 
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                       
                        
                                                       <li><a href="dashboard.php" class="menu-top-active">DASHBOARD</a></li>
                                                      
                                                     
                              <li>
                                                           <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Account <i class="fa fa-angle-down"></i></a>
                                                           <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                                               <li role="presentation"><a role="menuitem" tabindex="-1" href="my-profile.php">My Profile</a></li>
                                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="change-password.php">Change Password</a></li>
                                                           </ul>
                                                       </li>
                                                       <li><a href="issued-books.php">Issued Books</a></li>
                           
                                                       <li><a href="books.php">Browse the library</a></li>
                                                     
                           
                                                   </ul>
                                               </div>
                                           </div>
                           
                                       </div>
                                   </div>
                               </section>
                               <?php } else { ?>
                                   <section class="menu-section">
                                   <div class="container">
                                       <div class="row ">
                                           <div class="col-md-12">
                                               <div class="navbar-collapse collapse "></h6><b>Library Management System</b></h6>
                                                   <ul id="menu-top" class="nav navbar-nav navbar-right">                        
                                                     
                             <li><a href="adminlogin.php">Admin Login</a></li>
                                                      
                                                        <li><a href="index.php">Student Login</a></li>
                                                     
                           
                                                   </ul>
                                               </div>
                                           </div>
                           
                                       </div>
                                   </div>
                               </section><br>

    <?php } ?>
	

<style type="text/css">
html{
    min-height: 700px;
    min-width: 1000px;
    height: 100vh;
}
body{
  font-family: 'Open Sans', sans-serif;
}
.head{
text-align: left;
}
.menu-section {
    background-color: #f7f7f7;
    border-bottom:0px solid #3bb9ff;
    width:100%
}
#menu-top a {
    color:#000000;
    background-color: #00e6e6;
    text-decoration:none;
    font-weight:500;
    padding: 25px 15px 25px 15px;
    text-transform:uppercase;
    
}
#menu-top a:hover{
  background-color: #ffffff;
  color: #3bb9ff;
}
.menu-section{
  opacity: 0.6;
}
.header-line {
    font-weight:900;
    padding-bottom:25px;
    border-bottom:2px solid #ffffff;
    text-transform:uppercase;
}

</style>