<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" >
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Irish Interest - Find Books From or About Ireland</title>
<meta name="description"
	content="Find books from or about Ireland, Search for Irish Books, Irish Writing, Irish Literature, Irish Books by Location, Irish Books by Placename, Irish Books by Townland, Irish Books Area, Irish Authors" />
<meta name="keywords"
	content="Ireland, Irish, Books,  Irish Authors, Writing, New Irish Writing, Irish Literature, Irish Placenames, Irish Townlands" />
<meta name="robots" content="INDEX,FOLLOW" />

<link rel="icon" type="image/png" href="favicon.png" />

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
</head>
<body role="document">
 <?php 
 
$heading = ' U T I L I T I E S';

   		$userMenu =	'
   			<button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown" 
    				style="border-radius: 10px; font-weight:900;">'
  					.$_SESSION['user'].'
    				<span class="caret"></span>
    		</button>';
 if($_SESSION['accessLevel']		=='10')	{
  	$userMenu .=	'
  	  	<ul class="dropdown-menu" style="text-align:left">
		  	<li><a href="../admin/">Publishers </a></li>
		  	<li><a href="../categories/">Categories</a></li>
		  	<li><a href="../banner/">Banners</a></li>
		 	<li><a href="#">Utilities</a></li>
		  	<li class="divider"></li>
  			<li><a href="../publish/">Add Books / Edit Books</a></li>
  			<li><a href="../authors/">Author Profiles</a></li>
  			<li><a href="../profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
		  	<li class="divider"></li>
  			<li><a href="../?home=1">Home Page</a></li>
  			<li><a href="../logout">Sign Out</a></li>
		  	  			</ul>';
  }
  ?>
<div class="row " >
	<a href='../'> 
		<div class="col-md-2 col-sm-2 voffset6" style="background-color:#ffffff; z-index:1000; " >
			<img alt="" src="../ii_circle.png" class="image-responsive ii_circle" >
		</div>
		<div class="col-md-3  col-sm-4 voffset8 ii_text_div" >
		
			<img alt="" src="../IRISH_INTEREST_text.png" class="image-responsive ii_text" >
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
	<div class="container-fluid" style="border-radius: 4px">
			<div class="col-md-2"></div>
			<div class="col-md-7">
				<div class="well well-sm" style="border-radius:25px">
  				<?php echo displayMessage();?>
 					<h4  class="text-center"><?php echo $heading;?></h4><br/>
					<form role="form" method="post" class="form-horizontal" >
					<fieldset>

<button name="resetHistory" value="resetHistory" type="submit" class="btn btn-custom pull-right" Style="border-radius:10px;">Reset Search History</button>  
<p>Click the "Reset Search History" Button to erase  the site's Search History.</p> 
<div class="row voffset9"><div class="col-md-4"></div><div class="col-md-4 text-center">
<p class="btn-custom">WARNING!</p></div><div class="col-md-4"></div></div> 
<div class="col-md-12 voffset2 text-center">
<p>The TOP SEARCHES panel on the site's Home page will be empty until new searches are performed.</p><p> The process of collecting users' searches will then re-commence </p>
</div>
</fieldset>
</form>
</div>
</div>
</div>
<?php 
function displayMessage()	{
	if(isset($_SESSION['msg'])) {
		$rtn = '<div class="row" style="background-color:#f3be22; margin-left:10%; margin-right:10%;border-radius:10px;">
					<a href=./?reset=1>
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
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.bootstrap-touchspin.min.js"></script>
</body>