<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Irish Interest - Find Books From or About Ireland</title>
    
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
 <body role="document" >
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
<script src="/twitter-bootstrap/twitter-bootstrap-v2/js/bootstrap-tooltip.js"></script>  
<script src="/twitter-bootstrap/twitter-bootstrap-v2/js/bootstrap-popover.js"></script>  
    <script type="text/javascript" src="js/bootstrap-progressbar.min.js"></script>
    <div class="container" >
     
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation" style="border-bottom-width:5px">
 		  <div class="pull-left" style="padding-left:20px;">
            
		 	  <ul class="nav navbar-nav ">		  
     			<li><a href="javascript:void(0)" onclick="triggerModal();">Welcome</a></li>
 			  </ul> 
 			
     	  </div>
    
    
      <div class="container container-fluid">
       <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
     
          <div class="navbar-brand">
           <div class="media pull-right">
         	<img src="./trans_white_02.png" class="img-responsive" >
           </div> 
          </div>
       </div>
         
          
<!-- Search input-->
   	  <div class="col-md-10 col-xs-10  col-sm-10" style="padding-top:20px; padding-bottom:20px">
		<form id="searchform" role="form" class="form-horizontal">
		<div class="row">
  		  <div class="input-group input-group-lg" >
		   <span class="input-group-addon" style="border-color:#526629"> 		  
			  <a href="javascript:void(0)" onclick="triggerInfoModal();">
  			   <span class="glyphicon glyphicon-info-sign  orange" 
  				style="text-shadow: black 1px 0px 0px; " title="Using Search">
  			   </span>
  			  </a>
  		  </span>
  		  <input id="searchinput" name="searchinput" placeholder="type your search words here" class="form-control " type="search"
    		 style="border-color: #526629;" value="<?php echo $_GET['searchinput'];?>">
		<!-- Button -->
   		  <span class="input-group-btn">
  		    <button id="searchbtn" name="search" class="btn  btn-custom btn-sm" style="color:white;" type="button">
  			   <span class="glyphicon glyphicon-search  orange" 
  				style="text-shadow: black 1px 0px 0px; " title="Search">
  			   </span>
  		    </button>
  		  </span>
		  </div>
		</div>
 		</form>
      </div>    
          
          
          
       <div class="navbar-collapse collapse">
         <ul class="nav navbar-nav navbar-right">
			
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Publishers<b class="caret"></b></a>
                <ul class="dropdown-menu">
	            	<li><a href="login/">Login</a></li>
    	        	<li><a href="login/&register=register">Register</a></li>
    	        </ul>
    	      </li>
          <!-- img src="./Final Dark Green V.4-200.png" class="img-responsive"-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
</div>  
       <div class="page-header">
      </div>
<div class="row"> <div class="col-md-1">
    <div id="largeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h2 class="modal-title">Welcome to Irish Interest</h2>
                </div>
  
        <form method="post" id="action_submit">     
              <div class="modal-body">
<p>This site provides you with information on all the latest books published in Ireland. The site aims to bring information about books from or about Ireland to the widest possible audience, both in Ireland and throughout the world. 
</p>
<h3>About Us</h3>
<p>Irish Interest in based on one very simple idea: to bring the contents of any Irish bookshop to people everywhere, especially those outside Ireland who do not have the possibility of keeping abreast of new books published in Ireland. The Irish Interest web platform is purely a provider of information about new publications. The aim of the site is to have every publishing house in Ireland adding their latest titles as they become available. Hyperlinks to each title bring users of the site directly to the publisher.&rsquo;s web area or to a sales site where books can be purchased.  
</p>

<p><h4>Terms & Conditions</h4></p>
<p>Irishinterest.ie, Irishinterest.com, and its owners take no responsibility for information issued on its site that is posted by third parties. It is the sole responsibility of the third parties who utilize the site for publication of any information to ensure that such information is correct and does not infringe laws and the rights of others who may be affected by publication of such information. Disputed material will be removed pending clarification. 
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
</div>
<div class="col-md-6" >
 		<img class="img-responsive" alt="" src="./Logo_600.png">
