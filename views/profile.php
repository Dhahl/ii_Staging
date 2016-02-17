<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Irish Interest - my Profile</title>
	<link rel="icon" type="image/png" href="./favicon.png" />

    <!-- Bootstrap -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/bootstrap-theme.min.css" rel="stylesheet">
 	<link href="./css/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
 	
 	<!-- Style.css -->
    <link href="./css/style.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>				
 </head>
 <body role="document">
 <?php 
// var_dump($_SESSION);
$heading = ' Edit My Profile';

$userMenu =	'
   			<button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown" 
    				style="border-radius: 10px; font-weight:900;">'
  					.$_SESSION['user'].'
    				<span class="caret"></span>
    		</button>';
 if($_SESSION['accessLevel']		=='10')	{
  	$userMenu .=	'
  	  	<ul class="dropdown-menu" style="text-align:left">
		  	<li><a href="./admin/">Publishers </a></li>
		  	<li><a href="./categories/">Categories</a></li>
		  	<li><a href="./banner/">Banners</a></li>
		 	<li><a href="../utilities/">Utilities</a></li>
		  	<li class="divider"></li>
  			<li><a href="./publish/">Add Books / Edit Books</a></li>
  			<li><a href="./authors/">Author Profiles</a></li>
  			<li><a href="#"><i>'.$_SESSION['user'].'</i> Profile</a></li>
		  	<li class="divider"></li>
  			<li><a href="./?home=1">Home Page</a></li>
  			<li><a href="./logout">Sign Out</a></li>
  	  	  			</ul>';
 }
 if( ($_SESSION['accessLevel']		=='1')
   || ($_SESSION['accessLevel']		== '2'	) )	{
  	$userMenu .=	'
  	  	<ul class="dropdown-menu" style="text-align:left">
  			<li><a href="publish/">Add Books / Edit Books</a></li>
  			<li><a href="authors/">Author Profiles</a></li>
  			<li><a href="#"><i>'.$_SESSION['user'].'</i> Profile</a></li>
		  	<li class="divider"></li>
  			<li><a href="./?home=1">Home Page</a></li>
  			<li><a href="./logout">Sign Out</a></li>
 		</ul>';
}
if($_SESSION['accessLevel']		=='3')	{
  	$userMenu .=	'
			<ul class="dropdown-menu" style="text-align:left">
  				<li><a href="./logout">Sign Out</a></li>
  			</ul>';
}
$userErr			=	"";
$userMsg			=	"";
$fullnameErr		=	"";
$fullnameMsg		=	"";
$publishernameErr	=	"";
$publishernameMsg	=	"";
$emailErr			=	"";
$emailMsg			=	"";
$passwordErr		=	"";
$passwordMsg		=	"";
		foreach($_SESSION['err']['field'] as $idx => $field)	{	
			switch ($field)	{
			case 'firstname':
				$firstnameErr	=	"has-error";
				$firstnameMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'lastname':
				$lastnameErr	=	"has-error";
				$lastnameMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'publishername':
				$publishernameErr	=	"has-error";
				$publishernameMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'email':
				$emailErr	=	"has-error";
				$emailMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'telephone':
				$telephoneErr	=	"has-error";
				$telephoneMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'position':
				$positionErr	=	"has-error";
				$positionMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'password':
				$passwordErr	=	"has-error";
				$passwordMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'confirm':
				$confirmErr	=	"has-error";
				$confirmMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			}
		}
?> 
<div class="row " >
	<a href='../'> 
		<div class="col-md-2 col-sm-2 voffset6" style="background-color:#ffffff; z-index:1000; " >
			<img alt="" src="ii_circle.png" class="image-responsive ii_circle" >
		</div>
		<div class="col-md-3  col-sm-4 voffset8 ii_text_div" >
		
			<img alt="" src="IRISH_INTEREST_text.png" class="image-responsive ii_text" >
		</div>
	</a>
	<div class="col-md-7 primaryMenu voffset6">
		<div class="col-md-2" style="font-size: 16px;">
			
		</div>
		<div class="col-md-4" style="font-size: 16px;">
			
		</div>
		<div class="col-md-5">
			<div class="col-md-8 pull-right" style="border: 0px solid; border-radius: 10px; line-height: 2; font-weight: 900; font-size: 14px; font: Impact, Charcoal, sans-serif;">
				<?php echo $userMenu; ?>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</div>
