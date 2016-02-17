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
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body role="document">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56305380-2', 'auto');
  ga('send', 'pageview');

</script>
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script type="text/javascript" src="js/bootstrap-progressbar.min.js"></script>
<?php

  //var_dump($_SESSION);
  if(!isset($_SESSION['accessLevel'])) {
		$userMenu = '<a href="login/?publisher=1" title="You must be signed in to activate this option" 
  							class="btn btn-custom" 
  							style="border-radius: 10px; font-weight:900;">
  							<b>Publisher Log In</b>
  						</a>';
		$sign ='<a href="login/">Sign In</a>';
  }
	else {
		//$userMenu = '<button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 10px;">Publisher Log In</button>';  
  		$userMenu =	'
   			<button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown" 
    				style="border-radius: 10px; font-weight:900;">'
  					.$_SESSION['user'].'
    				<span class="caret"></span>
    		</button>';
  		$sign =	'<a href="logout">Sign Out</a>';  
				
  		if($_SESSION['accessLevel']		=='10')	{
  	  //$userMenu = '<!-- a href="#" class="dropdown-toggle " data-toggle="dropdown" style="padding-left: 0px">'.$_SESSION['user'].'</a> -->
  	  		$userMenu .= 
  	  			'<ul class="dropdown-menu" style="text-align:left">
			  	<li><a href="admin/">Publishers</a></li>
			  	<li><a href="categories/">Categories</a></li>
		 	 	<li><a href="banner/">Banners</a></li>
		 	 	<li><a href="utilities/">Utilities</a></li>
		 	 	<li class="divider"></li>
  				<li><a href="publish/">Add Books / Edit Books</a></li>
  				<li><a href="authors/">Author Profiles</a></li>
  				<li><a href="profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
  				<li class="divider"></li>
  				<li><a href="logout">Sign Out</a></li>
  			</ul>';
  		}
		 if( ($_SESSION['accessLevel']		=='1')
  			 || ($_SESSION['accessLevel']		== '2'	) )	{
   	 			$userMenu .=	'
					<ul class="dropdown-menu" style="text-align:left">
  					<li><a href="publish/">Add Books / Edit Books</a></li>
 					<li><a href="authors/">Author Profiles</a></li>
  					<li><a href="profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
  					<li class="divider"></li>
  					<li><a href="logout">Sign Out</a></li>
  					</ul>';
  		}
  		if(($_SESSION['accessLevel']		=='3') || ($_SESSION['accessLevel'] == '4'))	{
  			$userMenu .=	'
				<ul class="dropdown-menu" style="text-align:left">
  				<li><a href="profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
  				<li class="divider"></li>
  				<li><a href="logout">Sign Out</a></li>
  				</ul>';
  		}
	}
 
$authors	= $_SESSION['authors'];
$authors	= json_encode($authors);
$link_A=	 formatAuthors();
$catMenu = '';
foreach($_SESSION['categories'] as $id=>$category)	{
	$catMenu .= '<li style="padding:0px"><a href=?category='.$id.' style="padding-top:0px; padding-bottom:0px;">'.$category.'</a></li>';
}
$eventMenu 	= '';
if( isset($_SESSION['accessLevel']) && ($_SESSION['accessLevel'] !== '4') ) {			//	Not "Correspondent" type user
	$eventMenu =  '<li><a href="events/" style="padding-top:0px; padding-bottom:0px;">Manage Events</a></li>
							<li class="divider"></li>';
}
 
foreach($_SESSION['events'] as $id=>$event)	{
	$startDate 	= date('l jS F Y',strtotime($event->date_time_from));
	$startTime 	= date('g:ia',strtotime($event->date_time_from));
	$startingAt 	= $startDate. ' at '.$startTime; 	
	$endDate 		= date('l jS F Y',strtotime($event->date_time_to));
	$endTime 		= date('g:ia',strtotime($event->date_time_to));
	$endingAt		= $endDate. ' at '.$endTime;
	if($event->eventimage == '') $image = './placeholder.jpg';
	else $image = 'upload/'.$event->eventimage;
	$authorName = $event->firstname.' '.$event->lastname;
	
	$eventLink 	=' data-event-title 				= "'.$event->title.'"';
	$eventLink 	.=' data-event-description	= "'.$event->description.'"';
	$eventLink 	.=' data-event-location			= "'.$event->location.'"';
	$eventLink 	.=' data-event-from 				= "'.$startingAt.'"';
	$eventLink 	.=' data-event-to 				= "'.$endingAt.'"';
	$eventLink 	.=' data-event-image 			= "'.$image.'"';
	$eventLink 	.=' data-event-link 				= "'.$event->link.'"';
	$eventLink 	.=' data-event-author 			= "'.$authorName.'"';
	$eventLink 	.=' data-event-book 			= "'.$event->booktitle.'"';
	
	$eventMenu .='<li><a  href="#event_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal" '.$eventLink.'> '.$event->title.'</a></li>';

}
?>
<a id ="top"></a>
<div class="row" style="background-color:#ffffff; z-index:1000; position:relative" >

	<a href='#'> 
		<div class="col-md-2 col-sm-2 voffset6" style="background-color:#ffffff; z-index:1000; " >
			<img alt="" src="ii_circle.png" class="image-responsive ii_circle" >
		</div>
		<div class="col-md-3  col-sm-4 voffset8 ii_text_div" >
		
			<img alt="" src="IRISH_INTEREST_text.png" class="image-responsive ii_text" >
		</div>
	</a>
	<div class="col-md-5 col-sm-7 col-xs-12 primaryMenu  ">
		<div class="col-md-1 col-sm-1 col-xs-3" style="margin-right:26px; font-size: 16px; font-weight:500;">
			<a href="login/&register=register">Join </a>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-3" style="font-size: 16px; font-weight:500;">
			<?php  echo $sign; 
			?>
		</div>
		<div class="col-md-7 col-sm-5 col-xs-6">
			<div class="col-md-8  text-center" style="border: 0px solid; border-radius: 10px; line-height: 2; font-weight: 500; font-size: 16px; font: Impact, Charcoal, sans-serif;">
				<?php echo $userMenu; ?>
			</div>
			<div class="col-md-3 col-sm-2"></div>
		</div>
	</div>