</div>
<div class="col-md-2"></div>
<div class="col-md-2" >
    <div id="myCarousel" class="carousel slide">
    <!-- Carousel items -->
    <div class="carousel-inner">
    <?php 
    $imgActive	= "active ";
    foreach($booklist as $book)	{	
    	if($book->image != "")		{
    		
    ?>
  	 	 <div class="<?php  echo $imgActive; ?>item .fade .in" style="padding-top:50px">
    		<img  class="inline" src="<?php echo "upload/".$book->image;?>" style="height:150px">
  	 	</div>
 <?php 	
 	$imgActive	=	"";
     	}
   }
 ?>      
    </div>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
</div>
</div>
 
<div class="row" >
<div class="col-md-3" > 
</div>
</div>
 
 
 <div class="row" >
<div class="col-md-3" > 
</div>
		</div>

<?php 
//die;
//	$this->booklistmodel->header();
 // 	$this->booklistmodel->searchBar();
   	?>
   	<div class="container-fluid">
   	<div class="container container-pad" >

<!-- Search input
		<form id="searchform" role="form" class="form-horizontal">
		<div class="form-group ">
 		<fieldset>
 		  <label class="col-md-3 control-label text-center" for="searchinput">
  <a href="javascript:void(0)" onclick="triggerInfoModal();">
  <span class="glyphicon glyphicon-info-sign  green" 
  		style="font-size: 20px; text-shadow: black 1px 0px 0px; " title="Using Search">
  </span>
  </a><span > Search for Books</span>
  		  </label>
  		  
  		  <div class="col-md-6">
    		<input id="searchinput" name="searchinput" placeholder="type your search words here" class="form-control input-md" type="search"
    		value="<?php //echo $_GET['searchinput'];?>">
    		
  		  </div>

		<!-- Button -- >
    <div class="tab-pane fade in active" id="h-default-basic">
		  <div class="col-md-3">
		    <button id="searchbtn" name="search" class="btn  btn-custom " style="color:white" type="button">Search</button>
  		  </div>
	</div>
		</fieldset>
 		</form>-->
         <div class="progress">
            <div class="progress-bar" role="progressbar" data-transitiongoal="100" aria-valuemin="50" aria-valuemax="100" >
            </div>
          </div>
<script>
$( "#searchbtn" ).click(function( event ) {
        	   ;
        	   $('.progress .progress-bar').progressbar();
				setTimeout(	window.document.forms["searchform"].submit(),30000);        	  //       	   $.post( "#", $( "#searchform" ) );
        	   });
</script>
          </div>
	</div>
	<!-- start Search Info Modal	-->
    <div id="infoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h2 class="modal-title">Irish Interest</h2>
                </div>
  
        <form method="post" id="action_submit">     
          <div class="modal-body">
          	<h4>Using Search</h4>
			<p>Search works best if you use whole words, separated by spaces, rather than abbreviations</p>
			<p>Click Search while Search field is empty will return you to the newly listed books </p>
          </div>
          <div class="modal-footer">
          		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  </div>
		</form>
          </div>
        </div>
   </div>
<!-- end modal -->
  		  

</div>
   	<?php