<!-- Fixed navbar -->
<div class="navbar  " role="navigation" style="margin: 0px; min-height: 0px; border: 0px; padding: 0px">
	<div class="row" style="padding: 0px; margin: 0px;">
		<div class="col-md-8 col-lg-8" style="padding: 0px"></div>
		<div class="col-md-3 col-lg-3" style="padding: 0px"><!-- Go to www.addthis.com/dashboard to customize your tools -->


					<!-- img src="./rss.png" class="img-responsive" style="display:inline; margin:6px;">
					<img src="./facebook.png" class="img-responsive" style="display:inline; margin:6px;">
					<img src="./twitter.png" class="img-responsive" style="display:inline; margin:6px;">
					<img src="./sharethis.png" class="img-responsive" style="display:inline; margin:6px;">
					<img src="./myspace.png" class="img-responsive" style="display:inline; margin:6px;">
					<img src="./googleplus.png" class="img-responsive" style="display:inline; margin:6px;"-->
		</div>
		<div class="col-md-1" style="padding-top: 10px"></div>
	</div>
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span> 
			<span class="icon-bar"></span> 
			<span class="icon-bar"></span>
		</button>

<!--    <div class="navbar-brand">
           <div class="media pull-right">
         	<img src="./trans_white_02.png" class="img-responsive" >
           </div> 
          </div> -->
	</div>
	<div class="navbar-collapse collapse">
		<div class="row" style="background-color: #f3be22; line-height: 2; min-height:25px; font-weight: 600;">
			<div class="col-md-3"></div>
			<div class="col-md-9">
				<div class="col-md-3 col-sm-3 col-xs-8 ">
					<span class="pull-right">
						<a href="/"></a> 
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<img alt="" src="./images/bookshop01.jpeg" style="max-height: 350px; width: 100%" class="image-responsive">
<div class="col-md-1 col-xs-12 col-sm-1"></div>
<div class="col-md-10 col-sm-10 col-xs-12 event-panel" > 
	<div class="container-fluid" style="border-radius: 4px">
		<div class="container-pad" id="property-listings" style="background-color: #f3be22; border: 0px solid; border-radius: 25px">
			<div class="row">
				<a href="./?home=1">
					<div class="glyphicon glyphicon-remove-circle   pull-right"	
								title="Home" style="margin-right:20px; font-size: 20px; text-shadow: black 0px 1px 1px;">
					</div>
				</a>
			</div>';
		
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 ">

  							<div class="col-md-1"></div>
  							<div class="col-md-10">
   								 <div class="well well-sm" style="border-radius:25px">
  				<?php echo displayMessage();?>
 								 	<h4  class="text-center"><?php echo $heading;?></h4><br/>
<!-- form -->
<form role="form" method="post" class="form-horizontal" >
<fieldset>
<!-- first Name-->
<div class="form-group <?php echo $firstnameErr ; ?>" style="padding-top:50px";>
  <label class="col-md-4 control-label control-label.has-error" for="firstname">First Name</label>
  <div class="col-md-5">
  	<div class="required-field-block">
    	<input id="firstname" name="firstname" placeholder="First Name" class="form-control  input-md" required type="text"
    	 value="<?php echo $_SESSION['firstname'] ; ?>" >
            <div class="required-icon">
                <div class="text">*</div>
            </div>
   	</div>
  </div>
    
 <span class="help-inline"><?php echo $firstnameMsg; ?></span>
</div>

<!-- Full name -->
<div class=" form-group <?php echo $lastnameErr ; ?>">
  <label class="col-md-4 control-label control-label.has-error" for="lastname">Last Name</label>
   <div class="col-md-5">
  <div class="required-field-block">
    <input id="lastname" name="lastname" placeholder="Last Name" class="form-control input-md" required type="text"
    value="<?php echo $_SESSION['lastname'] ; ?>" >
            <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
 <span class="help-inline"><?php echo $lastnameMsg; ?></span>
  </div>
</div>

<!-- Publisher -->
<div class="form-group <?php echo $publishernameErr ; ?>">
  <label class="col-md-4 control-label control-label.has-error" for="publishername">Company Name</label>
  <div class="col-md-5">
    				    <div class="required-field-block">
  
  <div class="controls">
    <input id="publishername" name="publishername" placeholder="company name" class="form-control input-md" 
     type="text" value="<?php echo $_SESSION['publishername'] ; ?>" disabled>
   </div>
    			        <div class="required-icon">
   		                  <div class="text">*</div>
            		    </div>
   				    </div>
 <span class="help-inline"><?php echo $publishernameMsg; ?></span>
  </div>
