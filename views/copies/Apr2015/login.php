<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Irish Interest - Login</title>
	<link rel="icon" type="image/png" href="../favicon.png" />

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>				<!-- ??? -->
  </head>
 <body role="document">
<div class="row voffset5" >
	<div class="col-md-7">
		<a href='../'> 
			<img alt="" src="../homepagebackground-150.png" class="image-responsive">
		</a>
	</div>
	<div class="col-md-5 primaryMenu">
		<div class="col-md-2" style="font-size: 16px;">
			<a href="../login/&register=register">Join </a>
		</div>
		<div class="col-md-4" style="font-size: 16px;">
			<a href="../login/">Sign in</a>
		</div>
		<div class="col-md-6">
			<div class="col-md-10 btn-custom text-center" style="border: 0px solid; border-radius: 10px; line-height: 2; font-weight: 900; font-size: 14px; font: Impact, Charcoal, sans-serif;">
				<a href="../login/"">PUBLISHER'S AREA</a>
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
<img alt="" src="../images/bookshop01.jpeg" style="max-height: 350px; width: 100%" class="image-responsive">

<div class="col-md-1 col-xs-12 col-sm-1"></div>
<div class="col-md-10 col-sm-10 col-xs-12 signon-panel" > 
	<div class="container-fluid" style="border-radius: 4px">
		<div class="container-pad" id="property-listings" style="background-color: #f3be22; border: 0px solid; border-radius: 25px">
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 ">
  <?php 
if(isset($_POST['register']) && ($_POST['register']	==	'save'))	{
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
}	
if(($login 	==	'register')		// login - value received from the controller	
  ||   (isset($_POST['register']) && ($_POST['register']	==	'save')))	{
  	
	if($_SESSION['ok']	===	false)	{
	//	echo ' ?>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="alert alert-danger">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
    							   	<strong>An error occurred</strong> and your information was not saved. 
    							   				Please correct the errors below and try again.
    						</div>
    					</div>
    					<div class="col-md-3"></div>
    				</div>
    		<?php //';
}

	elseif($_POST['register']	==	'save')	{	?>
					<div class="row">
						<div class="col-md-3"></div>
					  	<div class="col-md-5">
							<div class="alert alert-success" style="border-radius:25px">
			        			<a href="#" class="close" data-dismiss="alert">&times;</a>
								<div class="col-sx-8 text-center">
			        				<p>Your request has been received and an activation code has been sent to your email address.</p>
				        			<p>Please check your email for instructions on how to proceed</p> 
					         		<p><a  href="../">  Click here to return to Books  </a></p>
   		     					</div> 
	  						</div>
	  						<div class="col-md-3"></div>
    	  				</div>
    				</div>
    		
<?php }
  }