if( (isset($_GET['searchinput']))	&& ($_GET['searchinput']	!=	"") )	{
	?>
<div class="row ">
<div class="col-md-2"></div><div class="col-md-8"><h4 class="text-center">
 
        Your search for <strong><i> <?php echo substr($_GET['searchinput'], 0,20)."..." ;?></i></strong> found <?php echo count($booklist);?>  book(s)
		<a href=./>
		<span class="glyphicon glyphicon-remove-circle col-md-offset-1 orange" title="reset" style="font-size: 20px; text-shadow: black 0px 1px 1px;"></span>
		</a></h4>
    </div><div class="col-md-2"></div>
</div>
		 
<?php 
}	else	{	?>


<div class="row">
<div class="col-md-12 col-xs-12 col-sm-12 text-center" >

       <h4><i>
<?php 
       $start 		=	$_SESSION['startRRN'] + 1;
       $end 		=	$start + count($booklist) -1;
       $total		=	$_SESSION['totalRecords'];
       $pageSize	=	$_SESSION['pageSize'];
       $noPages 	=	$total / $pageSize;
       $currentPage	=	$start	/	$pageSize	+1;	
       if(fmod($total, $pageSize)	!=	0)	{
       	$noPages++;
       }
       $pager	=	'
		<nav>
  			<ul class="pagination  pagination-sm">
    			<li><a href="?page=prev&current='.$_SESSION['startRRN'].'"><span aria-hidden="true" style="color:green">&laquo;</span><span class="sr-only">Previous</span></a></li>
       ';
       for($i=1; $i <= $noPages; $i++)	{
       	$active 	=	"";
       	if($i == intval($currentPage))	{
       		$active	=	' class="active"  style="background-color:#000"';
       	}
       	$pager .=	'<li'.$active.'><a href="?page=page&current='.$i.'"><span aria-hidden="true" style="color:green;">'.$i.'</span></a></li>';
       }
       $pager	.=	'
           		<li><a href="?page=next&current='.$_SESSION['startRRN'].'"><span aria-hidden="true" style="color:green">&raquo;</span><span class="sr-only">Next</span></a></li>
			</ul>
		</nav>
';
              	
 /*      if($start > 1)	{
       	$prev	='<a href = "?page=prev&current='.$_SESSION['startRRN'].'">
       	 <span style="font-size: 15px; color: grey; text-shadow: black 1px 0px 0px;" title="Previous page" class="glyphicon glyphicon-chevron-left"></span></a> 
       	 Previous</a>';// &current not used - added for probem with "?page=prev" working intermittent!!
       }
       else	{	*/
       	$prev	=	'';
/*       }
       if($end < $total)	{
       	$next 	=	'<a href = "?page=next&current='.$_SESSION['startRRN'].'"> Next
		<span style="font-size: 15px; color: grey; text-shadow: black 1px 0px 0px;" title="Next page" class="glyphicon glyphicon-chevron-right"></span></a>
       	</a>';// as above (prev)
       }
       else {	*/
       	$next 	=	'';
//       }
       echo '<div class="col-md-3"></div>
       				<div class="col-md-6">'.$prev.' Showing '.$start . ' to '. $end.' of '. $total.' Books' .$next.
       				'</div><div class= "col-md-3"></div></i></h4>';
?>
</div>
<?php echo '<div class="row text-center">'.$pager.'</div>';?>
<div class="col-md-1"></div>

</div>
<?php 
}
?>
 		<div class="col-md-1"></div>
 		<div class="col-md-10">			
  	    <div  class="container-fluid " style="border-radius:4px">
        <div class="container-pad" id="property-listings" style="background-color:#D6E0CC; border:2px solid; border-radius:25px" >
           