</div>
<!-- div class="banner" style="background-image: url(./DoyleRod.png); height: 500px;"></div> -->
<div style="position:relative">
<!-- Fixed navbar -->
<div class="navbar  " role="navigation" style="z-index:100; margin: 0px; min-height: 0px; border: 0px; padding: 0px">
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
		<div class="row" style="z-index:1000;background-color: #f3be22; line-height: 2; font-weight: 600;">
			<div class="col-md-1"></div>
			<div class="col-md-9 col-sm-12 col-xs-6" style="background-color: #f3be22; line-height: 2; font-weight: 600;">
				<div class="col-md-1 col-sm-1 col-xs-12 nav_author"  z-index:2000;">
					<span style="z-index:2000;">
					<!-- a href="javascript:void(0)" onclick="showAlpha2();">Authors </a>
					 -->
						<a href="#" class="dropdown-toggle"data-toggle="dropdown" style="padding-left: 0px; z-index:2000";>Authors</a>
						<ul class="dropdown-menu" style="text-align:left; z-index:2000;">
							<?php  echo $link_A;?>
						</ul>
					</span>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-12 ">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">Categories</a>
						<ul class="dropdown-menu" style="text-align:left">
							<?php  echo $catMenu;?>
						</ul>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-6 nav_forum" >
				<a href="forum">Forum</a>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-12 nav_events">
						<a href="#" class="dropdown-toggle"data-toggle="dropdown" style="padding-left: 0px">Events</a>
						<ul class="dropdown-menu" style="text-align:left">
							<?php  echo $eventMenu;?>
						</ul>
				</div>
				<div class="col-md-3 col-sm-2 col-xs-12 nav_about" >
					<a href="javascript:void(0)"  onclick="aboutModal();">What is this site about</a>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-12 nav_latest" >
						<a href="#LATEST PUBLICATIONS">Latest Publications</a>
				</div> 
				<div class="col-md-1 col-xs-12 nav_more">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">More</a>
					<ul class="dropdown-menu">
						<li class="dropdown">
							<a href="javascript:void(0)"  onclick="triggerModal();">Welcome</a> 
							<a href="javascript:void(0)" onclick="showContact();">Contact Us</a>
							<a href ="./?published=1">Published Books</a>
							<a href ="./?top=1">Top Searches</a>
							<a href ="./?future=1">Coming Soon</a>
							<a href ="./?editorschoice=1">Editors Choice</a>
							<a href ="./?favourites=1">Favourites</a>
							
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div style="position:relative">
<div class="banner_position" style="">
    <div id="myCarousel" class="carousel slide">
    <!-- Carousel items -->
    <div class="carousel-inner">
    <?php 
    $active = "active";
    foreach($_SESSION['banners'] as $banner) { ?> 
    <div class="<?php echo $active;?> item .fade .in" >

		  <img alt="" src="./<?php echo $banner->image;?>" class="image-responsive carousel_image" style="margin-left:-90px; "> 
			<!-- img alt="" src="white_rect.png" class="image-responsive banner" style="max-height: 120px; min-width:100%;" >  -->
			<div class="banner_text col-sm-2 col-xs-2" style="padding-left:-20px;"><?php echo $banner->name.'<br>'.$banner->description;?></div>
			<!-- <div style="background-color:black; min-height:100px; width:100%;"></div>-->
 </div>
    <?php 
    $active = '';
    }
    ?>
   <!--  --><div class="item .fade .in">    	
		 <img alt="" src="./Beckett1.png"class="image-responsive carousel_image" style=" padding-top:100px; min-width:1687px"> 
			<div class="banner_text col-sm-3 col-xs-2"  >Samuel Beckett<br><i>Failing better</i></div>
		<!--	<div style="background-color:black; min-height:100px; width:100%;"></div>-->
 			 <img alt="" src="white_rect.png" class="image-responsive banner" style="max-height: 120px; min-width:100%; "> 
</div>
   <div class="item .fade .in">    	
		 <img alt="" src="./p01hy7f9.jpg" class="image-responsive carousel_image" style="margin-left:-150px;"> 
			
 			<img alt="" src="white_rect.png" class="image-responsive banner" style="max-height: 120px; min-width:100%;" > 
			<div class="banner_text col-sm-3 col-xs-2" >Edna O'Brien<br>A country girl</div>
 </div> 
 </div>
 </div>
 <div class="row">
	<div class="s earch_container" ><!-- ALPHA2 Form --><!-- Search input-->
		<!-- <div id="alpha2" class="hidden col-md-3 col-xs-8 col-sm-4  alpha2_positioner">
			<form role="form" class="form-horizontal">
				<div class="alert dismiss well well-sm" style="border-radius: 25px;">
					<button type="button" class="close input-group-button" href="javascript:void(0)" onclick="dismissAlpha2();" style="padding-left: 0px">
						<span class="glyphicon glyphicon-remove  orange " style="text-shadow: black 1px 0px 0px;" title="Close"></span>
					</button>

					<fieldset>	
 						<?php  //echo $link_A; ?></fieldset>
				</div>
			</form>
		</div>
 -->
		
		<div class="callout" >Irish writers, Irish writing.<br>Find that book here.</div>
		
		<div class="col-lg-5 col-md-4 col-sm-3 col-xs-5 search_positioner"  >
			<div  style="padding-bottom: 20px">
				<div class="row">
					<form id="searchform" role="form" class="form-horizontal" style="z-index:1000;">
						<div class="input-group" >
							<input id="searchinput"  name="searchinput" placeholder="start your quest here" class="form-control input-lg" type="search" 
										value="<?php echo $_SESSION['searchFax'];?>" style="z-index:99; box-shadow: none; border-right: 0px; border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
							<span class="input-group-btn">
								<button id="searchbtn" name="search" class="btn btn-custom " type="submit" 
										style="padding: 7px; 
										z-index:1000;
										border: 6px solid; 
										border-color: #ffffff; 
										border-top-left-radius: 0px; 
										border-top-right-radius: 15px; 
										border-bottom-right-radius: 15px;">
										&nbsp; Search&nbsp; &nbsp;
								</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
 </div>
 </div>
	<div class="twitter_feed" >
				
					<div class="container-pad" id="property-listings" 
								style="background-color: #f3be22; 
								border: 0px solid; 
								border-radius: 25px;
								padding:11px;
								margin:0px";
								>
						
						 	<a class="twitter-timeline" 
  								href="https://twitter.com/Booksirish" data-widget-id="593740594373079041"  rel="nofollow">
		 						Tweets by @Booksirish
						 	</a>
		  			</div>
		 </div> 


<?php
if($_SESSION['contactReceived']	==	true) {
	echo '  <div class="row "  id="messageBox">
			  <div class="col-md-3 col-sm-1"></div>
			   <div class="col-md-5 col-xs-12 col-sm-11 voffset7">
    			<div class="alert dismiss" style="border-radius:25px; margin-left:75px;">
    				<button type="button" class="close input-group-button" href="javascript:void(0)" onclick="dismissMessageBox();" style="padding-left:0px" >
  			   			<span class="glyphicon glyphicon-remove  orange " style="text-shadow: black 1px 0px 0px; " title="Close">
  			   			</span>
    				</button>
    				<p class="text-center">'.$_SESSION['contactReceivedMessage'].'</p>
   				</div>
   			   </div>
   			  </div>
   			 </div>';
	$_SESSION['contactReceived']	=	"";
	$_SESSION['contactReceivedMessage']		=	"";
}
elseif($_SESSION['ok']	===	false)	{
	foreach($_SESSION['err']['field'] as $idx => $field)	{
		switch ($field)	{
			case 'contactName':
				$contactNameErr	=	"has-error";
				$contactNameMsg	=	$_SESSION['err']['msg'][$idx];
				break;
			case 'contactemail':
				$contactemailErr	=	"has-error";
				$contactemailMsg	=	$_SESSION['err']['msg'][$idx];
				break;
			case 'contactMessage':
				$contactMessageErr	=	"has-error";
				$contactMessageMsg	=	$_SESSION['err']['msg'][$idx];
				break;
		}
	}
}


$classHidden	=	' class="hidden contact" ';
if($_SESSION['ok'] === 	false) {
	$classHidden	=	"";
}
?>

<div id="contact"  <?php echo $classHidden;?>>
	<form role="form" class="form-horizontal">
		<fieldset><!-- Contact  Form -->
			<div class="col-md-2"></div>
			<div class="col-md-12 voffset3">
				<div class="alert dismiss well well-sm" style="border-radius: 25px;">
					<button type="button" class="close input-group-button" href="javascript:void(0)" onclick="dismissContact();"
									style="padding-left: 0px">
						<span class="glyphicon glyphicon-remove  orange " style="text-shadow: black 1px 0px 0px;" title="Close"> </span>
					</button>

					<p class="text-center" style="padding-bottom: 20px">Leave a message here, or mail us at administrator@IrishInterest.ie</p>
					<!-- EMail -->
					<div class="col-md-6">
						<div class="form-group  
							<?php echo $contactNameErr ; ?>">
							<label class="col-md-2 control-label control-label.has-error" for="contactName">From</label>
							<div class="col-md-9">
								<div class="controls">
									<input type="text" id="contactName" name="contactName" placeholder="your name" 
											class="form-control input-md" 
											required 
											size="40"
											value="<?php echo $_SESSION['contactName'] ; ?>"> 
									<span class="help-inline"><?php echo $contactNameMsg; ?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group  <?php echo $contactemailErr ; ?>">
							<label class="col-md-3 control-label control-label.has-error" for="contactemail">E-mail</label>
							<div class="col-md-9">
								<div class="controls">
									<input type="email" id="contactemail" name="contactemail" placeholder="your e-mail address" 
											class="form-control input-md" 	
											required 
												size="40"
											value="<?php echo $_SESSION['contactemail'] ; ?>"> 
													<span class="help-inline"><?php echo $contactemailMsg; ?></span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group  <?php echo $contactMessageErr ; ?>">
						<div class="col-md-12">
							<div class="controls">
								<textarea class="form-control" rows="3" name="contactMessage" placeholder="your message" required>
									<?php echo $_SESSION['contactMessage'];?>
								</textarea> 
								<span class="help-inline"><?php echo $contactMessageMsg; ?></span>
							</div>
						</div>
					</div>
					<!-- Submit button  -->
					<div class="form-group">
						<div class="col-md-4">Irish Interest
							<table style="font-size: 10px; color: #526629;">
								<tbody>
									<tr>
										<td>Suite 34b, The book center, Camden Street,</td>
									</tr>
									<tr>
										<td>Dublin 2, <b>Ireland.</b></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-4 text-center">
							<div class="controls">
								<button type="submit" id="contact" name="contact" value="contact" 
											class="btn btn-md btn-primary btn-primary">Submit
								</button>
							</div>
						</div>
						<div class="col-md-4 pull-right">	
							<table class="pull-right" style="font-size: 10px; color: #526629;">
								<tbody>
									<tr>
										<td style="padding-top: 17px" class="pull-right">+ 353 1 254 8849</td>
									</tr>
									<tr>
										<td class="pull-right">administrator@irishinterest.ie</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</fieldset>
	</form>
