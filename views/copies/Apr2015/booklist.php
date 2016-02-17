<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Irish Interest - Find Books From or About Ireland</title>
<meta name="description"
	content="Find books from or about Ireland, Search for Irish Books, Irish Writing, Irish Literature, Irish Books by Location, Irish Books by Placename, Irish Books by Townland, Irish Books Area" />
<meta name="keywords"
	content="Ireland, Irish, Books, Writing, New Irish Writing, Irish Literature, Irish Placenames, Irish Townlands" />
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
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script type="text/javascript" src="js/bootstrap-progressbar.min.js"></script>
<?php
  //var_dump($_SESSION);
  $userMenu = 'PUBLISHER AREA';
  if($_SESSION['accessLevel']		=='10')	{
  	$userMenu =	'
  	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">'.$_SESSION['user'].'</a>
			<ul class="dropdown-menu" style="text-align:left">
			  	<li><a href="admin/">Administration</a></li>
  				<li><a href="publish/">Edit Books</a></li>
  			<li><a href="profile">Profile</a></li>
  				
  				<li><a href="logout">Sign Out</a></li>
  			</ul>';
  
  }
 if( ($_SESSION['accessLevel']		=='1')
   || ($_SESSION['access_level']		== '2'	) )	{
    	$userMenu =	'
  	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">'.$_SESSION['user'].'</a>
			<ul class="dropdown-menu" style="text-align:left">
  				<li><a href="publish/">Edit Books</a></li>
	  			<li><a href="profile">Profile</a></li>
  				<li><a href="logout">Sign Out</a></li>
  			</ul>';
  
  }
  if($_SESSION['accessLevel']		=='3')	{
  	$userMenu =	'
  	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">'.$_SESSION['user'].'</a>
			<ul class="dropdown-menu" style="text-align:left">
  				
  				<li><a href="logout">Sign Out</a></li>
  			</ul>';
  
  }
 
$authors	= $_SESSION['authors'];
$authors	= json_encode($authors);
$link_A=	 formatAuthors();
$catMenu = '';
foreach($_SESSION['categories'] as $id=>$category)	{
	$catMenu .= '<li><a href=?category='.$id.'>'.$category.'</a></li>';
}
$eventMenu 	= '';
if( isset($_SESSION['accessLevel']) && ($_SESSION['accessLevel'] !== '4') ) {			//	Not "Correspondent" type user
	$eventMenu =  '<li><a href="events/">Manage Events</a></li>
							<li class="divider"></li>';
}
 
foreach($_SESSION['events'] as $id=>$event)	{
	$startDate = date('l jS F Y',strtotime($event->date_time_from));
	$startTime = date('g:ia',strtotime($event->date_time_from));
	$startingAt = $startDate. ' at '.$startTime; 	
	if($event->eventimage == '') $image = './placeholder.jpg';
	else $image = 'upload/'.$event->eventimage;
	$authorName = $event->firstname.' '.$event->lastname;
	
	$eventLink 	=' data-event-title 				= "'.$event->title.'"';
	$eventLink 	.=' data-event-description	= "'.$event->description.'"';
	$eventLink 	.=' data-event-location			= "'.$event->location.'"';
	$eventLink 	.=' data-event-from 				= "'.$startingAt.'"';
	$eventLink 	.=' data-event-to 				= "'.$event->date_time_to.'"';
	$eventLink 	.=' data-event-image 			= "'.$image.'"';
	$eventLink 	.=' data-event-link 				= "'.$event->link.'"';
	$eventLink 	.=' data-event-author 			= "'.$authorName.'"';
	$eventLink 	.=' data-event-book 			= "'.$event->booktitle.'"';
	
	$eventMenu .='<li><a  href="#event_modal" data-toggle="modal" '.$eventLink.'> '.$event->title.'</a></li>';
}
?>