<?php 	
   	$row 	=	'';
   	$addrow =	false;
	foreach($booklist as $book){ 
 		if($book->image != "")	{ 
	 		$image	=	"upload/".$book->image;
 		}
 		else {
 			$image	=	"placeholder.jpg";
 		}
 		//var_dump($image);
 		//die;
 		if($book->publisherurl	!=	"")	{
	 		$publisherLink_js	=	$book->publisherurl;
	 		$publisherLink	=	"<a href=".$book->publisherurl.' target="_blank" >'.$book->publisher."</a>";	 		
 		}
 		else 	{
 			$publisherLink	=	$book->publisher;
 		}
 		if($book->vendorurl	!=	"")	{
	 		$vendorLink_js	=	$book->vendorurl;
	 		$vendorLink	=	"<a href=".$book->vendorurl.' target="_blank">'.$book->vendor."</a>";
 		}
 		else {
 			$vendorLink	=	$book->vendor;;
 		}
 		$publishdate_js	=	date('d M Y',strtotime($book->published));
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
 		$row	.=	'
                <div class="col-md-6" > 
                    <!-- Begin Listing -->
					<div class="brdr bgc-fff pad-10  btm-mrg-20 property-listing" style="background-color:rgba(256, 256, 256, .8)">
	                    <div class="media">
                           <div class="pull-left">
   		<a  href="#my_modal" data-toggle="modal" 
  					data-book-vendor		="'.$book->vendor.'" 
  					data-book-date			="'.$publishdate_js.'" 
  					data-book-title			="'.$book->title.'" 
  					data-book-author		="'.$book->author.'" 
  					data-book-synopsis		="'.str_replace('"', '\'',$book->synopsis).'" 
  					data-book-linkurl		="'.$book->linkurl.'"
  					data-book-linktext		="'.$book->linktext.'"
  					data-book-image			="'.$image.'"
 					data-book-publisher		="'.$book->publisher.'"
  					data-book-publisherurl	="'.$publisherLink_js.'"
  					data-book-vendorurl		="'.$vendorLink_js.'"
   					data-book-isbn10		="'.$book->isbn.'"
					data-book-cover			="'.$cover.'"
  					data-book-language		="'.$book->language.'"
  					data-book-isbn13		="'.$book->isbn13.'"
					data-book-pages			="'.$pages.'"
  					>';
 		$row	.=	' 
                           <div class="mg-image">			
						<img src="'.$image.'" class="img-responsive" style="height:250px"></div>
						</div>
		</a>';						
		$row	.=	'	<div class="clearfix visible-sm"></div>
                        <div class="fnt-smaller">
                       	<class="media-heading">';

 		$row	.=	'		<class="media-heading"><small class="pull-right"><a href="#">'.$publisherLink.'</a></small>
							<ul class="list-inline mrg-0 btm-mrg-10 clr-535353">';
/*
 		$row	.=	'	<li>'.$book->published.'</li>
    	                      <li style="list-style: none">|</li>
	                          <li>'.$book->genre.'</li>
                        	  <li style="list-style: none">|</li>
	                     	  <li>'.$book->area.'</li>
	                     	  <li style="list-style: none">|</li>
	                     	  <li>'.$book->isbn.'</li></ul></small>';
 		$row	.=	'	<li>'.$book->published.'</li>
    	                      <li style="list-style: none">|</li>
	                          <li style="font-size: 14px;" ><b><i>'.$book->title.'</b></i> </li></ul>';
 	                     	  */
		
 /*	$row	.=	'	<span style="font-size: 14px;"><b><i>'.$book->title.'</i></b></span>
 	 * 
  */
		$row	.=	'	<pclass="hidden-xs" style="font-size: 14px;" ><b>'.$book->title.'</b><p>'.$publishdate_js.'</p>'. 						
							'<p>'.substr($book->synopsis,0,220); //.'...</p> <a href='.$book->linkurl.' target="_blank">'.$book->linktext.'</a></p>
		$row	.=	'			<div class="media-heading">
								<small><span class="fnt-smaller fnt-arial"><b>Author: '.$book->author.'</b></span>';
/*
*/
		$row	.=	'	<div class="pull-right"><span class="fnt-smaller fnt-lighter fnt-arial"><b>'.$vendorLink.'</b></span></div>';
		$row	.=	'	  </small></div>
						</div>
					</div>
				</div>
			</div>