</div>
<?php

$_SESSION['ok']			=	'';
$_SESSION['err']			=	'';
?>
<!-- PROGRESS BAR 
<div class="container-fluid">			
   		<div class=" container-pad" >
        	<div class="progress" id="progress" style="visibility: hidden;">
          	  <div class="progress-bar" role="progressbar" data-transitiongoal="100" aria-valuemin="50" aria-valuemax="100" style="visibility: hidden;"></div>
          	</div>
 	</div>
</div>
-->
<script>
$( "#searchbtn" ).click(function( event ) {
		document.getElementById("progress").style.visibility="visible"; 
        	   $('.progress .progress-bar').progressbar();
				setTimeout(	window.document.forms["searchform"].submit(),30000);        	  //       	   $.post( "#", $( "#searchform" ) );
        	   });
</script>

<!-- start Search Info Modal	NOT USED -->
<div id="infoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="myModalLabel">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h2 class="modal-title">Irish Interest</h2>
			</div>

			<form method="post" id="action_submit">
				<div class="modal-body">
					<h4>Using Search</h4>
					<p>Search works best if you use whole words, separated by spaces, rather than abbreviations</p>
					<p>Click Search while Search field is empty will return you to the newly listed books</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end modal -->
<?php
if($_SESSION['mode']	== "search" ) {
		$searchMsg = searchMessage();
}	else	{	?>

<?php
}
?>


<div class="col-md-1"></div>
<div class="col-md-12 col-sm-12 col-xs-12 voffset9 main-panel" style="z-index:50; padding-right:40px; padding-left:40px;" >
<?php
if($_SESSION['mode']	== "search" ) {
	echo '<div class="row" name="searchresults" id="searchresults">&nbsp</div>';
}
	?>
	<div class="container-fluid" style="border-radius: 4px">
		<div class="container-pad" id="property-listings" style="background-color: #f3be22; border: 0px solid; border-radius: 25px">
			<!-- Facebook follow  -->
	<!-- a href="https://www.facebook.com/profile.php?id=100008804209153" target="_blank" style="padding-right: 0px; "> -->
	<a href="https://www.facebook.com/Irishinterest" target="_blank" style="padding-right: 0px; " rel="nofollow"> 
	
			<img src="facebook_button.png" class="image-responsive" style=" height:25px; margin-left:70px; border-radius:2px;" >
	</a>
<!-- Google Plus -->	
<a href="https://plus.google.com/101688982005763255838" target="_blank" rel="nofollow">
		<img src="google-plus-4-512.png" class="image-responsive"  style=" height:25px;margin-left:10px; border-radius:2px;">
</a>

<!-- Youtube -->	
<a href="https://www.youtube.com/channel/UCBVh-eIxXZEfh_BK9r8wwdQ" target="_blank" rel="nofollow">
		<img src="650d26_530a903910cd416ba6db299f004d1d2d.png" class="image-responsive"  style="height:25px;margin-left:10px; border-radius:2px;">
</a>
		
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 ">
<?php 

