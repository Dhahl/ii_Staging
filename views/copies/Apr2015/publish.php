<html lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Irish Interest - Publisher</title>
	<link rel="icon" type="image/png" href="../publish_favicon/favicon.png" />

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="../css/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

 	<!-- Style.css -->
    <link href="../css/style.css" rel="stylesheet">

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
$hdg	=	"";
if(!$_SESSION['userPublisher']	==	"")	{
	$hdg	.=	$_SESSION['userPublisher'];
}
else	{
	$hdg	.=	$_SESSION['userFirstName'].' '.$_SESSION['userLastName'];
}

 $userMenu = 'PUBLISHER AREA';
 if($_SESSION['accessLevel']		=='10')	{
  	$userMenu =	'
  	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">'.$_SESSION['user'].'</a>
  	  	<ul class="dropdown-menu" style="text-align:left">
		  	<li><a href="../admin/">Administration</a></li>
  			<li><a href="publish/">Edit Books</a></li>
  			<li><a href="../logout">Sign Out</a></li>
  			<li><a href="../profile">Profile</a></li>
  			</ul>';
  
  }
 if( ($_SESSION['accessLevel']		=='1')
   || ($_SESSION['access_level']		== '2'	) )	{
  	$userMenu =	'
  	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">'.$_SESSION['user'].'</a>
  	  	<ul class="dropdown-menu" style="text-align:left">
  			<li><a href="publish/">Edit Books</a></li>
  			<li><a href="../profile">Profile</a></li>
  			<li><a href="../logout">Sign Out</a></li>
  			</ul>';
  }
 if($_SESSION['accessLevel']		=='3')	{
  	$userMenu =	'
  	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">'.$_SESSION['user'].'</a>
			<ul class="dropdown-menu" style="text-align:left">
  				<li><a href="../logout">Sign Out</a></li>
  			</ul>';
  }
?>    
<div class="row voffset2" >
	<div class="col-md-7">
		<a href='../'> 
			<img alt="" src="../homepagebackground-150.png" class="image-responsive">
		</a>
	</div>
	<div class="col-md-5 primaryMenu voffset6">
		<div class="col-md-2" style="font-size: 16px;">
			
		</div>
		<div class="col-md-4" style="font-size: 16px;">
			
		</div>
		<div class="col-md-6">
			<div class="col-md-10 btn-custom text-center" style="border: 0px solid; border-radius: 10px; line-height: 2; font-weight: 900; font-size: 14px; font: Impact, Charcoal, sans-serif;">
				<?php echo $userMenu; ?>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</div>
<!-- Fixed navbar -->
<div class="navbar " role="navigation" style="margin: 0px; min-height: 0px; border: 0px; padding: 0px">
	<div class="navbar-header" style="width:70%; ">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
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
    
<div class="container  greenlinks" >

<?php
/*
 * 	Edit user profile form
 */ 
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