<div class="row voffset2" >
	<div class="col-md-7">
		<img alt="" src="homepagebackground-150.png" class="image-responsive">
	</div>
	<div class="col-md-5 primaryMenu voffset6">
		<div class="col-md-2" style="font-size: 16px;">
			<a href="login/&register=register">Join </a>
		</div>
		<div class="col-md-4" style="font-size: 16px;">
			<a href="login/">Sign in</a>
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
		<div class="row" style="background-color: #f3be22; line-height: 2; font-weight: 600;">
			<div class="col-md-3"></div>
			<div class="col-md-9">
				<div class="col-md-3 col-sm-3 col-xs-8 ">
					<span class="pull-right">
						<a href="?home=1">Latest Publications</a> 
					</span>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-3 ">
					<a href="javascript:void(0)" onclick="showAlpha2();">Authors </a>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-6 text-center">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">Categories</a>
						<ul class="dropdown-menu" style="text-align:left">
							<?php  echo $catMenu;?>
						</ul>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-3 ">Forum</div>
				<div class="col-md-1 col-sm-1 col-xs-3 ">
					<span class="pull-right">
						<a href="#" class="dropdown-toggle"data-toggle="dropdown" style="padding-left: 0px">Events</a>
						<ul class="dropdown-menu" style="text-align:left">
							<?php  echo $eventMenu;?>
						</ul>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-8 text-center">What is this site about</div>
				<div class="col-md-1 col-xs-1">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 0px">More</a>
					<ul class="dropdown-menu">
						<li class="dropdown">
							<a href="javascript:void(0)"  onclick="triggerModal();">Welcome</a> <a href="javascript:void(0)" onclick="showContact();">Contact Us</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">

	<div class="search_container"><!-- ALPHA2 Form --><!-- Search input-->
		<div id="alpha2" class="hidden col-md-3 col-xs-8 col-sm-4  alpha2_positioner">
			<form role="form" class="form-horizontal">
				<div class="alert dismiss well well-sm" style="border-radius: 25px;">
					<button type="button" class="close input-group-button" href="javascript:void(0)" onclick="dismissAlpha2();" style="padding-left: 0px">
						<span class="glyphicon glyphicon-remove  orange " style="text-shadow: black 1px 0px 0px;" title="Close"></span>
					</button>

					<fieldset>	
 						<?php  echo $link_A; ?></fieldset>
				</div>
			</form>
		</div>

		<img alt="" src="./images/bookshop01.jpeg" style="max-height: 350px; width: 100%" class="image-responsive">
		<div class="search_positioner">
			<div class="col-md-10 col-xs-10 col-sm-9 col-lg-6" style="padding-bottom: 20px">
				<div class="row">
					<form id="searchform" role="form" class="form-horizontal">
						<div class="input-group">
							<input id="searchinput" size=200 name="searchinput" placeholder="type your search words here" class="form-control simplebox" type="search" 
										value="<?php echo $_SESSION['searchInput'];?>" style="box-shadow: none; border-right: 0px; border-top-left-radius: 25px; border-bottom-left-radius: 25px;">
							<span class="input-group-btn">
								<button id="searchbtn" name="search" class="btn btn-custom " type="submit" 
										style="padding: 1px; 
										border: 6px solid; 
										border-color: #ffffff; 
										border-top-left-radius: 0px; 
										border-top-right-radius: 25px; 
										border-bottom-right-radius: 25px;">
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


$classHidden	=	' class="hidden"';
if($_SESSION['ok'] === 	false) {
	$classHidden	=	"";
}
?>