function searchMessage()	{
	$rtn = '
		
		<div ><div class="col-md-6" style="background-color:#f3be22; border-radius:25px;">
			<h5 class="text-center ">Your search for 
				<strong><i>'. substr($_SESSION['searchFax'], 0,20).'...</i></strong>
				found '.$_SESSION['totalRecords'].' book(s)';
			//	 <a href=./?reset=1>
			//			<span class="glyphicon glyphicon-remove-circle col-md-offset-1 orange"	title="reset" style="font-size: 20px; text-shadow: black 0px 1px 1px;"></span>
			//	</a>
	$rtn .=	'</h5></div></div>';
	return $rtn;
}
function pager_div($panel)	{
	$total		=	$_SESSION['totalRecords'];
	
	if($panel == 'LATEST PUBLICATIONS')			/// todoo = use session mode
				$total = $_SESSION['recentCount'];

	if($panel == 'PUBLISHED BOOKS')					/// todoo = use session mode
				$total = $_SESSION['recentCount'];

	if($_SESSION['mode']	== 'future') 
				$total = $_SESSION['futureCount'];
				
	if($_SESSION['mode']	== 'top') 
				$total = $_SESSION['topCount'];
				
	IF($_SESSION['mode'] 	== 'editorschoice'	)
				$total = $_SESSION['editorsChoiceCount'];
				
	IF($_SESSION['mode'] 	== 'favourites'	)
				$total = $_SESSION['favouritesCount'];
				
				$start 		=	$_SESSION['startRRN'] + 1;
	$end 		=	$start + $_SESSION['pageSize'] -1;
	if($end > $total) $end = $total;

	if($total		<	$_SESSION['pageSize'])	return ' Showing '.$start . ' to '. $end.' of '. $total.' Books' ;
	
	$pageSize	=	$_SESSION['pageSize'];
	$noPages 	=	intval($total / $pageSize)	==	0	?	1	:	intval($total / $pageSize);
	$currentPage	=	intval($start / $pageSize)	+1;
	if( (fmod($total, $pageSize)	!=	0)	&& ($total > $pageSize) ){
		$noPages++;
	}
	$pagesRangeStart	=	1;
	if(intval($currentPage) - 3 > 0) $pagesRangeStart = intval($currentPage) - 3 ;
	$pagesRangeEnd	= $pagesRangeStart + 5;
	if($pagesRangeEnd > $noPages) {
		$pagesRangeEnd	=	intval($noPages);
		$pagesRangeStart = $pagesRangeEnd - 5;
		if($pagesRangeStart < 1) $pagesRangeStart =	1;
	}
	$pager	=	'
		<nav>
  			<ul class="pagination  pagination-sm">
    			<li><a href="?page=page&current=1" title="First Page" rel="nofollow"><span aria-hidden="true" >&laquo;</span><span class="sr-only">First Page</span></a></li>
       ';
	for($i=$pagesRangeStart; $i <= $pagesRangeEnd; $i++)	{
		$active 	=	"";
		if($i == intval($currentPage))	{
			$active	=	' class="active"  style="background-color:#000"';
		}
		$pager .=	'<li'.$active.'><a href="?page=page&current='.$i.'" rel="nofollow"><span aria-hidden="true">'.$i.'</span></a></li>';
	}
	$pager	.=	'
           		<li><a href="?page=page&current='.intval($noPages).'" title="Last Page" rel="nofollow">
           			<span aria-hidden="true" >&raquo;</span>
           			<span class="sr-only">Last Page</span>
           		</a></li>
			</ul>
		</nav>';

	$rtn	=  'Showing '.$start . ' to '. $end.' of '. $total.' Books' .$pager;
	//$rtn 	.=	'<div class="col-md-4">'.'</div>';
	return $rtn;
}
function formatImage($book)	{
	if($book->image != "")	{
		$image	=	"upload/".$book->image;
	}
	else {
		$image	=	"placeholder.jpg";
	}
	return $image;
}
function formatModal($book,$image,$bookAuthors) 	{
	$publisherLink_js	=	$book->publisherurl;
	$vendorLink_js		=	$book->vendorurl;
	$publishdate_js		=	date('d M Y',strtotime($book->published));
	$bookSize 			=	'';

	$cover	=	"";
	if($book->hardback	== true )	{
		$cover	=	"<i><b>Hardback</b></i> ";
	}
	if($book->paperback	== true )	{
		$cover	.=	"<i><b>Paperback</b></i> ";
	}
	if($book->ebook	== true )	{
		$cover	.=	"<i><b>e-Book</b></i> ";
	}
	if($book->audio	== true )	{
		$cover	.=	"<i><b>Audio</b></i> ";
	}
	if($cover !=	"")	{
		$cover	=	"Available as ".$cover;
	}
	if(($book->ebook ==true) || ($book->audio == true) ) {
		if(!$book->size == '')	$bookSize = 'Size (electronic form of this book): '.(float)$book->size.'Kb'; 
	} 
	$pages	=	"";
	if($book->pages > 1)	{
		$pages	=	$book->pages." pages";
	}
	if( (isset($_SESSION['id']) ) 	&& (!$_SESSION['id']	==	'' )) 
		$signedin = true;
	else $signedin	= false;
	$modalLink =	'
  					data-book-vendor		="'.$book->vendor.'" 
  					data-book-date			="'.$publishdate_js.'" 
  					data-book-title			="'.$book->title.'" 
  					data-book-author		="'.$bookAuthors.'" 
  					data-book-synopsis	="'.str_replace('"', '\'',$book->synopsis).'" 
  					data-book-linkurl			="'.$book->linkurl.'"
  					data-book-linktext		="'.$book->linktext.'"
  					data-book-image		="'.$image.'"
 					data-book-publisher	="'.$book->publisher.'"
  					data-book-publisherurl	="'.$publisherLink_js.'"
  					data-book-vendorurl	="'.$vendorLink_js.'"
   					data-book-isbn10		="'.$book->isbn.'"
					data-book-cover			="'.$cover.'"
  					data-book-language	="'.$book->language.'"
  					data-book-isbn13		="'.$book->isbn13.'"
					data-book-pages		="'.$pages.'"
					data-book-asin			="'.$book->asin.'"
					data-book-size			="'.$bookSize.'"
					data-book-id				="'.$book->id.'"
					data-signed-in			="'.$signedin.'"
					data-favourite				="'.$book->isFavourite.'"
					data-narrative				="'.$book->narrative.'"
					';
	return $modalLink;
}
function formatAuthors()	{
/*
	return	'Show <a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"all">all Authors</a><br> or Filter by:
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"a">a</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"b">b</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"c">c</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"d">d</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"e">e</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"f">f</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"g">g</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"h">h</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"i">i</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"j">j</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"k">k</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"l">l</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"m">m</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"n">n</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"o">o</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"p">p</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"q">q</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"r">r</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"s">s</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"t">t</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"u">u</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"v">v</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"w">w</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"x">x</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"y">y</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"z">z</a>
				';
	
				'<li style="padding:0px"><a href=?category='.$id.' style="padding-top:0px; padding-bottom:0px;">'.$category.'</a></li>';
				*/
		$alph = '<li style="padding:0px; font-size:14px; z-index:1000">
						<a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"all">Show all Authors</a><span style="margin-left:20px;color:grey"> or filter by:</span><br>
						</li>
				<li style="padding:0px; z-index:1000;"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"a">A</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"b">B</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"c">C</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"d">D</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"e">E</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"f">F</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"g">G</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"h">H</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"i">I</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"j">J</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"k">K</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"l">L</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"m">M</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"n">N</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;"  data-toggle="modal"  	data-link-a		=	"oÓ">O</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;"  data-toggle="modal"  	data-link-a		=	"p">P</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"q">Q</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"r">R</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"s">S</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"t">T</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"u">U</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"v">V</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"w">W</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"x">X</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px;" data-toggle="modal"  	data-link-a		=	"y">Y</a></li>
				<li style="padding:0px; z-index:1000"><a  href="#authors_modal" style="padding-top:0px; padding-bottom:0px; z-index:1000" data-toggle="modal"  	data-link-a		=	"z">Z</a></li>';
				
		return $alph;	
}
function formatBook($book)	{
	if($book->publisherurl	!=	"")	{ $publisherLink	=	' - <a  href="'.$book->publisherurl.'" target="_blank"  rel="nofollow">'.$book->publisher."</a>"; }
	else 	{ $publisherLink	=	' - '.$book->publisher; 		}
	if($book->vendorurl	!=	"")	{ $vendorLink	=	"<a href=".$book->vendorurl.' target="_blank" rel="nofollow">'.$book->vendor."</a>"; }
	else { $vendorLink	=	$book->vendor;}
	$publishDate 		= date('d M Y',strtotime($book->published));
	$image			 	= formatImage($book);
	$bookAuthors = '';
	$sep				=	'';		 // needs to be appended to name to avoid space before the separator!!?
	foreach($book->authors as $authorID=>$authorName)	{
		$bookAuthors .= '<a href=./?author='.$authorID.'>'.$sep.rtrim($authorName).'</a> ';
		$sep =	', ';
	}
	
	if($_SESSION['accessLevel']	== '10')	{
		$editLink = '<div class="col-md-2 info_links"><a href="publish/&edit?id='.$book->id.'">
							Edit
						</a></div>';
	}
	$modalLink		= formatModal($book,$image,$bookAuthors);

	$bookFormatted	= '<div class="col-md-4 col-xs-12" style="padding-top:50px;margin-left:0px;">
	                   				  	<div class="media">';	
	
    $bookFormatted .= '<div class="pull-left">';																						//	image
	                   				  	
	
	$bookFormatted .= '				<a  href="#book_modal" data-toggle="modal" '.$modalLink.'>';
	$bookFormatted	.=	'					<div class="ii-image">
 														<img src="'.$image.'" class="img-responsive" style=" background-color:#FFFFFF;">
 													</div>
 												</a>
										</div>'
 											.$editLink.'
 								  		</div>';																												//	 media

	$bookFormatted	.=			'	<div class="fnt-smaller" >';																					//	Title, Author & date
	$bookFormatted	.=	'				<p><b><a  href="#book_modal" data-toggle="modal" '.$modalLink.'>'.$book->title.'</a></b></p>
												<p class=" fnt-arial info_links" ><b>By:</b> '.$bookAuthors.'</a></p>
												<p class="info_links">'.$publishDate.'	<a href="#">'.$publisherLink.'</a></p> 						
											</div>';																												 
/* 
	$bookFormatted	.=	'			<div class="media-heading">
												<small>';	 
	$bookFormatted	.=	'					<p class="hidden-xs fnt-smaller fnt-lighter fnt-arial"><b>'.$vendorLink.'</b></p>';			//		Vendor
	$bookFormatted	.=	'	  			</small>
											</div>';
*/											
	$bookFormatted	.=	' 			
										<div class="row" style = "padding-right:50px;padding-top:0px;padding-left:15px;">
										  <small>
											<p class="fnt-arial info_links">'.substr($book->synopsis,0,220).
										'		<a   href="#book_modal" data-toggle="modal" '.$modalLink.'> ...more information </a>
											</p>
										</small></div>
									</div>
						';
	return $bookFormatted;
}
function addPanel($books,$panelTitle, $rowsPerPanel, $colsPerRow, $link = '',$msg='')	{
	$panelDiv =	'<div class="row brdr bgc-fff pad-10  btm-mrg-40 " style="background-color:rgba(256, 256, 256, .8); border-radius:25px;">';
	$panelDiv .= 	'<a id="'.$panelTitle.'"></a>';
	if($_SESSION['startRRN']	> 0) $panelDiv .= '<a id="searchresults"></a>'; 
	
	
	$panelDiv .=	$msg;
	 
	if($panelTitle =="FAVOURITES") 
		$panelHead = 'Your Favourites' ;
	else
		$panelHead = $panelTitle ;
		
	if(($_SESSION['mode'] == 'default') && ($panelTitle ==	'LATEST PUBLICATIONS')) {
		$panelDiv		=	$panelDiv.'<a href="./?published=1">
												  <div class="row">
													<div class="glyphicon glyphicon-circle-arrow-right  pull-right"	
														title="Enlarge " style="font-size: 20px; text-shadow: black 0px 1px 1px; ";>
													</div>
												   </div>
												</a>';
	}
	if($link == "top") {
		$panelDiv .= '<a href="#top">
			<div class="row"><div class="glyphicon glyphicon-circle-arrow-up  pull-right"	
				title="Top of page" style="font-size: 20px; text-shadow: black 0px 1px 1px; ";></div></div>
			</a>';
	}
	if($link == 'back') {
			$panelDiv .= '
				<a href="./?home=1">
					<div class="row"><div class="glyphicon glyphicon-remove-circle  pull-right "	
						title="Back" style="font-size: 20px; text-shadow: black 0px 1px 1px;"></div></div>
				</a>';
	}
	$panelDiv .= '	<div class="row ">
							<div class="text-center"><b><large>'.$panelHead.'</large></b></div>';
	if(($_SESSION['mode'] 	!== 'default') 	|| ( ($_SESSION['mode'] == 'default') && ($panelTitle == 'LATEST PUBLICATIONS' ) ) ) {
		$pager_div = pager_div($panelTitle);
		$panelDiv		=	$panelDiv.'<div class=" pull-right" style="margin-top:0px;"><small>'.$pager_div.'</small></div>';
	}
	else $pager_div = '';

	$panelDiv	.=	'</div>';
	$panelDiv	.=	'<div class="row  " style="padding-bottom:0px;">';
	if(count($books) 	==	0)	{ 
		if(($panelTitle =="FAVOURITES") &&  ($_SESSION['accessLevel'] == '')) 
			echo $panelDiv.'<div class="row text-center info_links"><a href="login/">Sign In</a> to see your Favourite books </div></div>'; 
		else
			echo $panelDiv.'<div class="row text-center"> No Books</div></div>';
	}
	
	$rowsCount	=	1;
	$colsCount	=	1;
	$row 	=	$panelDiv;
	$addrow =	false;
	$row 	=	$panelDiv;
	foreach($books as $book) {
	 if($rowsCount <= $rowsPerPanel) {	
		$row	.= formatBook($book);

		if($colsCount		==	$colsPerRow)	$addrow 	= true;
		if($addrow	==	 true)	{
			echo $row.'</div>';
			$addrow	=	false;
			$colsCount	=	1;
			if($rowsCount < $rowsPerPanel) 	$row = '<div class="row">';
			else {
				echo '';
				$row 	=	'';
			}

			$rowsCount++;

		}
		else	{
			$colsCount++;
		}
	 } 
	}
	if($colsCount >	1)	{		// show residuals - 1 or 2 books
		echo $row.'</div>';
	}
	echo '<div class="row pull-right" style="padding-top:50px;">'.$pager_div.'</div></div>';
}
function addAuthorPanel()	{
	$author 					= 	$_SESSION['author'][0];
	$authorFullName 	=	$author->firstname." ".$author->lastname;
	
	$td	 = '<td class="info_links" style="padding-right:10px; padding-top:0px;">';
	
	 
	$panelDiv =	'<div class="row brdr bgc-fff pad-10  btm-mrg-40 property-listing" style="background-color:rgba(256, 256, 256, .8); border-radius:25px;">';
	$panelDiv.= '<a href="./?home=1">
						<div class="glyphicon glyphicon-remove-circle   pull-right"	
								title="Back" style="font-size: 20px; text-shadow: black 0px 1px 1px;"></div>
						</a>';
	$panelDiv	.=	'<p class="text-center"><b><large>'.$panelTitle.'</large></b></p><div class="row  " style="padding-bottom:0px;">';
	
	$image		= $author->image == '' ? 	"Placeholder.jpg" : 'upload/'.$author->image;
	$image 		= '<div class="ii-image"><img src="'.$image.'" class="img-responsive" style="max-height:200px; background-color:#FFFFFF"></div>';
	
	$html 		= 	'';
	$html 		.= '<div class="table-responsive">';
	$html		.= '<table ><tr><td style="padding-right:20px; text-align:top; width:20%; center; vertical-align: top;"">';
	$html		.=	$image.'</td><td>';
							
	$html 		.= 		'<p style= "text-align:center;">'.$authorFullName.'<hr style="margin:0px"></p>';
	$html 		.=			'<p>'.$author->profile.'</p>';
	$html 		.=			'<div class="table-responsive"><table>';
	if($author->dob !== null) {
		$yearOfBirth 	=	date('Y',strtotime($author->dob));
		if(($yearOfBirth > 0) && ($yearOfBirth !=1970) ) 
		$html	.=	'<tr>'.$td.'Born:</td>'.$td.$yearOfBirth.'</td></tr>';
	}
	if($author->address != '')
		$html 	.=	'<tr>'.$td.'Lives in:</td>'.$td.$author->address.'</td></tr>';
		
	if($author->url != '')
		$html 	.=	'<tr>'.$td.'Web Site:</td>'.$td.'<a href="'.$author->url.'" target="_blank" rel="nofollow">'.$author->url.'</a><td>';

	if($author->altlink != '')
		$html 	.=	'<tr>'.$td.'More Information:</td>'.$td.'<a href="'.$author->altlink.'" target="_blank" rel="nofollow">'.$author->altlink.'</a><td>';
	
	$html 		.=			'</table></div>';	
	$html 		.=		'</td></tr></table>';
			
	$html		.=		'</div>';
	$html		= '<div class="col-md-1"></div><div class="col-md-10">'.$html.'</div><div class="col-md-1"></div>';
	
	echo 			$panelDiv.$html.'</div></div></div></div>';
	return 'Books by '.$authorFullName;
}