if( (isset($_GET['edit'])) && ($_GET['edit']	==	'profile') 
	||  (isset($_GET['save'])	&&	($_GET['save']	==	'profile') ) ) 	{
?>
<!-- form -->
<div class="col-md-2"></div>
<div class="col-md-8" >
 <div class="panel panel-success" style="border-radius:10px; padding:0px; margin:0px">
  <div class="panel-heading text-center" style="border-top-left-radius:10px; border-top-right-radius:10px">Amend Profile details</div>
  <div class="panel-body" style="padding:0px; margin:0px">
   <div class="well well-sm" style="padding:0px; margin:0px;border-bottom-left-radius:10px; border-bottom-right-radius:10px;">
<?php 
	if($_SESSION['ok']	=== false)	{
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
	<div class="alert alert-danger">

        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <strong>An error occurred!</strong> Your information was not saved - please correct the errors below and try again.

    </div>
<?php 
	}
	elseif($_SESSION['ok']	=== true)	{
		$message	=	$_SESSION['err']['msg'][0];
		$message 	.=	'<a href=./> Back to books...</a>'
?>
	<div class="alert alert-success">

        <a href="#" class="close" data-dismiss="alert">&times;</a><?php echo $message;?></div>
<?php 			
		}
?> 
<form role="form" method="post" class="form-horizontal" >

<fieldset>


<!-- first Name-->
<div class="form-group <?php echo $firstnameErr ; ?>" style="padding-top:50px";>
  <label class="col-md-4 control-label control-label.has-error" for="firstname">First Name</label>
  <div class="col-md-4">
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
   <div class="col-md-4">
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
  <div class="col-md-4">
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
  <label class="col-md-4 control-label control-label.has-error" for="email">e-mail</label>
  <div class="col-md-4">
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
    <div class="col-md-4">
	  
      <input name="password" type="password" data-minlength="4" class="form-control" id="Password" 
      	placeholder="password" value="<?php echo $_SESSION['user_pw'];?>">
          
    </div>
  	<span class="help-inline"><?php echo $passwordMsg; ?></span>
</div>
<div class="form-group <?php echo $passwordErr ; ?>">    
    <label for="passwordconfirm" class="col-md-4 control-label control-label.has-error">*Confirm</label>
    <div class="col-md-4">
	  
      <input name="passwordconfirm" type="password" class="form-control" id="passwordconfirm" 
      	data-match="#password" data-match-error="Whoops, these don't match" placeholder="re-enter password" 
      	value="<?php echo $_SESSION['passwordconfirm'];?>">
      <div class="help-block"><small>*If these fields are not entered then the password will remain unchanged</small></div>
    
    </div>
</div>

<!-- Button -->
<div class="col-md-3">
<div class="form-group pull-right">
  <div class="controls ">
    <button type="submit" id="save" name="save" value="profile" class="btn btn-primary">Save</button>
  </div>
</div>
</div>

</fieldset>

</form>
</div><!-- Well -->
</div>
</div></div>
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
	
}	
else	{

?>
     
 <div class="">
	<div class="col-md-9" >
<?php
$messageDiv	= ""; 
if($_SESSION['saved'] == true)	{
	foreach($_SESSION['err']['msg'] as $i=>$text)	{
		$message	.=	$text;
	}
	
}
if($_SESSION['deleted'] == true)	{
	foreach($_SESSION['err']['msg'] as $i=>$text)	{
		$message	.=	$text;
	}
}
if( ($_SESSION['saved'] ==	true)	||	($_SESSION['deleted']	== true) )	{
	$messageDiv	=	'<div class="row"><div class="col-md-12 ">
						<div class="alert alert-warning" >
				  			<a href="#" class="close" data-dismiss="alert">&times;</a>'.
					$message.
				 '</div></div></div>';
}
$_SESSION['saved']	='';
$_SESSION['deleted']	='';

if( ($_SESSION['mode']	==	'edit')	||	($_SESSION['ok']	=== false ) )	{ 
	$panelTitle 	=	"Edit";
	$panelDisplay 	= 	'';
//	$panelGlyph 	=	'glyphicon-chevron-up';
}
else {
	$panelTitle	 	= 	"Enter" ;
	if($_SESSION['saved']	===	true)	{
		$panelDisplay 	=	'style="display:none"'; 
//		$panelGlyph 	=	'glyphicon-chevron-down';
		}
		else	{
			$panelDisplay 	= 	'';
//			$panelGlyph 	=	'glyphicon-chevron-up';
		}
	}
	?>
<!-- Book Details Form ***Start*** -->      
		<div class="panel panel-success" style="border-radius:10px"; >
			<div class="panel-heading" style="border-top-left-radius:10px; border-top-right-radius:10px">
				<div class="panel-title "><?php echo $panelTitle ;?> Book details <span class="pull-right"><?php echo $hdg;?></span>
				</div>
			</div>
 			<div class="panel-body"  style="padding:0px; margin:0px"<?php echo $panelDisplay;?> >
			   <div class="well well-sm" style="padding:0px; margin:0px;border-bottom-left-radius:10px; border-bottom-right-radius:10px;">
 			
			<?php echo $messageDiv;?>
				<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
					<fieldset>
<?php 
//var_dump($_SESSION);
//die;
$titleErr	=	'';
$titlemsg 	=	'';
$authorErr	=	'';
$authorMsg 	=	'';
$publishedErr	=	'';
$publishedMsg 	=	'';
$areaErr	=	'';
$areaMsg 	=	'';
$synopsisErr	=	'';
$synopsisMsg 	=	'';
$imageErr	=	'';
$imageMsg 	=	'';
//var_dump($_SESSION);
//die;
if($_SESSION['ok']	===	false)	{
	echo '<div class="row"><div class="col-md-2"></div><div class="col-md-9">
	<div class="alert alert-danger" style="border-radius:25px" >

        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <p>An error occurred and your information was not saved. Please correct the errors below and try again.</p>

    </div></div></div>';
	
	foreach($_SESSION['err']['field'] as $idx => $field)	{	
		switch ($field)	{
			case 'title':
				$titleErr	=	"has-error";
				$titleMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'author':
				$authorErr	=	"has-error";
				$authorMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'published':
				$publishedErr	=	"has-error";
				$publishedMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'genre':
				$genreErr	=	"has-error";
				$genreMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'area':
				$areaErr	=	"has-error";
				$areaMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'synopsis':
				$synopsisErr	=	"has-error";
				$synopsisMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'publisherurl':
				$publisherUrlErr	=	"has-error";
				$publisherUrlMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'vendorurl':
				$vendorUrlErr	=	"has-error";
				$vendorUrlMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
			case 'linkurl':
				$linkUrlErr	=	"has-error";
				$linkUrlMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
				
			case 'image':
				$imageErr	=	"has-error";
				$imageMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
		}
	}
}
?>

<!-- Title -->	
<div class="form-group <?php echo $titleErr ; ?>" style="padding-top:25px; padding-right:25px">
  <label class="col-md-2 control-label control-label.has-error" for="title">Title</label>  
  <div class="col-md-10 col-xs-10">
  <div class="required-field-block">
  <input id="title" name="title" placeholder="..." class="form-control input-md" type="text" 
  	value="<?php echo $_SESSION['title'] ; ?>">
            <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
  <span class="help-inline"><?php echo $titleMsg; ?></span>
  </div>
</div>
<!-- Author -->	
<div class="form-group <?php echo $authorErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 control-label" for="author">Author(s)</label>  
  <div class="col-md-10 col-xs-10">
  <div class="required-field-block">
  <input id="author" name="author" placeholder="...name or names" class="form-control input-md" type="text"
  	value="<?php echo $_SESSION['author'] ; ?>">
            <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
  <span class="help-inline"><?php echo $authorMsg; ?></span>
  </div>
</div>

<!-- Synopsis -->
<div class="form-group <?php echo $synopsisErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 control-label" for="synopsis">Synopsis</label>
  <div class="col-md-10 col-xs-10">                     
  <div class="required-field-block">
    <textarea class="form-control" id="synopsis" name="synopsis" placeholder="... a brief description of the book">
<?php echo $_SESSION['synopsis'] ; ?></textarea>
            <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
  <span class="help-inline"><?php echo $synopsisMsg; ?></span>
  </div>
</div>

<!-- Area -->
<div class="form-group <?php echo $areaErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 control-label" for="area"> Area</label>  
  <div class="col-md-10 col-xs-10">
  <div class="required-field-block">
  <input id="area" name="area" placeholder="...region, County, Town ..." class="form-control input-md" type="text"
  	value="<?php echo $_SESSION['area'] ; ?>">
            <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
  <span class="help-inline"><?php echo $areaMsg; ?></span>
  </div>
</div>

<!-- Genre -->	
<div class="form-group <?php echo $genreErr ; ?>" style="padding-right:25px"> 
  <label class="col-md-2 control-label" for="genre">Genre</label>  
  <div class="col-md-10 col-xs-10">
  <div class="required-field-block">
  <input id="genre" name="genre" placeholder="...fiction, culture, biography," class="form-control input-md" type="text"
  	value="<?php echo $_SESSION['genre'] ; ?>">
            <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
  <span class="help-inline"><?php echo $genreMsg; ?></span>
  </div>
</div>
<?php
if($_SESSION['published']	!=	'')	{
	$arr_published 	=	 date_parse($_SESSION['published']);
	}
else	{
	$arr_published 	=	 date_parse(date("Y-m-d"));
	}

$day	=	$arr_published['day'];
$month	=	$arr_published['month'];
$selMonth =	array();
$selmonth[$month]	=	"selected";
$year	=	$arr_published['year'];
$currentDate = date_parse(date("Y-m-d"));
$thisYear=$currentDate['year'];
?> 
<!--  New Date --->
<div class="form-group <?php echo $publishedErr ; ?>" style="padding-right:25px"> 
  	<label class="control-label col-xs-2" for="date">Published	 </label> 
	<div class="col-md-5 col-xs-12 col-sm-12"><!--  -->
	  <div class="col-md-2 col-xs-3 col-sm-1" style="padding:0; margin:0"> <!-- day -->
   		<input id="day" type="text" value="<?php echo $day;?>"  name="day" class="form-control input-md"  style="padding:2; margin:0">
     </div>
      <div class="col-md-4 col-xs-4 col-sm-2" style="padding:0; margin:0"> <!--  month -->
      	<select name="month" style="padding-top:8; padding-bottom:8; padding-right:0px; margin:0" value="<?php echo $month; ?>">
      	<option <?php echo $selmonth[1];?>>January</option>
      	<option <?php echo $selmonth[2];?>>February</option>
      	<option <?php echo $selmonth[3];?>>March</option>
      	<option <?php echo $selmonth[4];?>>April</option>
      	<option <?php echo $selmonth[5];?>>May</option>
      	<option <?php echo $selmonth[6];?>>June</option>
      	<option <?php echo $selmonth[7];?>>July</option>
      	<option <?php echo $selmonth[8];?>>August</option>
      	<option <?php echo $selmonth[9];?>>September</option>
      	<option <?php echo $selmonth[10];?>>October</option>
      	<option <?php echo $selmonth[11];?>>November</option>
      	<option <?php echo $selmonth[12];?>>December</option>
      	</select>
      </div>
      <div class="col-md-4 col-xs-4 col-sm-2" style="padding-left:0; margin:0; margin-left:-9"> <!--  year -->
        <input id="year" type="text" value="<?php echo $year;?>"  name="year" style="padding:4; margin-left:-1" 
        	data-max="<?php echo 2100; //$thisYear;?>">
    </div>

   </div>
<!-- Language -->
	<div class="col-md-5 col-xs-10 col-sm-12">
  		<label class="col-md-3 control-label" for="language"  >Language</label>
  		<div class="col-md-9" style="padding-right:0px">
    		<input id="Language" name="language" placeholder="English, Irish, ..." class="form-control input-md"
    			value="<?php echo $_SESSION['language'];?>" type="text" >
  		</div>
	</div>
</div>
   	<div class="col-md-2"></div><span class="help-inline col-md-10"><?php echo $publishedMsg; ?></span>

<div class="form-group <?php echo $pagesErr ; ?>" style="padding-right:25px"> 

<!--  Pages-->
  	<label class="col-md-2 col-xs-2 control-label" for="pages" >Pages</label>  
	  <div class="col-md-2 col-xs-8">
   		<input id="pages" type="text" value="<?php echo $_SESSION['pages'];?>"  name="pages" class="form-control input-md"  style="padding:4; margin:0">
   	  </div>

<!-- Cover -->
  <div class="col-md-8 col-xs-10" >
  <div class="col-md-12" style="border:1px solid #C0C0C0; border-radius:5px; padding-bottom:5;">
  <div class="controls">
    <label class="checkbox inline col-md-3 small" for="checkboxes-0">
      <input name="hardback" id="hardback" value="1" type="checkbox" <?php echo ($_SESSION['hardback']) ? "checked" : '';?>>
      Hardback
    </label>
    <label class="checkbox inline col-md-3 small" for="checkboxes-1">
      <input name="paperback" id="paperback" value="1" type="checkbox" <?php echo ($_SESSION['paperback']) ? "checked" : '';?>>
     Paperback
    </label>
    <label class="checkbox inline col-md-3 small" for="checkboxes-2">
      <input name="ebook" id="ebook" value="1" type="checkbox" <?php echo ($_SESSION['ebook']) ? "checked" : '';?>>
      e-Book
    </label>
    <label class="checkbox inline col-md-3 small" for="checkboxes-3">
      <input name="audio" id="audio" value="1" type="checkbox" <?php echo ($_SESSION['audio']) ? "checked" : '';?>>
      Audio
    </label>
  </div>
  </div>
  </div>
</div>
<!-- ISBN10 -->	
<div class="form-group <?php echo $isbnErr ; ?>" style="padding-right:25px"> 
  <label class="col-md-2 col-xs-4 control-label" for="isbn">ISBN10</label> 
  <div class="col-md-10 col-xs-10">
  	<div class="col-md-3" style="padding-left:0px">
  		<input id="isbn" name="isbn" placeholder="ISBN10" class="form-control input-md" type="text"
 		 	value="<?php echo $_SESSION['isbn'] ; ?>">
 		 <span class="help-inline"><?php echo $isbnMsg; ?></span>
 	</div>

<!-- ISBN13 -->	
 	 <label class="col-md-2 control-label" for="isbn13">ISBN13</label>  
 	 <div class="col-md-3" style="padding-left:0px">
 		 <input id="isbn13" name="isbn13" placeholder="ISBN13" class="form-control input-md" type="text"
  			value="<?php echo $_SESSION['isbn13'] ; ?>">
  		<span class="help-inline"><?php echo $isbn13Msg; ?></span>
  	 </div>

<!-- ASIN  -->	
  <label class="col-md-1 control-label" for="asin">ASIN</label>  
  	<div class="col-md-3" style="padding-right:0px">
  	 	<input id="asin" name="asin" placeholder="ASIN" class="form-control input-md" type="text"
  			value="<?php echo $_SESSION['asin'] ; ?>">
  		<span class="help-inline"><?php echo $asinMsg; ?></span>
  	</div>
  </div>
</div>

<!-- Publisher -->
<div class="form-group <?php echo $publisherErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 control-label" for="publisher">Publisher</label>  
  <div class="col-md-10 col-xs-10">
  <div class="input-group " >
  	<input id="publisher" name="publisher" placeholder="Publishing house, company name" class="form-control input-md" type="text"
  		value=<?php 
  			if( ($_SESSION['accessLevel']	== '1') && (!$_SESSION['userPublisher']	== ""))	{
		  		echo '"'.$_SESSION['userPublisher'].'"'; 
		  		echo "readonly"; 
		  		$disablePublisherSelect	= "disabled";
		  		if($_SESSION['publisherurl']	== "") $_SESSION['publisherurl'] = $_SESSION['publishers'][$_SESSION['userPublisher']];
		}
	else	echo '"'.$_SESSION['publisher'].'"';
?>>
  	<span class="help-inline"><?php echo $publisherMsg; ?></span>

	<div class="input-group-btn">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
			name="publishers" id="publishers"<?php echo $disablePublisherSelect; ?> >
		<span class="caret" style="height:20px;"></span>
		</button>
		<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu">
<?php 
foreach($_SESSION['publishers'] as $name=>$url)	{
	echo '<li> <a tabindex="-1" href="#">'.$name.'</a></li>';
}
?>
		</ul>
	</div>  <!--  input group button -->
</div>	<!-- input group -->
</div>
<script>
$(function(){
	  
	  $(".dropdown-menu li a").click(function(){
		document.getElementById('publisher').value = $(this).text();
		var name = document.getElementById('publisher').value ;
		var arrPublishers = JSON.parse( '<?php 
			echo json_encode($_SESSION['publishers']);
		?>' );
		document.getElementById('publisherurl').value = arrPublishers[name];
			  });

	});
</script>

<!-- Publisher url -->
<div class="<?php echo $publisherUrlErr; ?>">
  <label class="col-md-2 col-xs-12 control-label" for="publisherurl"> <i>url</i></label>  
  <div class="col-md-10 col-xs-10">
  <input id="publisherurl" name="publisherurl" placeholder="http://www. ..." class="form-control input-md" type="url"
  	value="<?php echo $_SESSION['publisherurl']; ?>">
  <span class="help-inline"><?php echo $publisherUrlMsg ; ?></span>
  </div>
</div>

</div>
<!-- Vendor Name Link Text -->
<div class="form-group <?php echo $vendorErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-xs-12 control-label" for="vendor">Vendor</label>
  <div class="col-md-10 col-xs-10">                     
    <input id="vendor" name="vendor" placeholder="name" class="form-control input-md" type="text"
value="<?php echo $_SESSION['vendor'] ; ?>">
  <span class="help-inline"><?php echo $vendorMsg; ?></span>
  </div>

<!-- Vendor URI -->
<div  class="<?php echo $vendorUrlErr ; ?>">
  <label class="col-md-2 col-xs-12 control-label" for="vendorurl"><i>url</i></label>
  <div class="col-md-10 col-xs-10">                     
    <input id="vendorurl" name="vendorurl" placeholder="http://www. ..." class="form-control input-md"  type="url"
value="<?php echo $_SESSION['vendorurl']; ?>">
  <span class="help-inline"><?php echo $vendorUrlMsg; ?></span>
  </div>
</div>
</div>

<!-- Generic Link Text -->
<div class="form-group <?php echo $linkTextErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-xs-12 control-label" for="linktext"><a href="javascript:void(0)" onclick="triggerInfoModal();">
  <span class="glyphicon glyphicon-info-sign" title="what's this?"></span></a> More Info</label>
  <div class="col-md-10 col-xs-10">                     
    <input id="linktext" name="linktext" placeholder="text entered here will be appended to the book synopsis" class="form-control input-md" type="text"
value="<?php echo $_SESSION['linktext'] ; ?>">
  
  <span class="help-inline"><?php echo $linkTextMsg; ?></span>
  </div>

<!-- Generic URI -->
<div  class="<?php echo $linkUrlErr ; ?>">
  <label class="col-md-2 col-xs-10 control-label" for="linkurl"><i>url</i></label>
  <div class="col-md-10 col-xs-10">                     
    <input id="linkurl" name="linkurl" placeholder="http://www. ..." class="form-control input-md"  type="url"
value="<?php echo $_SESSION['linkurl'] ; ?>">
  <span class="help-inline"><?php echo $linkUrlMsg; ?></span>
  </div>
</div>
</div>

<!-- Image -->	
 <div class="form-group <?php echo $imageErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-xs-12 control-label" for="Image">Image</label>
  <div class="col-md-10 col-xs-10">   
  <?php
  if($_SESSION['mode'] =='edit')	{	
  	$image	=	"../upload/".$_SESSION['image']; ?>
	<div class="col-md-1" style="padding:0";>
		<img src="<?php echo $image;?> " class="img-responsive" width="50" height="80">
	</div> 
<?php  }  ?>                  
     <div class="control-group col-md-4">  
     	 
            <div class="controls" style="padding-bottom:25px; padding-top:25px">  
              <input class="input-file" id="image" name="image" type="file" >  
  				<span class="help-inline" style="color:800000"><?php echo $imageMsg;  ?></span>
            </div>  
     </div>
<!-- Buttons -->	        
  <div class="col-md-6 pull-right">                     
      <button name="save" value="book" type="submit" class="btn btn-info pull-right">Save</button>  
<?php        
$modalBody	=	" Click OK to continue or Cancel";
if($_SESSION['mode']	=='edit')      {	?>
 <!-- DELETE BUTTON	-->
    <button type="button" class="btn btn-danger" onClick="triggerModal('<?php echo $book->id ; ?>')">Delete
    </button> 
 <!-- Cancel -->	        
      <button name="cancel" value="book" type="submit" class="btn btn-default ">Cancel</button>  
    <?php 
    echo '  
    <div id="largeModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h4 class="modal-title">Delete '.$_SESSION['title'].'</h4>
                </div>
  
        <form method="post" id="action_submit" action="./?delete">     
              <div class="modal-body">'.$modalBody.'
                     <input type="hidden" name="titleId" id="the_id" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';?>
                    <button name="delete" type="submit" class="btn btn-success btn-primary" value="<?php echo $_SESSION['bookID'];?>"><?php echo 'OK' ;?></button>
<?php  echo '
                </div>
           </div>
        </div>
    </div>
</form>';
?>
  </div>
   </div>


   </div>
<?php } ?>
	<!-- start Modal	-->
    <div id="infoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h2 class="modal-title">Irish Interest</h2>
                </div>
  
        <form method="post" id="action_submit">     
          <div class="modal-body">
          	<h4>More Info / url fields</h4>
			<p> Text entered into the <b><i>More Info</i></b> field will be appended to the Book's synopsis and hyperlinked 
			to the web page specified in the associated <b><i>url</i></b> field.</p>
			<p>For example, if you know where the visitor might find a review of this book, enter the phrase "Read a Review" 
			here and enter the url of the web page where the review can be seen in the assiciated <b><i>url</i></b> field below</p>
			<p>If in doubt leave both these fields blank.</p>
          </div>
          <div class="modal-footer">
          		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  </div>
		</form>
          </div>
        </div>
   </div>
<!-- end modal -->

</fieldset>
					</form>
				</div>			
				</div>
			</div>
	</div>
<!-- Collapsible Form ***END*** -->      

<?php 
$_SESSION['err']	=	array();
unset($_SESSION['ok']);
$this->publishmodel->resetSession();
/*var_dump($_SESSION);
die;
*/
?>


     <div class=" col-md-3" style="padding-right:0px">
   	    <div class="" >

 <div class="panel panel-default">
  <div class="panel-heading">My Books</div>
  <div class="panel-body" style="padding:0px; padding-top:15px">

        <div class="" id="property-listings">
  			<div class="bodycontainer scrollable style="background-color:#e8e8e8"">
 
<?php 
   	
	foreach($publish as $book){ 
  
 		$image	=	"../upload/".$book->image;
 		if($book->publisherurl	!=	"")	{
	 		$publisherLink	=	"<a href=".$book->publisherurl.'>'.$book->publisher."</a>";
 		}
 		else 	{
 			$publisherLink	=	$book->publisher;
 		}
 		if($book->vendorurl	!=	"")	{
	 		$vendorLink	=	"<a href=".$book->vendorurl.'>'.$book->vendor."</a>";
 		}
 		else {
 			$vendorLink	=	$book->vendor;;
 		}
 		//var_dump($image);
 		//die;
 		//$onClick	=  `onClick="$('form').submit();"`;
/*			echo '
			
							
                <div class="col-md-12"> 

                    <!-- Begin Listing -->
                    <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing">
                        <div class="media">
                           <div class="pull-left">
 									
						<img src="'.$image.'" class="img-responsive" width="50" height="80"></div>
						
                        <div class="clearfix visible-sm"></div>

                        <div class="media-body fnt-smaller">
						
					
                        	<class="media-heading"><small class="pull-right">'.$publisherLink.'</small>
							<small><ul class="list-inline mrg-0 btm-mrg-10 clr-535353">
        	                  <li>'.$book->published.'</li>
    	                      <li style="list-style: none">|</li>
	                          <li>'.$book->genre.'</li>
                        	  <li style="list-style: none">|</li>
	                     	  <li>'.$book->area.'</li>
	                     	  <li style="list-style: none">|</li>
	                     	  <li>'.$book->isbn.'</li></ul></small>
                          	<span style="font-size: 14px;"><b><i>'.$book->title.'</i></b></span>
                        	  <p class="hidden-xs">						
							'.$book->synopsis.'. <a href='.$book->linkurl.'>'.$book->linktext.'</a></p>
							<div class="col-md-6"><span class="fnt-smaller fnt-lighter fnt-arial">Author: <b>'.$book->author.'</b></span></div>
							<div class="col-md-5"><span class="fnt-smaller fnt-lighter fnt-arial"><b>'.$vendorLink.'</b></span></div>
							<span class="pull-right  fnt-arial" >
		';							
*/
			echo '
                <div class="col-md-12"> 
                    <!-- Begin Listing -->
                    <div class="brdr bgc-fff  box-shad btm-mrg-2 property-listing" style="padding-right:10px">
                        <div class="media">
                           <div class="pull-left"><a href="../publish/&edit?id='.$book->id.'">
						<img src="'.$image.'" class="img-responsive" width="50" height="80"></a></div>
                        <div class="clearfix visible-sm"></div>
                        <div class="media-body fnt-smaller">
                        	<class="media-heading"><small class="pull-right">'.$book->publisher.'</small>
							<small><ul class="list-inline mrg-0 btm-mrg-10 clr-535353">
        	                  <li>'.$book->published.'</li>
    	                      <li style="list-style: none"></li></ul>
                          	<span style="font-size: 14px;">'.$book->title.'</span>
                        	  				
							<div class="col-md-12"><span class="fnt-arial"><b>'.$book->author.'</b></span></div>
							
							</small><span class="pull-right  fnt-arial" >
		';							
 		
//	?>
 <!-- DELETE BUTTON	

    <button type="button" class="btn btn-default btn-sm" onClick="triggerModal('<?php echo $book->id ; ?>')">
	<span style="font-size: 10px; text-shadow: black 0px 1px 1px; "class="glyphicon glyphicon-remove"></span>
    </button> -->

    <?php 
    echo '  
    <div id="largeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h4 class="modal-title">Delete </h4>
                </div>
  
        <form method="post" id="action_submit" action="./?delete">     
              <div class="modal-body">'.$modalBody.'
                     <input type="hidden" name="titleId" id="the_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';?>
                    <button type="submit" class="btn btn-success btn-primary" ><?php echo 'OK' ;?></button>
<?php echo '
                </div>
           </div>
        </div>
    </div>
</form>
							
<!-- EDIT LINK	-->							
<a href="../publish/&edit?id='.$book->id.'">
<span style="font-size: 20px; text-shadow: black 1px 0px 0px;" title="Edit" class="glyphicon glyphicon-book"></span></a>


<!--Book Id - hidden -->
  <input id="bookId" name="bookId" class="hidden" type="text" value=">'.$book->id.'"</input> 
						</div>
						</div>
					</div>
					</div>

					';
			}
 echo '</div></div></div></div></div></div>';
 //		echo '<div class="col-md-4"></div><div class="col-md-4">
 echo '<div class="col-md-12" id="footer">
      <div class="container">
 
				<p class="text-center">This data is licensed to Irish Interest (Demo Site)<br />
				for use strictly within Terms and Conditions.<br />
				Copyright &copy;  - Irish Interest - www.irishinterest.ie<br />
				All Trademarks acknowledged</p></div>
		</div></div>';
}  ?>
</div></div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
	<script src="../js/moment.js"></script>    
	<script src="../js/transition.js"></script>
	<script src="../js/collapse.js"></script>
	<script src="../js/bootstrap-datetimepicker.min.js"></script>
	<script src="../js/jquery.bootstrap-touchspin.min.js"></script>

        <script type="text/javascript">
        $(function () {
            $('#datetimepicker5').datetimepicker({
                pickTime: false
            });
        });
        </script>

<!-- For Collapsable panels... -->
<script type="text/javascript">
$(document).on('click', '.panel-heading span.clickable', function(e){
    var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	}
})
</script>
<script type="text/javascript">
function triggerModal(avalue) {
 
    document.getElementById('the_id').value = avalue;
 
    $('#largeModal').modal();
 
}
</script>
<script type="text/javascript">
function triggerInfoModal() {
 
   /* document.getElementById('the_id').value = avalue;*/
 
    $('#infoModal').modal();
 
}
</script>
<script>
$(function() {
    $('.required-icon').tooltip({
        placement: 'left',
        title: 'Required field'
        });
});
</script>    
        <script>
            $("input[name='day']").TouchSpin({
                min: 1,
                max: 31,
                step: 1,
                decimals: 0,
                verticalbuttons:true
            });
        </script>
        <script>
            $("input[name='year']").TouchSpin({
                min: 1,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
           });
        </script>

        <script>
            $("input[name='pages']").TouchSpin({
                min: 1,
                max: 100000,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
           });
        </script>

  </body>
</html>

