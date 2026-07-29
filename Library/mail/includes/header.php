<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header" >
			
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
					
                </button>
                <a class="navbar-brand" >

                    <img src="assets/img/image1.png" height=75 />
					<span style="position:relative;"><font size=30 color=#000000 ><b>Global Academy of Technology </font><font size=2 >Dept. of CSE</font></b></span>
					
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
    border-bottom:5px solid #0000ff;
    width:100%
}

</style>