if(($_SESSION['mode']	=='editBook') || ($_SESSION['mode'] == '')) $_SESSION['mode'] = 'default';
//var_dump($booklist);
if($_SESSION['mode']	==	'published')	{
	addPanel($booklist['recent'],'PUBLISHED BOOKS',8,3,'back');
}
elseif($_SESSION['mode']	==	'future')	{
	addPanel($booklist['future'],'COMING SOON',8,3,'back');
}
elseif($_SESSION['mode']	==	'top')	{
	addPanel($booklist['top'],'TOP SEARCHES',8,3,'back');
}
elseif($_SESSION['mode']	==	'search')	{
	addPanel($booklist['search'],'' ,8,3,'back',$searchMsg);
}
elseif($_SESSION['mode']	==	'editorschoice')	{
	addPanel($booklist['editorschoice'],'EDITORS CHOICE' ,8,3,'back');
}
elseif($_SESSION['mode']	==	'favourites')	{
	addPanel($booklist['favourites'],'FAVOURITES' ,8,3,'back');
}
elseif($_SESSION['mode']	== 'author')	{
	$panelTitle =  '<center>'.$authorFullName.'</center>';
	$panelTitle = addAuthorPanel();
	addPanel($booklist['books'],$panelTitle,8,3);	// back button is done in addAuthorPanel
}
elseif($_SESSION['mode']	== 'category')	{
	addPanel($booklist['books'], 'Category: '.$_SESSION['categories'][$_SESSION['search_category']],8,3,'back');
}
if($_SESSION['mode'] == 'default') {
	addPanel($booklist['recent'], 'LATEST PUBLICATIONS',2,3,'' ) ;
	addPanel($booklist['top'], 'TOP SEARCHES',1,3,'top');
	addPanel($booklist['future'], 'COMING SOON',1,3,'top');
	addPanel($booklist['editorschoice'], "EDITOR'S CHOICE",1,3,'top');
	addPanel($booklist['favourites'], "FAVOURITES",1,3,'top');
}