</div>
<!-- Telephone -->
<div class="form-group <?php echo $telephoneErr ; ?>">
  <label class="col-md-4 control-label control-label.has-error" for="telepohone">Telephone</label>
  <div class="col-md-5">
  <div class="controls">
    <input id="telephone" name="telephone" placeholder="telephone" class="form-control input-md" 
     type="text" value="<?php echo $_SESSION['telephone'] ; ?>" >
    
  </div>
 <span class="help-inline"><?php echo $telephoneMsg; ?></span>
  </div>
  <div class="col-md-4"></div>
</div>

<!-- Position -->
<div class="form-group <?php echo $positionErr ; ?>">
  <label class="col-md-4 control-label control-label.has-error" for="position">Position</label>
  <div class="col-md-5">
  <div class="required-field-block">
    <input id="position" name="position" placeholder="position" class="form-control input-md" 
    required type="text" value="<?php echo $_SESSION['position'] ; ?>" >
           <div class="required-icon">
                <div class="text">*</div>
            </div>
    
  </div>
 <span class="help-inline"><?php echo $positionMsg; ?></span>
  </div>
  <div class="col-md-4"></div>
</div>
<!-- EMail -->
<div class="form-group  <?php echo $emailErr ; ?>">
  <label class="col-md-4 control-label control-label.has-error" for="email">e-mail</label>
  <div class="col-md-5">
  <div class="required-field-block">
    <input type="email" id="email" name="email" placeholder="e-mail" class="form-control input-md" 
    	required size="40" value="<?php echo $_SESSION['email'] ; ?>" >
             <div class="required-icon">
                <div class="text">*</div>
            </div>
   </div>
<span class="help-inline"><?php echo $emailMsg; ?></span>
  </div>
</div>

<!-- Password & Confirmation -->
 <div class="form-group <?php echo $passwordErr ; ?>">
    <label for="Password" class="col-md-4 control-label control-label.has-error">*Password</label>
    <div class="col-md-5">
	  
      <input name="password" type="password" data-minlength="4" class="form-control" id="Password" 
      	placeholder="password" value="<?php echo $_SESSION['user_pw'];?>">
          
    </div>
<div class=" <?php echo $passwordErr ; ?>">    
    <label for="passwordconfirm" class="col-md-4 control-label control-label.has-error">*Confirm</label>
    <div class="col-md-5">
	  
      <input name="passwordconfirm" type="password" class="form-control" id="passwordconfirm" 
      	data-match="#password" data-match-error="Whoops, these don't match" placeholder="re-enter password" 
      	value="<?php echo $_SESSION['passwordconfirm'];?>">
      <div class="help-block"><small>*If these fields are not entered then the password will remain unchanged</small></div>
    
    </div>
</div>
  	<div class="col-md-3"><span class="help-inline"><?php echo $passwordMsg; ?></span></div>
</div>

<!-- Button -->
<div class="col-md-10">
<div class="form-group ">
  <div class="controls ">
    <button type="submit" id="save" name="save" value="profile" class="btn btn-primary pull-right">Save</button>
  </div>
</div>
</div>

</fieldset>

</form>
<?php
/*
 * */
//var_dump($_SESSION);
unset($_SESSION['ok']); 
$_SESSION['editusername']	=	"";
$_SESSION['editfullname']	=	"";
$_SESSION['editpublishername']	=	"";
$_SESSION['editemail']		=	"";
$_SESSION['editactive']			=	"";
$_SESSION['editaccess']			=	"";
$_SESSION['editpassword']		=	"";
$_SESSION['editpasswordconfirm']=	"";
$_SESSION['err']		=	"";
?>	
								</div>
							</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
function displayMessage()	{
	if(isset($_SESSION['msg'])) {
		$rtn = '<div class="row" style="background-color:#f3be22; margin-left:10%; margin-right:10%;border-radius:10px;">
					<a href=?reset=1>
						<span class="glyphicon glyphicon-remove-circle orange pull-right"	title="reset" style="font-size: 20px; text-shadow: black 0px 1px 1px; padding:10px;"></span>
					</a>';
		$rtn .=  '<h5 class="text-center ">';
		
		foreach($_SESSION['msg'] as $msg) {
			$rtn .= $msg.'<br>';			
		}
		$rtn .=	'</strong></h5></div>';
		unset($_SESSION['msg']);
		return $rtn;
	}
}
?>		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./js/bootstrap.min.js"></script>
<script src="./js/jquery.bootstrap-touchspin.min.js"></script>
<script>
$(function() {
    $('.required-icon').tooltip({
        placement: 'left',
        title: 'Required field'
        });
});
</script>