<div class="modal  fade bs-example-modal-sm" id="my_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h1 class="modal-title">Irish Interest</h1>
      </div>
      <div class="modal-body">

        <!--input readonly type="text" name="bookVendor" value=""/-->
        <!-- style="border: 5px solid red; padding:5px; margin:5px"  img src="" class="img-responsive" style="height:200px" name="bookImage" id="bookImage"-->
      	<table id="myTable" >
			<tr><td style="width: 600px"></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
			</table>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
             
					'; 
 		if($addrow	==	 true)	{
			$addrow	=	false;
			$row	=	'<div class="row">'.$row.'</div>';
			echo $row;
			$row 	=	'';
		}
		else	{
			$addrow	= true;
		}
	}
	if($addrow	==	true)	{
		echo $row;
	}
?></div></div></div>
 <?php echo '<div class="row text-center">'.$pager.'</div>';?>
 
 <div class="container col-md-12">
 	<div class="col-md-2"></div>
 	  <div class="col-md-8">
 		<div id="footer">
				<p class="text-center"><small> This data is licensed to Irish Interest (Demo Site)<br />
				for use strictly within Terms and Conditions.<br />
				Copyright &copy;  - Irish Interest - www.irishinterest.ie<br />
				All Trademarks acknowledged</small></p>
		</div>
	  </div>
	  <div class="col-md-2">
        <div class="media">
    			<img src="./Logo_200.png" style="height:50px" class="img-responsive pull-right"  >
		</div>
	  </div>
</div>
<script>  
$(function ()  
{ $("#example").popover({title: 'Irish Interest', content: "It's so simple to create a tooltop for my website!"});  
});  
</script>
<script>

$(document).ready(function () {
	$('.carousel').carousel({
    interval: 1000
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

$('#my_modal').on('show.bs.modal', function(e) {
    var bookImg 			= $(e.relatedTarget).data('book-image');
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
    var bookLanguage 		= $(e.relatedTarget).data('book-language');
    var bookIsbn10 			= $(e.relatedTarget).data('book-isbn10');
    var bookIsbn13 			= $(e.relatedTarget).data('book-isbn13');	
    var bookPublisher 		= $(e.relatedTarget).data('book-publisher');
	var bookPublisherUrl 	= $(e.relatedTarget).data('book-publisherurl');
    var bookVendor 			= $(e.relatedTarget).data('book-vendor');
    var bookVendorUrl		= $(e.relatedTarget).data('book-vendorurl');
    
 /*   document.getElementById("bookImage").src=bookImg;
     $(e.currentTarget).find('input[name="bookVendor"]').val(bookVendor);
  insRow('myTable',bookVendor);	*/
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
	div0		= div0 + '</table></div>';
	changeContent('myTable',4,0,div0); 
/*	changeContent('myTable',5,0,'<tr><td>ISBN10:</td><td> ' + bookIsbn10)+'</td></tr></table>'; 
	changeContent('myTable',6,0,'ISBN13:');	 
	changeContent('myTable',5,1,bookIsbn10);*/ 
	changeContent('myTable',5,0,'<p>' + bookPages+'</p>');  
	changeContent('myTable',6,0,'<p>' + bookCover+'</p>');
	  
	changeContent('myTable',7,0,'<p><a href="' + bookPublisherUrl + '" target="_blank">' + bookPublisher + '</a></p>'); 
	changeContent('myTable',8,0,'<p><a href="' + bookVendorUrl 	  + '" target="_blank">' + bookVendor  	 + '</a></p>');  
	/*

	changeContent('myTable',1,1,bookAuthor); 
	changeContent('myTable',2,0,bookSynopsis); 
	changeContent('myTable',3,0,bookCover); 
	changeContent('myTable',3,1,bookPages); 
	changeContent('myTable',4,1,bookLanguage); 
	changeContent('myTable',6,1,bookIsbn13);
	changeContent('myTable',8,0,bookVendor);  */
});
</script>
<script type="text/javascript">
function triggerInfoModal() {
 
   /* document.getElementById('the_id').value = avalue;*/
 
    $('#infoModal').modal();
 
}
</script>

</body>
</html>