?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 voffset5 nav" style="padding-left:50px;">
		<div class="col-md-4"><a href="javascript:void(0)"  onclick="privacyModal();" >Privacy</a></div>
		<div class="col-md-4"><a href="javascript:void(0)"  onclick="legalModal();">Legal</a></div>
		<div class="col-md-4">
					<a href="mailto:adminstrator@irishinterest.ie"> 
						<span class="glyphicon glyphicon-envelope  orange " 	style="font-size: 20px; text-shadow: black 1px 0px 0px; margin-left:10px;  "
									title="administrator@IrishInterest.ie">
						</span>
					</a>
		</div>
	</div>
	<div class="col-md-3 voffset4 ">
					
		<div class="nav  " >
			<div class="row" style="padding: 0">
				<div class="col-md-10 col-xs-7 col-sm-5" style="padding-right: 0px;  ">
	<!--  Facebook Share 
	<a href="http://www.facebook.com/sharer/sharer.php?u=www.irishinterest.ie&title=Irish Book Interest" 
		onclick="window.open(this.href, 
										'mywin',
										'left=20','top=20','width=500','height=600','toolbar=1','resizable=1'); return false;" >
		<img src="facebook.png" class="image-responsive" style="height:25px;">
	</a>-->
	<!-- Facebook follow  
	<a href="https://www.facebook.com/profile.php?id=100008804209153" target="_blank" style="padding-right: 0px; ">
			<img src="facebook.png" class="image-responsive" style="background-color:grey; height:25px; margin-left:10px; border-radius:2px;" >
	</a>-->
<!-- Google Plus 
<a href="https://plus.google.com/101688982005763255838" target="_blank">
		<img src="googleplus.png" class="image-responsive"  style="background-color:grey; height:25px;margin-left:10px; border-radius:2px;">
</a>-->	

<!-- Youtube
<a href="https://www.youtube.com/channel/UCBVh-eIxXZEfh_BK9r8wwdQ" target="_blank">
		<img src="youtube-2.png" class="image-responsive"  style="background-color:grey; height:25px;margin-left:10px; border-radius:2px;">
</a> -->	

<!--  Twitter tweet  
<a href="http://twitter.com/intent/tweet?status=Irish Interest+www.irishinterest.ie"  target="_blank">
	<img src="twitter.png" class="image-responsive" style="height:25px;">
</a>-->
<!--  Twitter follow 
<a href="http://twitter.com/intent/follow?source=followbutton&variant=1.0&screen_name=Booksirish"  target="_blank">
	
		<img src="twitter.png" class="image-responsive" style="background-color:grey; height:25px;margin-left:10px; border-radius:2px;">
	
</a> -->
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row" style="padding-bottom:120px;"></div>
<div class="modal  fade bs-example-modal-sm" id="book_modal" >
	<div class="modal-dialog"">
		<div class="modal-content"">
			<div class="modal-header" >
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<div class="modal-title">
				<table id="fav">
					<tr>
						<td style="width:300px;">
							<img src="IRISH_INTEREST_text.png" class="img-responsive" style="background-color:#ffffff; height:30px;display:inline; ">
						</td>
						<td class="info_links" style="width:100px;"></td>
						<td style="width:200px;">
							<img src="ii_circle.png" class="img-responsive pull-right" style="background-color:#ffffff; height:70px;display:inline; padding-right:50px;">
						</td>
						</tr>
				</table>
				
				</div>
			</div>
			<div class="modal-body">
				<table id="myTable">
					<tr>
						<td style="width: 600px" class="info_links" ></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
				<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal  fade bs-example-modal-sm" id="authors_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
						aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h1 class="modal-title">
				<img src="IRISH_INTEREST_text.png" class="img-responsive" style="height:30px;display:inline; background-color:#FFFFFF">
				<img src="ii_circle.png" class="img-responsive pull-right" style="height:70px;display:inline; padding-right:50px; background-color:#FFFFFF"></h2>
				</h1>
			</div>
			<div class="modal-body">
				<table id="authorTable">
					<tr>
						<td style="width: 600px"></td>
						<td></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal  fade bs-example-modal-sm" id="event_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
						aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h1 class="modal-title">
					<img src="IRISH_INTEREST_text.png" class="img-responsive" style="height:30px;display:inline; background-color:#FFFFFF">
					<img src="ii_circle.png" class="img-responsive pull-right" style="height:70px;display:inline; padding-right:50px; background-color:#FFFFFF"></h2>
				</h1>
			</div>
			<div class="modal-body">
				<table id="eventTable">
					<tr>
						<td class="info_links" style="width: 600px"></td>
						<td></td>
					</tr>
				</table>
				<table id="eventDetailTable" style="word-wrap:break-word; table-layout: fixed; width: 100%">
					<tr>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="largeModal" class="modal fade" tabindex="-1" role="dialog" 	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="myModalLabel">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h2 class="modal-title">
				<img src="IRISH_INTEREST_text.png" class="img-responsive" style="height:30px;display:inline;  background-color:#FFFFFF"">
				<img src="ii_circle.png" class="img-responsive pull-right" style="height:150px;display:inline; padding-right:50px; background-color:#FFFFFF""></h2>
			</div>

			<form method="post" id="action_submit">
				<div class="modal-body">
				<h3>Welcome to Irish Interest</h3>
					<p>
This site provides you with information on all the latest books
published in Ireland. The site aims to bring information about books
from or about Ireland to the widest possible audience, both in Ireland
and throughout the world.</p>
					<h3>About Us</h3>
					<p>
Irish Interest in based on one very simple idea: to bring the
contents of any Irish bookshop to people everywhere, especially those
outside Ireland who do not have the possibility of keeping abreast of
new books published in Ireland. The Irish Interest web platform is
purely a provider of information about new publications. The aim of the
site is to have every publishing house in Ireland adding their latest
titles as they become available. Hyperlinks to each title bring users of
the site directly to the publisher.&rsquo;s web area or to a sales site
where books can be purchased.
					</p>
					<hr>
				</div>
				<div class="modal-footer">	
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="aboutModal" class="modal fade" tabindex="-1" role="dialog" 	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="myModalLabel">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h2 class="modal-title">
				<img src="IRISH_INTEREST_text.png" class="img-responsive" style="height:30px;display:inline;  background-color:#FFFFFF"">
				<img src="ii_circle.png" class="img-responsive pull-right" style="height:150px;display:inline; padding-right:50px; background-color:#FFFFFF""></h2>
				</h2>
			</div>

			<form method="post" id="action_submit">
				<div class="modal-body">
					<p>
						<h4>What this site is about</h4>
					</p>
<p><i>"EVERY IRISH BOOK EVER"</i> is our motto. </p>
<p>Simply put, our plan is to build this database into a virtual library that contains information about every Irish book ever published.</p> 
<p>Beginning from the time before the Book of Kells and meandering through the centuries right up to the present day, 
	even books that are scheduled for publication in the future can be added.</p> 
<p><a href="login/&register=register" >Join </a>with us and help to build the most comprehensive, easily accessible and user-friendly database that will bring the joy of Irish literature to 
	everyone everywhere.  </p>
<p><a href="mailto:adminstrator@irishinterest.ie"> Send us an e-mail </a>with your suggestions.</p>    

					<hr>
				</div>
				<div class="modal-footer">	
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="legalModal" class="modal fade" tabindex="-1" role="dialog" 	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="myModalLabel">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h2 class="modal-title">
					<img src="IRISH_INTEREST_text.png" class="img-responsive" style="height:30px;display:inline;  background-color:#FFFFFF"">
					<img src="ii_circle.png" class="img-responsive pull-right" style="height:150px;display:inline; padding-right:50px; background-color:#FFFFFF""></h2>
				</h2>
			</div>

			<form method="post" id="action_submit">
				<div class="modal-body">
					<p>
						<h4>Terms & Conditions</h4>
					</p>