<div id="contact" <?php echo $classHidden;?>>
	<form role="form" class="form-horizontal">
		<fieldset><!-- Contact  Form -->
			<div class="col-md-2"></div>
			<div class="col-md-8 voffset7">
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
<div class="col-md-10 col-sm-12 col-xs-12 main-panel" >
	<div class="container-fluid" style="border-radius: 4px">
		<div class="container-pad" id="property-listings" style="background-color: #f3be22; border: 0px solid; border-radius: 25px">
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 ">
<?php 
function searchMessage()	{
	return '
		
		<div class="col-md-6" style="background-color:#f3be22; border-radius:25px;">
			<h5 class="text-center ">Your search for 
				<strong><i>'. substr($_SESSION['searchInput'], 0,20).'...</i></strong>
				found '.$_SESSION['totalRecords'].' book(s)
				 <a href=./?reset=1>
						<span class="glyphicon glyphicon-remove-circle col-md-offset-1 orange"	title="reset" style="font-size: 20px; text-shadow: black 0px 1px 1px;"></span>
				</a></h5>
		</div>
';
}
function pager_div()	{
	$total		=	$_SESSION['totalRecords'];

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
    			<li><a href="?page=page&current=1" title="First Page"><span aria-hidden="true" >&laquo;</span><span class="sr-only">First Page</span></a></li>
       ';
	for($i=$pagesRangeStart; $i <= $pagesRangeEnd; $i++)	{
		$active 	=	"";
		if($i == intval($currentPage))	{
			$active	=	' class="active"  style="background-color:#000"';
		}
		$pager .=	'<li'.$active.'><a href="?page=page&current='.$i.'"><span aria-hidden="true">'.$i.'</span></a></li>';
	}
	$pager	.=	'
           		<li><a href="?page=page&current='.intval($noPages).'" title="Last Page">
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
function formatModal($book,$image) 	{
	$publisherLink_js	=	$book->publisherurl;
	$vendorLink_js		=	$book->vendorurl;
	$publishdate_js		=	date('d M Y',strtotime($book->published));

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
	$pages	=	"";
	if($book->pages > 1)	{
		$pages	=	$book->pages." pages";
	}
	$modalLink =	'
  					data-book-vendor		="'.$book->vendor.'" 
  					data-book-date			="'.$publishdate_js.'" 
  					data-book-title			="'.$book->title.'" 
  					data-book-author		="'.$book->author.'" 
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
  					';
	return $modalLink;
}
function formatAuthors()	{

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
}
function formatBook($book)	{
	if($book->publisherurl	!=	"")	{ $publisherLink	=	" - <a href=".$book->publisherurl.' target="_blank" >'.$book->publisher."</a>"; }
	else 	{ $publisherLink	=	' - '.$book->publisher; 		}
	if($book->vendorurl	!=	"")	{ $vendorLink	=	"<a href=".$book->vendorurl.' target="_blank">'.$book->vendor."</a>"; }
	else { $vendorLink	=	$book->vendor;}
	$publishDate 		= date('d M Y',strtotime($book->published));
	$image			 	= formatImage($book);
	$modalLink		= formatModal($book,$image);

	$bookFormatted	= '<div class="col-md-4" style="padding-top:50px;margin-left:0px;">
	                   				  	<div class="media">	
	                   				  	
                           					<div class="pull-left">';																						//	image
	$bookFormatted .= '				<a  href="#book_modal" data-toggle="modal" '.$modalLink.'>';
	$bookFormatted	.=	'					<div class="ii-image">
 														<img src="'.$image.'" class="img-responsive" >
 													</div>
 												</a>
 											</div>
 								  		</div>';																												//	 media

	$bookFormatted	.=			'	<div class="fnt-smaller">';																					//	Title, Author & date
	$bookFormatted	.=	'				<b>'.$book->title.'</b>
												<p fnt-smaller fnt-arial"><b>by: '.$book->author.'</b></p>
												<p class="hidden-xs">'.$publishDate.'	<a href="#">'.$publisherLink.'</a></p> 						
											</div>';																												 

	$bookFormatted	.=	'			<div class="media-heading">
												<small>';	//		Author 
	$bookFormatted	.=	'					<p class="hidden-xs fnt-smaller fnt-lighter fnt-arial"><b>'.$vendorLink.'</b></p>';			//		Vendor
	$bookFormatted	.=	'	  			</small>
											</div>';
											
	$bookFormatted	.=	' 			
										<div class="row" style = "padding-right:50px;padding-top:0px;padding-left:15px;"><small>
											<p class="fnt-arial">'.substr($book->synopsis,0,220).
										'		<a  href="#book_modal" data-toggle="modal" '.$modalLink.'> ...more information </a>
											</p>
										</small></div>
									</div>
						';
	return $bookFormatted;
}
function addPanel($books,$panelTitle, $rowsPerPanel, $colsPerRow, $type = 'book')	{
	$panelDiv =	'<div class="row brdr bgc-fff pad-10  btm-mrg-20 property-listing" style="background-color:rgba(256, 256, 256, .8); border-radius:25px;">
						<div class="row ">
							<div class="text-center"><b><large>'.$panelTitle.'</large></b></div>';
	if($_SESSION['mode'] 	!== 'default') 	{
		$panelDiv		=	$panelDiv.'<div class="pull-right" style="margin-top:0px;"><small>'.pager_div().'</small></div>';
	}

	$panelDiv	.=	'</div>';
	$panelDiv	.=	'<div class="row  " style="padding-bottom:0px;">';
	if(count($books) 	==	0)	echo $panelDiv.'<div class="row text-center"> No Books</div></div>';
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
	echo '</div>';
}
function addAuthorPanel()	{
	$author 					= 	$_SESSION['author'][0];
	$authorFullName 	=	$author->firstname." ".$author->lastname;
	$panelDiv =	'<div class="row  author property-listing" style="background-color:rgba(256, 256, 256, .8); border-radius:25px;">
						<p class="text-center"><b><large>'.$panelTitle.'</large></b></p>'.
						'<div class="row  " style="padding-bottom:0px;">';
	$image		= $author->image == '' ? 	"Placeholder.jpg" : $author->image;
	$image 		= '<div class="ii-image"><img src="'.$image.'" class="img-responsive" ></div>';
	$html 		= '<div class="row">
											<div class="col-md-2 col-xs-12">'.$image.'</div>
											<div class="col-md-10">'.$authorFullName.'<hr style="margin:0px"><p>'.$author->profile.'</p></div>
										</div>';
	$html		= '<div class="col-md-1"></div><div class="col-md-10">'.$html.'</div><div class="col-md-1"></div>';
	echo 			$panelDiv.$row.'<div class="row">'.$html.'</div></div></div></div></div>';
	return 'Books by '.$authorFullName;
}
if($_SESSION['mode'] == 'default') {
	addPanel($booklist['future'], 'TOP SEARCHES',1,3);
	addPanel($booklist['recent'], 'LATEST PUBLICATIONS',2,3 ) ;
	addPanel($booklist['future'], 'COMING SOON',1,3);
	addPanel($booklist['recent'], 'EDITORS CHOICE',1,3);
}
elseif($_SESSION['mode']	==	'search')	{
	addPanel($booklist, $searchMsg,4,3);
}
elseif($_SESSION['mode']	== 'author')	{
	$panelTitle =  '<center>'.$authorFullName.'</center>';
	$panelTitle = addAuthorPanel();
	addPanel($booklist['books'],$panelTitle,4,3,'');
}
elseif($_SESSION['mode']	== 'category')	{
	addPanel($booklist['books'], 'Category: '.$_SESSION['categories'][$_SESSION['search_category']],4,3);
}

?>
				</div>
<?php
echo 		'<div class="row" style="padding-left:50px;">'.$pager.'</div>';
?>
			</div>
		</div>
	</div>
	<div class="col-md-4"></div>
	<div class="col-md-7">
		<ul class="nav navbar-nav navbar-right voffset3">
		<!-- Go to www.addthis.com/dashboard to customize your tools -->
			<div class="row" style="padding: 0">
				<div class="col-md-10 col-xs-7 col-sm-5" style="padding-right: 0px">
					<div class="addthis_horizontal_follow_toolbox"></div>
				</div>
				<div class="col-md-1 col-xs-1" style="padding-top: 10px; padding-left: 2px">
					<a href="mailto:adminstrator@irishinterest.ie"> 
						<span class="glyphicon glyphicon-envelope  orange" 	style="text-shadow: black 1px 0px 0px;"
									title="administrator@IrishInterest.ie">
						</span>
					</a>
				</div>
			</div>
		</ul>
	</div>

<div class="modal  fade bs-example-modal-sm" id="book_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h1 class="modal-title">Irish Interest</h1>
			</div>
			<div class="modal-body">
				<table id="myTable">
					<tr>
						<td style="width: 600px"></td>
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
				<h1 class="modal-title">Irish Interest - Authors</h1>
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
				<h1 class="modal-title">Irish Interest - Event</h1>
			</div>
			<div class="modal-body">
				<table id="eventTable">
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

<div id="largeModal" class="modal fade" tabindex="-1" role="dialog" 	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="myModalLabel">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h2 class="modal-title">Welcome to Irish Interest</h2>
			</div>

			<form method="post" id="action_submit">
				<div class="modal-body">
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
						<td style="width: 600px"></td>
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
{ $("#contact").popover({title: 'Irish Interest', content: "It's so simple to create a tooltop for my website!"});  
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
    
   	var  imgHtml = '<img class="img-responsive" style="height:200px; float:right;  padding:5px; margin:10px" name="bookImage1" id="bookImage1" ';
  	imgHtml1	= imgHtml + ' src="' + bookImg + '">';	
	changeContent('myTable',0,0,imgHtml1 + '<h3>' + bookTitle + '</h3><p>by <b>'  + bookAuthor + '</b></p><p>' + bookDate +
			'</p><p>'  + bookSynopsis + '</p> <a href=' + bookLinkurl + ' target="_blank">' + bookLinktext + 
			'</a></p>'); 

	var div0	='<div class="table-responsive">';
	div0		= div0 + '<table class="table  table-bordered">';
	div0		= div0 + '<tr><td>Publisher </td><td>'+ bookPublisher + '</td></tr>';
	div0		= div0 + '<tr><td>Language </td><td>'+ bookLanguage +'</td></tr>';
	div0		= div0 + '<tr><td>ISBN10 </td><td> ' + bookIsbn10 + '</td></tr>';
	div0		= div0 + '<tr><td>ISBN13</td><td> ' + bookIsbn13 + '</td></tr>';
	div0		= div0 + '<tr><td>ASIN</td><td> ' + bookAsin + '</td></tr>';
	div0		= div0 + '</table></div>';
	changeContent('myTable',4,0,div0); 
	changeContent('myTable',5,0,'<p>' + bookPages+'</p>');  
	changeContent('myTable',6,0,'<p>' + bookCover+'</p>');
	  
	changeContent('myTable',7,0,'<p><a href="' + bookPublisherUrl + '" target="_blank">' + bookPublisher + '</a></p>'); 
	changeContent('myTable',8,0,'<p><a href="' + bookVendorUrl 	  + '" target="_blank">' + bookVendor  	 + '</a></p>');  

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
<script type="text/javascript"
	src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545647774ceb5f15"
	async="async">
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
		
	    var letter		= $(e.relatedTarget).data('link-a');
	    var authors 	= JSON.parse(<?php echo json_encode($authors); ?>);

	    var table = document.getElementById("authorTable");
	    var rowCount = table.rows.length;
	    console.log(rowCount);
	    for (var x=rowCount-1; x>0; x--) {
		    console.log('Deleting Row: ' + x);
	       table.deleteRow(x);
	    }
	    rowCount = 1;
	    selection = '<h4>Author names beginning with the letter ' + letter +'</h4>';
		if(letter == 'all') {
			selection = '<h4>all Authors</h4>';
		}
		    
	    changeContent('authorTable',0,0,selection); 
	    var j = 1;
	    for (i = 0; i < authors.length; i++) {
		 //   console.log(authors[i].indexOf(letter) );
		 	var author = '<a href="?author=' + authors[i][1] + '">' + authors[i][0] + '</a>';
		 	if(letter == 'all')	{
			    row = authorTable.insertRow(j);
			    row.insertCell(0);
		   	 	changeContent('authorTable',j,0,author);
			    j++;
				
			 	}
		 	else {
			 	if ((authors[i][0].indexOf(letter) ==  0 )  || (authors[i][0].indexOf(letter.toUpperCase()) == 0)){
			    console.log(i);
			    row = authorTable.insertRow(j);
			    row.insertCell(0);
		   	 	changeContent('authorTable',j,0,author);
			    j++;
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
   	   	var  imgHtml = '<img class="img-responsive" style="height:100px; float:right;  padding:5px; margin:10px" name="image" id="image" ';
   	  	imgHtml1	= imgHtml + ' src="' + image + '">';	
		var style1 =  'style="padding-right:10px; padding-bottom:10px;"';
	    var table = document.getElementById("eventTable");
	    var rowCount = table.rows.length;
		// clear the table
	    for (var x=rowCount-1; x>0; x--) {
	       table.deleteRow(x);
	    }
	    rowCount = 1;
	    selection = '<h4>'+ title + '</h4>';
		    
	    changeContent('eventTable',0,0,author + ' ' + book + selection +  description); 
   	 	changeContent('eventTable',0,1,imgHtml1);
		    
	    row = eventTable.insertRow(1);
	    row.insertCell(0);
//   	 	changeContent('eventTable',1,0,description);

   	 	row = eventTable.insertRow(2);
	    row.insertCell(0);
	    changeContent('eventTable',2,0,'<table><tr><td '+ style1 +'>Where:</td><td '+ style1 +'> ' + location +'</td></tr><tr><td '+ style1 +'>On:</td><td '+ style1 +'> ' + from +'</td></tr></table>');

	    row = eventTable.insertRow(3);
	    row.insertCell(0);
//   	 	changeContent('eventTable',3,0,'<tr><td>On:</td><td> ' + from +'</td></tr>');

   	 	row = eventTable.insertRow(4);
	    row.insertCell(0);
 //  	 	changeContent('eventTable',4,0,to);

	   	  	
		// the Link
	//		row = eventTable.insertRow(6);
	//	    row.insertCell(0);
	 //  		changeContent('eventTable',6,0,'<p><a href="' + link 	  + '" target="_blank">' + 'Web Page'  	 + '</a></p>');  
			
	}); 	
</script> 

</body>
</html>