if( (($login 	==	'register') && ($_SESSION['ok']	<> true)) 
	|| (($_POST['register'] == 'save') && ($_SESSION['ok'] === false)) ) {
		if(isset($_SESSION['userType'])) {
			$publisherCheck 			= $_SESSION['userType'] == 'publisher' 			? 'checked' 	:	''; 
			$promoterCheck 			= $_SESSION['userType'] == 'promoter' 			? 'checked' 	:	''; 
			$correspondentCheck 	= $_SESSION['userType'] == 'correspondent' 	? 'checked' 	:	'';
		} 
		else {
			$publisherCheck			='';
			$promoterCheck				='';
			$correspondentCheck		='checked';		// default
		}
		?>
					<!-- Publisher Registration Form -->
					<form role="form" method="post" class="form-horizontal" >
						<fieldset>
  							<div class="col-md-2"></div>
  							<div class="col-md-8">
   								 <div class="well well-sm" style="border-radius:25px"><h4  class="text-center">Thank You for Registering with Irish Interest </h4><br/>
   								<p class="text-center">Please complete and submit the form below. You will shortly receive an email with instructions on 
									how to activate your account.</p>

								<!-- First Name-->
									<div class="form-group <?php echo $firstnameErr ; ?>">
  										<label class="col-md-4 control-label control-label.has-error" for="firstname">First Name</label>
  											<div class="col-md-4">
 												 	<div class="required-field-block">
												    	<input id="firstname" name="firstname" placeholder="first name" class="form-control input-md" required type="text"
														    	 value="<?php echo $_SESSION['firstname'] ; ?>" >
      											      	<div class="required-icon">
       												         <div class="text">*</div>
          											  	</div>
   													</div>
  											</div>
  											<div class="help-inline col-md-4"><?php echo $firstnameMsg; ?></div>
									</div>

									<!-- Last name -->
									<div class=" form-group <?php echo $lastnameErr ; ?>">
  										<label class="col-md-4 control-label control-label.has-error" for="lastname">Last Name</label>
 											  <div class="col-md-4">
												 <div class="required-field-block">
													    <input id="lastname" name="lastname" placeholder="last Name" class="form-control input-md" required type="text"
   																 value="<?php echo $_SESSION['lastname'] ; ?>" >
      											      	<div class="required-icon">
     										           		<div class="text">*</div>
            											</div>
  												</div>
 												<span class="help-inline"><?php echo $lastnameMsg; ?></span>
  											</div>
 											 <div class="col-md-4"></div>
										</div>

										<!-- Publisher -->
										<div class="form-group <?php echo $publishernameErr ; ?>">
  											<label class="col-md-4 control-label control-label.has-error" for="publishername">Company Name</label>
											<div class="col-md-4">
  												<div class="input-group " >
    												<input id="publishername" name="publishername" placeholder="company" class="form-control input-md" 
   														  type="text" value="<?php echo $_SESSION['publishername'] ; ?>" >
													<span class="help-inline"><?php echo $publishernameMsg; ?></span>
													<div class="input-group-btn">
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
															name="publishers" id="publishers" >
															<span class="caret">	</span>
														</button>
														<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu">
<?php 
foreach($_SESSION['publisherNames'] as $idx=>$publisherName)	{
	echo '<li> <a tabindex="-1" href="#">'.$publisherName.'</a></li>';
}
?>
														</ul>
													</div>  
  												</div>
  											</div>
										</div>
<script>
$(function(){
	  
	  $(".dropdown-menu li a").click(function(){
		document.getElementById('publishername').value = $(this).text();
	  });

	});
</script>

										<!-- Telephone -->
										<div class="form-group <?php echo $telephoneErr ; ?>">
  											<label class="col-md-4 control-label control-label.has-error" for="telepohone">Telephone</label>
  											<div class="col-md-4">
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
  										<div class="col-md-4">
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
  										<label class="col-md-4 control-label control-label.has-error" for="email">Enter e-mail address</label>
  										<div class="col-md-4">
  											<div class="required-field-block">
    											<input type="email" id="email" name="email" placeholder="your e-mail address" class="form-control input-md" 
    													required size="40" value="<?php echo $_SESSION['email'] ; ?>" >
          										<div class="required-icon">
                									<div class="text">*</div>
            									</div>
   											</div>
  											</div><span class="help-inline col-md-4"><?php echo $emailMsg; ?></span>
 									</div>

									<!-- confirm mEMail -->
									<div class="form-group  <?php echo $emailErr ; ?>">
  										<label class="col-md-4 control-label control-label.has-error" for="confirmemail">Confirm e-mail address</label>
  										<div class="col-md-4">
  											<div class="required-field-block">
    											<input type="email" id="confirmemail" name="confirmemail" placeholder="confirm your e-mail address" class="form-control input-md" 
    													required size="40" value="<?php echo $_SESSION['confirmemail'] ; ?>" >
          										<div class="required-icon">
                									<div class="text">*</div>
            									</div>
   											</div>
  										</div>
  									<span class="help-inline col-md-4"><?php echo $confirmEmailMsg; ?></span>
 								</div>
								<!--  Password -->
								<div class="form-group  <?php echo $passwordErr ; ?>">
  									<label class="col-md-4 control-label control-label.has-error" for="password">Choose a Password</label>
  									<div class="col-md-4">
  										<div class="required-field-block">
    										<input type="password" id="password" name="password" placeholder="password" class="form-control input-md" 
    											required size="40" value="<?php echo $_SESSION['password'] ; ?>" >
          									<div class="required-icon">
                								<div class="text">*</div>
            								</div>
   										</div>
										<span class="help-inline"><?php echo $passwordMsg; ?></span>
  									</div>
  									<div class="col-md-4">
 										<span class="help-inline"><?php echo '<p><i><small><strong>Minimum 4 Characters. </strong></small></i></p>'; ?></span>
  									</div>
								</div>
 
								<!-- Confirm -->
								<div class="form-group  <?php echo $confirmErr ; ?>">
  								<label class="col-md-4 control-label control-label.has-error" for="confirm">Confirm Password</label>
  								<div class="col-md-4">
  									<div class="required-field-block">
    									<input type="password" id="confirm" name="confirm" placeholder="confirm password" class="form-control input-md" 
    											required size="40" value="<?php echo $_SESSION['confirm'] ; ?>" >
         								<div class="required-icon">
                							<div class="text">*</div>
            							</div>
  									</div>
 									<span class="help-inline"><?php echo $confirmMsg; ?></span>
  								</div>
  								<div class="col-md-4">
 									<span class="help-inline"><?php echo '<p><i><small>We recommend you use a combination of letters and numbers.</small></i></p>'; ?></span>
  								</div>
							</div>
								<!-- Registration Option - Publisher/Author, Event Manager, Correspondent -->
								<div class="form-group  <?php echo $optionErr ; ?>">
  								<label class="col-md-4 control-label control-label.has-error" for="options">I want to register as a</label>
  								<div class="col-md-8">
     								<div class="radio">
      									<label><input type="radio" name="usertype" value="publisher" <?php echo $publisherCheck;?>>Publisher - <small>add/edit books for my Publishing Company</small></label>
    								</div>
          							<div class="radio">
            							<label><input type="radio" name="usertype" value="promoter" <?php echo $promoterCheck;?>>Promoter - <small>manage Events</small></label>
          							</div>
          							<div class="radio disabled">
            							<label><input type="radio" name="usertype" value = "correspondent" <?php echo $correspondentCheck;?> >Correspondent - <small>receive notifications, contribute to our forum</small></label>
          							</div>
  								</div>
						</div>

							<!-- Button -->
							<div class="form-group">
  								<label class="col-md-4 control-label" for="register"></label>
   								<div class="col-md-4 text-center">
  									<div class="controls">
    									<button type="submit" id="register" name="register" value="save" class="btn btn-primary">Submit</button>
  									</div>
  								</div>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
		<div class="col-md-3"></div>
		<div class="col-md-6">
    		<div class="well well-sm" style="border-radius:25px">
				<div class="text-center">Information entered here will not be shared, sold or redistributed 
   									in any way. All personal information is treated as strictly private and confidential.
   				</div>
			</div>
		</div>
	</div>	
	</div>
</div>
<?php
}
elseif(isset($_GET['forgot_reset']))	{
	if($_SESSION['ok']	===	false)	{
		$passwordErr	= 'has-error';
		$passwordMsg	=	$_SESSION['err']['msg'][0];		
?>
<?php	
	foreach($_SESSION['err']['field'] as $idx => $field)	{	
			switch ($field)	{
			case 'password':
				$passwordErr	=	"has-error";
				$passwordMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			}
		}
	}
	?>
<div class="form-signin-heading row text-center">
	<div class="col-md-6 voffset7 bvoffset5">
    	<h3>Enter a new Password</h3>
	</div>
</div>

<form role="form" class="form-signin" method="post">
<fieldset>	
<!-- Forgot Password / Password Reset Form -->
<!--  Password -->
<div class="form-group  <?php echo $passwordErr ; ?>">
 <div class="row">
  <label class="col-md-2 control-label control-label.has-error" for="password">Enter Password</label>
  <div class="col-md-6">
  	<div class="required-field-block">
    	<input type="password" id="password" name="password" placeholder="password" class="form-control input-md" 
    	autofocus required size="40" value="<?php echo $_SESSION['password'] ; ?>" >
          <div class="required-icon">
                <div class="text">*</div>
            </div>
   	</div>
	<span class="help-inline"><?php echo $passwordMsg; ?></span>
  </div>
 <span class="help-inline"><?php echo '<p><i><small><strong>We recommend you use a combination of letters and numbers.</strong></small></i></p>'; ?></span>
 </div>
</div>
<!-- Confirm -->
<div class="form-group  <?php echo $confirmErr ; ?>">
 <div class="row">
  <label class="col-md-2 control-label control-label.has-error" for="confirm">Verify</label>
  <div class="col-md-6">
  <div class="required-field-block">
    <input type="password" id="confirm" name="confirm" placeholder="confirm password" class="form-control input-md" 
    	required size="40" value="<?php echo $_SESSION['confirm'] ; ?>" >
         <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
 <span class="help-inline"><?php echo $confirmMsg; ?></span>
  </div>
 </div>
</div>
<div class="row">
   	<div class="col-md-2"></div>
	<div class="col-md-6 text-center">	
		<button name="update_password" class="btn btn-md btn-primary" size="10" type="submit">Apply</button>
	</div>
    <div class="col-md-3"></div>
</div>
</fieldset>
<div class="row" style="padding-top:20px">
	<div class="col-md-2"></div>
	<div class="col-md-6">
   		<p class="text-center">Please complete and submit the form to continue.</p>
   	</div>
</div>
</form>
<?php 	
	if($_SESSION['ok']	===	true)	{	?>
		<div class="row">
		  <div class="col-md-3"></div>
		  <div class="col-md-5">
			<div class="alert alert-success text-center" style="border-radius:25px">
        		<a href="#" class="close" data-dismiss="alert">&times;</a>
        			<strong>Success!</strong> Your password has been updated</p> 
        			<p>Login to continue</p> 
        		<p><a  href="../"> click here to Return to Books  </a></p>
    		</div>
    	   </div>
    	  </div>
<?php 	}
	elseif($_SESSION['ok']	===	false)	{
		$passwordErr	= 'has-error';
		$passwordMsg	=	$_SESSION['err']['msg'][0];		
?>
		<div class="row">
		  <div class="col-md-3"></div>
		  <div class="col-md-5">
			<div class="alert alert-warning" style="border-radius:25px">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
        	<strong>An error occurred!</strong> Your information was not saved - please correct the errors above and try again.
    		</div>
    	  </div>
		</div>    
	<?php 
	}
}
elseif( ($_GET['forgot']	==	'password')	||	($_GET['forgot']	==	'submit') ) { 
	if($_SESSION['ok']	===	false)	{	
		foreach($_SESSION['err']['field'] as $idx => $field)	{	
			switch ($field)	{
			case 'email':
				$emailErr	=	"has-error";
				$emailMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			}
		}
 	}
	?>
<!-- Forgot Password Form -->
<div class="form-signin-heading row text-center">
	<div class="col-md-6 voffset7 bvoffset5">
    	<h3>Reset Password</h3>
	</div>
</div>
<!-- EMail -->
<form role="form" class="form-signin">
<div class="form-group  <?php echo $emailErr ; ?>">
	<div class="row">
  		<label class="col-md-2 control-label control-label.has-error" for="email">E-mail Address</label>
  		<div class="col-md-6">
  				<div class="required-field-block">
    				<input type="email" id="email" name="email" placeholder="your e-mail address" class="form-control input-md" 
    					autofocus required size="40" value="<?php echo $_SESSION['email'] ; ?>" >
           			<div class="required-icon">
                		<div class="text">*</div>
            		</div>
  				</div>
  				<span class="help-inline"><?php echo $emailMsg; ?></span>
  		</div><div class="col-md-4"></div>
  	</div>
  </div>
<!-- Submit button  -->
<div class="row" style="padding-top:20px">
	<div class="col-md-2"></div>
		<div class="col-md-6 text-center">	
			<button type="submit" id="forgot" name="forgot" size="10" value="submit" class="btn btn-md btn-primary">Submit</button>  
    	</div>
</div>

</form>
<div class="row"><div class="col-md-3"></div><div class="col-md-5">
	<p class="text-center"> Enter your e-mail address and submit the form. You will receive a message with an activation link.</p>
</div></div>
<?php
	if($_SESSION['ok']	===	true)	{	?>
		<div class="row">
		  <div class="col-md-3"></div>
		  <div class="col-md-5">
			<div class="alert alert-success text-center" style="border-radius:25px">
        		<a href="#" class="close" data-dismiss="alert">&times;</a>
        			Your request has been received and an activation code has been issued.</p> 
        			<p>Please check your email for instructions on how to proceed.</p> 
        			<p><a  href="../"> click here to Return to Books  </a></p>
        	</div> 
    	   </div>
    	  </div>
<?php 	
	}
	elseif($_SESSION['ok']	===	false)
		{	?>
		<div class="row">
		  <div class="col-md-3"></div>
		  <div class="col-md-5">
			<div class="alert alert-warning text-center" style="border-radius:25px">

			<a href="#" class="close" data-dismiss="alert">&times;</a>

        	<strong>An error occurred.</strong> Your request could not be processed. Please correct the error above and try again.

    		</div>
    	  </div>
    	</div>
<?php 
		}



}
else	{
	/*
	 * 	check for Activation attempt & Success or Fail ...
	 */
	if($_SESSION['activated']			===		true)	{
		?>
		<div class="col-md-3"></div>
		<div class="col-md-6 text-center">
		<div class="well well-sm " style="border-radius:25px">
		<p>Hello <?php echo $_SESSION['userFirstName'];?>, and Welcome to the Irish Interest Publisher database!<br></p>
		<p>Your account with Irish Interest is now Active and you may add and amend books in our database.
		</p><p>To Login, please use the email address and password you gave when Registering.</p>
		</div></div>
<?php }
	elseif($_SESSION['activateFail']	=== 	true)	{	?>
		<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="alert alert-warning" style="border-radius:25px">
					<p >Your Account activation request failed with the message --</p>
					<p class="text-center text-danger"><?php echo $_SESSION['err']['msg'][0];?> </p>
					<p>This means that the account is either already active, or your e-mail address has not yet been registered with us.</p>
					<p>To sign up, use the <b>Register</b> menu option or use the <b>forgot password</b> link below to 
						request a password reset.</p>
				</div>
			</div>
<?php 	}
	if($_SESSION['ok']	===	false)		{
		$loginErr		=	"has-error";
		$loginMsg		=	$_SESSION['err']['msg'];
		$passwordErr	=	"has-error";
		$passwordMsg	=	$_SESSION['err']['msg'];
		
	}
	?>
         <div class="form-signin-heading row text-center">
         <div class="voffset7 bvoffset5">
         <h3><p>Sign In to Irish Interest<p></h3>
         </div>
         </div>
     <form class="form-signin" role="form" method="post">

		  <div class="form-group  <?php echo $loginErr ; ?>">
		   <div class="row">
	    	<label class="col-md-3 control-label control-label.has-error" for="login">E-mail Address</label>
			<div class="col-md-6">
            	<div class="required-field-block">
        			<input type="email" class="input-md form-control" placeholder="e-mail" required 
        				autofocus name="login" size="20" value="<?php 
        					echo (isset($_POST['login'])) ? $_POST['login'] : $_SESSION['userEmail']; ?>"><br>
          			<div class="required-icon">
                		<div class="text">*</div>
            		</div>
        		</div>
        	</div>
        	<div class="col-md-4"><span class="help-inline"><?php echo $loginMsg; ?></span></div>
           </div>
          </div>
		

		<div class="form-group  <?php echo $passwordErr ; ?>">
          <div class="row">
	    	<div class="col-md-3">
	    		<label class="control-label control-label.has-error" for="password">Password</label>
	    	</div>
	    
        	<div class="col-md-6">
      	     <div class="required-field-block">
         		<input type="password" class="input-md form-control" placeholder="Password" required name="password" size="8" ><br>
		          <div class="required-icon">
        	        <div class="text">*</div>
            	  </div>
        	 </div>
        	</div>
        	<div class="col-md-4"></div>
           </div>
        </div>
        <div class="row">
        	<div class="col-md-3"></div>
        	<div class="col-md-6 text-center">	
        		<button name="Submit" class="btn btn-md btn-primary" size="10" type="submit">Login</button>
        	</div>
        	<div class="col-md-4"></div>
        </div>
      </form>
      <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 text-center"><a  href="?forgot=password"> forgotten password</a></div>
      </div>
<?php
	if($_SESSION['ok']	===	false)	{
		echo '
			<div class="col-md-3"></div><div class="col-md-5"><div class="alert alert-warning text-center" style="border-radius:25px">

			<a href="#" class="close" data-dismiss="alert">&times;</a>

        	<strong>E-mail address and Password combination is not valid. Please try again.

    		</div></div><div class="col-md-4"></div>';
		}
/* SESSION vars ...
 * 
 * Register	 
 * */
$_SESSION['firstname']		=	"";
$_SESSION['lastname']		=	"";
$_SESSION['publishername']	=	"";
$_SESSION['email']			=	"";
$_SESSION['confirmemail']			=	"";
$_SESSION['telephone']		=	"";
$_SESSION['position']		=	"";
$_SESSION['password']		=	"";
$_SESSION['confirm']		=	"";
$_SESSION['err']			=	"";
/* 
 * Forgot		??????????
 * */
$_SESSION['username']		=	"";
/* 
 * Login		?????????	
 * */
$_SESSION['fullname']		=	"";
$_SESSION['publishername']	=	"";
$_SESSION['err']			=	"";

}
unset($_SESSION['ok']); 
unset($_SESSION['activated']);
unset($_SESSION['activateFail']);	
	?>
    </div> <!-- /container -->
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
	
<script>
$(function() {
    $('.required-icon').tooltip({
        placement: 'left',
        title: 'Required field'
        });
});
</script>    
<script>
function choosePublisher(data)
{
   document.getElementById("publishername").value = data.value;
}</script>
</body>
</html>