<p>Irishinterest.ie, Irishinterest.com, and its owners take no
responsibility for information issued on its site that is posted by
third parties. It is the sole responsibility of the third parties who
utilize the site for publication of any information to ensure that such
information is correct and does not infringe laws and the rights of
others who may be affected by publication of such information. Disputed
material will be removed pending clarification.
					</p>
					<hr>
				</div>
				<div class="modal-footer">	
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


<div id="privacyModal" class="modal fade" tabindex="-1" role="dialog" 	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="myModalLabel">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h2 class="modal-title">
					<img src="IRISH_INTEREST_text.png" class="img-responsive" style="height:30px;display:inline;  background-color:#FFFFFF"">
					<img src="ii_circle.png" class="img-responsive pull-right" style="height:150px;display:inline; padding-right:50px; background-color:#FFFFFF""></h2>
				</h2>
			</div>

			<form method="post" id="action_submit">
				<div class="modal-body">
					<p>
						<h4>Privacy Policy</h4>
					</p>
<p>Irishinterest.ie and its owners strive at all times to preserver the privacy of all personal information stored on its website and servers. Information deemed to be private and confidential will not be communicated to any parties or divulged in any way. 
Cookies and similar technologies
Irishinterest.ie and its owners are not responsible for external data collection entities. Third party sites with access to Irishinterest.ie may be able to acquire or assimilate data. Cookies and similar technologies can be utilized by third parties accessing our site without our knowledge. 

					</p>
					<hr>
				</div>
				<div class="modal-footer">	
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


<div id="showAlphabet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="myModalLabel">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h2 class="modal-title">Click on a Letter</h2>
			</div>
			<div class="modal-body">
				<table id="letterTable">
					<tr>
						<td style="width: 600px" ></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</table>

			</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>

<script>  
$(function ()  
{ $("#contact").popover({title: 'Irish Interest', content: ""});  
});  
</script>
<script>

$(document).ready(function () {
	$('.carousel').carousel({
    interval: 6000
});

$('.carousel').carousel('cycle');
});  
</script>
<script>
/**
 * author: Thierry Koblentz
 * Copyright 2011 - css-101.org 
 * http://www.css-101.org/articles/ken-burns_effect/css-transition.php
 */
!function(){function e()
{m==a&&(m=0),s[m].className="fx",0===m&&(s[a-2].className=""),1===m&&(s[a-1].className=""),m>1&&(s[m-2].className=""),m++}document.getElementById("slideshow").getElementsByTagName("img")[0].className="fx",window.setInterval(e,4e3);var s=document.getElementById("slideshow").getElementsByTagName("img"),a=s.length,m=1}();
</script>
<script type="text/javascript">
function triggerModal() {
 
   /* document.getElementById('the_id').value = avalue; */
 
    $('#largeModal').modal();
 
}
function legalModal() {
    $('#legalModal').modal();
}
function privacyModal() {
    $('#legalModal').modal();
}
function aboutModal() {
    $('#aboutModal').modal();
}
</script>
<script>
function changeContent(id, row, cell, content) {
   var x = document.getElementById(id).rows[row].cells;
    x[cell].innerHTML = content;
/*        */
}

$('#book_modal').on('show.bs.modal', function(e) {
    var bookImg 				= $(e.relatedTarget).data('book-image');
    var bookTitle 			= $(e.relatedTarget).data('book-title');
    var bookAuthor 			= $(e.relatedTarget).data('book-author');
    var bookDate 			= $(e.relatedTarget).data('book-date');
    var bookSynopsis		= $(e.relatedTarget).data('book-synopsis');
    var bookLinkurl			= $(e.relatedTarget).data('book-linkurl');
    var bookLinktext		= $(e.relatedTarget).data('book-linktext');
/*
*/
    var bookCover	 		= $(e.relatedTarget).data('book-cover');
    var bookPages	 		= $(e.relatedTarget).data('book-pages');
    var bookLanguage 	= $(e.relatedTarget).data('book-language');
    var bookIsbn10 			= $(e.relatedTarget).data('book-isbn10');
    var bookIsbn13 			= $(e.relatedTarget).data('book-isbn13');	
    var bookPublisher 		= $(e.relatedTarget).data('book-publisher');
	var bookPublisherUrl 	= $(e.relatedTarget).data('book-publisherurl');
    var bookVendor 		= $(e.relatedTarget).data('book-vendor');
    var bookVendorUrl		= $(e.relatedTarget).data('book-vendorurl');
    var bookAsin				= $(e.relatedTarget).data('book-asin');
    var bookSize				= $(e.relatedTarget).data('book-size');
    var bookID				= $(e.relatedTarget).data('book-id');
    var signedin 				= $(e.relatedTarget).data('signed-in');
    var favourite 				= $(e.relatedTarget).data('favourite');
    var narrative 				= $(e.relatedTarget).data('narrative');

    if(signedin == true) {
        if(favourite == true) {
            var favHtml = '<center><small class="info_links" ><a href="?unfav='+bookID+'">Remove favourite</a></small></center>';
        }
        else {
    		var  favHtml = '<center><small class="info_links" ><a href="?fav='+bookID+'">Add to favourites</a></small></center>';
        }
	   changeContent('fav',0,1,favHtml);
    }
    if(narrative !== '')
        narrativeHtml = '<p>' + narrative + '</p>';
    	var  imgHtml = '<img class="img-responsive" style="background-color:#ffffff; max-width:300px; max-height:250px; float:right;  padding:5px; margin:10px" name="bookImage1" id="bookImage1" ';
  	imgHtml1	= imgHtml + ' src="' + bookImg + '">';	
	changeContent('myTable',0,0,narrative + imgHtml1 + '<h3>' + bookTitle + '</h3><p >by <b class="info_links" >'  + bookAuthor + '</b></p><p>' + bookDate +
			'</p><p>'  + bookSynopsis + '</p> <a href=' + bookLinkurl + ' target="_blank" rel="nofollow">' + bookLinktext + 
			'</a></p>'); 

	var div0	='<div class="table-responsive">';
	div0		= div0 + '<table class="table  table-bordered">';
	div0		= div0 + '<tr><td>Publisher </td><td>'+ bookPublisher + '</td></tr>';
	div0		= div0 + '<tr><td>Language </td><td>'+ bookLanguage +'</td></tr>';
	div0		= div0 + '<tr><td>ISBN10 </td><td> ' + bookIsbn10 + '</td></tr>';
	div0		= div0 + '<tr><td>ISBN13</td><td> ' + bookIsbn13 + '</td></tr>';
	div0		= div0 + '<tr><td>ASIN</td><td> ' + bookAsin + '</td></tr>';

	div0		= div0 + '<tr><td>Publisher\'s web site</td><td class="info_links" ><a href=" ' + bookPublisherUrl 	+ '" target="_blank" rel="nofollow">' +bookPublisher + '</a></td></tr>';
	div0		= div0 + '<tr><td>Link to bookseller</td><td class="info_links" >	  <a href="'  + bookVendorUrl 		+ '" target="_blank" rel="nofollow">' +bookVendor 	+ '</a></td></tr>';

	
	div0		= div0 + '</table></div>';
	changeContent('myTable',4,0,div0); 
	changeContent('myTable',5,0,'<p>' + bookPages+'</p>');  
	changeContent('myTable',6,0,'<p>' + bookCover+'</p>');
	changeContent('myTable',7,0,'<p>' + bookSize +'</p>');
	  
//	changeContent('myTable',7,0,'<p><a href="' + bookPublisherUrl + '" target="_blank">' + bookPublisher + '</a></p>'); 
//	changeContent('myTable',8,0,'<p><a href="' + bookVendorUrl 	  + '" target="_blank">' + bookVendor  	 + '</a></p>');  

});
</script>
<script type="text/javascript">
function triggerInfoModal() {
 
   /* document.getElementById('the_id').value = avalue;*/
 
    $('#infoModal').modal();
 
}
</script> 
<script>
function showContact() {
  $("#contact").hide().removeClass('hidden');
  $("#contact").fadeIn();
}
</script> 
<script>
function dismissContact() {
  $("#contact").hide().addClass('hidden');
}
</script> 
<script>
function dismissMessageBox() {
  $("#messageBox").hide().addClass('hidden');
}
</script>
<script>
$('#showAlphabet').on('show.bs.modal', function (event) {
	var btns = "";
	var letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var letterArray = letters.split("");
	for(var i = 0; i < 26; i++){
		var letter = letterArray.shift(); 
		btns += '<button class="mybtns" onclick="alphabetSearch(\''+letter+'\');">'+letter+'</button>';
		}
		changeContent('letterTable',0,0,btns);  
		console.log("I'm nearly there");
		})

function alphabetSearch(let) {
	console.log("I'm Here");
	window.location="alphabet_search_results.php?letter="+let;
	return false;
}
</script>
<script type="text/javascript">
function showAlphabet() {

    $('#showAlphabet').modal();
 
}
function showAlpha2() {
	  $("#alpha2").hide().removeClass('hidden');
	  $("#alpha2").fadeIn();
	}
function dismissAlpha2() {
	  $("#alpha2").hide().addClass('hidden');
	}
function selectAlpha2(ltr) {
		dismissAlpha2();
	    $('#authors_modal').modal();
	}
	$('#authors_modal').on('show.bs.modal', function(e) {
		
	    var letters		= $(e.relatedTarget).data('link-a');
	    var authors 	= JSON.parse(<?php echo json_encode($authors); ?>);

	    var table = document.getElementById("authorTable");
	    var rowCount = table.rows.length;
	    //console.log(rowCount);
	    for (var x=rowCount-1; x>0; x--) {
		  //  console.log('Deleting Row: ' + x);
	       table.deleteRow(x);
	    }
	    rowCount = 1;
	    selection = '<h4>Author names beginning with the letter ' + letters.substr(0,1).toUpperCase() +'</h4>';
		if(letters == 'all') {
			selection = '<h4>all Authors</h4>';
		}
		    
	    changeContent('authorTable',0,0,selection); 
	    var j = 1;
	    for (i = 0; i < authors.length; i++) {
		 //   console.log(authors[i].indexOf(letter) );
		 	var author = '<a href="?author=' + authors[i][1] + '">' + authors[i][0] + '</a>';
		 	if(letters == 'all')	{
			    row = authorTable.insertRow(j);
			    row.insertCell(0);
		   	 	changeContent('authorTable',j,0,author);
			    j++;
				
			 	}
		 	else {
			 //	console.log(letters + '  ' +authors[i][0]); working on ó 
			  for(k=0; k < letters.length; k++) {
				letter = letters.substring(k,k+1);
				//	  console.log(k + ' ' +escape(letter));
				if(letter !== '') {
				//	authorfirstchar = authors[i][0].substring(0,1);
				//	console.log(k + ' ' +escape(letter) + ' ' + escape(authorfirstchar) );
				//	if( ( (authorfirstchar == letter)  || (authors[i][0].indexOf(letter.toUpperCase()) == 0) ) || ( (escape(authorfirstchar) == escape(letter) ) ) ) {
				 	if ( (authors[i][0].indexOf(letter) ==  0 )  || (authors[i][0].indexOf(letter.toUpperCase()) == 0) )  {
				// 
				//	    console.log(i);
					    row = authorTable.insertRow(j);
				    	row.insertCell(0);
		   		 		changeContent('authorTable',j,0,author);
			    		j++;
				 	}
		    	}
			  }
		 	} 
	    }
		});
</script> 
<script>
	function showEvent() {
   			$('#event_modal').modal();
		}

	function dismissEvent() {
		  $("#event_modal").hide().addClass('hidden');
		}
	function selectEvent(id) {
			dismissEvent();
		    $('#event_modal').modal();
		}
	$('#event_modal').on('show.bs.modal', function(e) {
		var title 			= $(e.relatedTarget).data('event-title');
		var description 	= $(e.relatedTarget).data('event-description');
		var location 		= $(e.relatedTarget).data('event-location');
		var from 			= $(e.relatedTarget).data('event-from');
		var to 				= $(e.relatedTarget).data('event-to');
		var link 			= $(e.relatedTarget).data('event-link');
		var image			= $(e.relatedTarget).data('event-image');
		var author			= $(e.relatedTarget).data('event-author');
		var book			= $(e.relatedTarget).data('event-book');
		console.log('Book Title = '+ book)
   		// the Image 	
   	   	var  imgHtml = '<a href ="' + link +'" target="_blank" rel="nofollow"> <img class="img-responsive" style="min-height:100px; max-height:200px; min-width:100px; max-width:200px; float: right;  padding:5px; margin:10px; background-color:#FFFFFF " name="image" id="image" ';
   	  	imgHtml1	= imgHtml + ' src="' + image + '"></a>';	
		var style1 =  'style="padding-right:10px; padding-bottom:10px;width:15%;vertical-align:top;"';
		var style2 =  'style="padding-right:10px; padding-bottom:10px;width:85%"';
		var table = document.getElementById("eventTable");
	    var rowCount = table.rows.length;
		// clear the table
	    for (var x=rowCount-1; x>0; x--) {
	       table.deleteRow(x);
	    }
		var detailTable = document.getElementById("eventDetailTable");
	    var rowCount = detailTable.rows.length;
		// clear the table
	    for (var x=rowCount-1; x>-1; x--) {
	       detailTable.deleteRow(x);
	       console.log(x);
	    }
	    rowCount = 1;
	    selection = '<a href="' +link+ '" target="_blank" rel="nofollow"><h4>'+ title + '</h4></a>';
		    
	    changeContent('eventTable',0,0,author + ' ' + book + selection +  description); 
   	 	changeContent('eventTable',0,1,imgHtml1);
		    
	    row = eventTable.insertRow(1);
	    row.insertCell(0);
//   	 	changeContent('eventTable',1,0,description);

   	 	row = eventDetailTable.insertRow(0);
   	 	
	    newcell = row.insertCell(0);
	    newcell.className = "eventdetailcell";
	    changeContent('eventDetailTable',0,0,'<table style="table-layout:fixed; word-wrap:break-word; width:100%;">' +
	    	    '<tr><td '+ style1 +'>Where:</td><td '+ style2 +'> ' + location +'</td></tr>' +
	    	    '<tr><td '+ style1 +'>On:</td><td '+ style2 +'> ' + from +'</td></tr>' +
	    	    '<tr><td '+ style1 +'>To:</td><td '+ style2 + '> ' + to + '</td></tr>' +
	    	    '<tr><td '+ style1 +'>Link:</td><td '+ style2 +'> <a href="' + link + '" target="_blank" rel="nofollow">' + link +'</a></td></tr></table>');

//	    row = eventTable.insertRow(3);
//	    row.insertCell(0);
//   	 	changeContent('eventTable',3,0,'<tr><td>On:</td><td> ' + from +'</td></tr>');

//   	 	row = eventTable.insertRow(4);
//	    row.insertCell(0);
 //  	 	changeContent('eventTable',4,0,to);

	   	  	
		// the Link
	//		row = eventTable.insertRow(6);
	//	    row.insertCell(0);
	 //  		changeContent('eventTable',6,0,'<p><a href="' + link 	  + '" target="_blank">' + 'Web Page'  	 + '</a></p>');  
			
	}); 	
</script> 

		 <script>!function(d,s,id){	
			 var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
			 if(!d.getElementById(id)){	
				 js=d.createElement(s);
				 js.id=id;
				 js.src=p+"://platform.twitter.com/widgets.js";
				 fjs.parentNode.insertBefore(js,fjs);
				 }}
		 (document,"script","twitter-wjs");
		 </script> 
<script>
	window.location="#searchresults";
</script>
</body>
</html>
