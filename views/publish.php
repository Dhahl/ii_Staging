<!DOCTYPE HTML>
<html>
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
<script src="http://code.jquery.com/jquery-1.8.2.min.js" charset="utf-8"></script>
 </head>
 <body role="document">
<?php 
 if($_SESSION['mode'] =='editBook')	
 	$heading = ' Edit Book';
else $heading = 'Add a Book'; 	

$hdg	=	"";
if(!$_SESSION['userPublisher']	==	"")	{
	$hdg	.=	$_SESSION['userPublisher'];
}
else	{
	$hdg	.=	$_SESSION['userFirstName'].' '.$_SESSION['userLastName'];
}

$userMenu =	'
   			<button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown" 
    				style="border-radius: 10px; font-weight:900;">'
  					.$_SESSION['user'].'
    				<span class="caret"></span>
    		</button>';
 if($_SESSION['accessLevel']		=='10')	{
  	$userMenu .=	'

  	  	<ul class="dropdown-menu" style="text-align:left">
		  	<li><a href="../admin/">Publishers</a></li>
		  	<li><a href="../categories/">Categories</a></li>
		  	<li><a href="../banner/">Banners</a></li>
		 	<li><a href="../utilities/">Utilities</a></li>
		  	<li class="divider"></li>
		  	<li><a href ="#">Add Books / Edit Books</a></li>
  			<li><a href="../authors/">Author Profiles</a></li>
  			<li><a href="../profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
			<li class="divider"></li>
 			<li><a href="../?home=1">Home Page</a></li>
			<li><a href="../logout">Sign Out</a></li>
  			</ul>';
  
  }
 if( ($_SESSION['accessLevel']		=='1')
   || ($_SESSION['accessLevel']		== '2'	) )	{
  	$userMenu .=	'
  	  	<ul class="dropdown-menu" style="text-align:left">
  			<li><a href="#">Add Books / Edit Books</a></li>
  			<li><a href="../authors/">Author Profiles</a></li>
  			<li><a href="../profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
			<li class="divider"></li>
 			<li><a href="../?home=1">Home Page</a></li>
  			<li><a href="../logout">Sign Out</a></li>
  			</ul>';
  }
 if($_SESSION['accessLevel']		=='3')	{
  	$userMenu .=	'
			<ul class="dropdown-menu" style="text-align:left">
  				<li><a href="../logout">Sign Out</a></li>
  			</ul>';
  }
$bookAuthors	=	$_SESSION['author'];
$authCount	= count($bookAuthors);0;

$authors		= $_SESSION['authors'];		// **** loaded by booklist model: Id => Name
/*$authorIDs = explode(',', $_SESSION['authorid']);
foreach($authorIDs as $id) {
	foreach($authors as $idx=>$author) {
		if($id == $author[1]) {
			$authors[$idx][2]='checked'; 
		}
	}
}
*/
/*
foreach($authors as $idx=>$author) {
	echo $author[0].' '.$author[1].' '.$author[2].'<br>';
}
*/
//foreach($authors as $author) { echo $author[0].$author[1].'<br>';}
$authors	= json_encode($authors);
//echo $authors;
//die;
$link_A=	 formatAuthors();

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

function pager_div()	{
	
	$total		=	$_SESSION['totalRecords'];

	$start 		=	$_SESSION['publisher_startRRN'] + 1;
	$end 		=	$start + $_SESSION['publisher_pageSize'] -1;
	if($end > $total) $end = $total;

	if($total		<	$_SESSION['publisher_pageSize'])	return ' Showing '.$start . ' to '. $end.' of '. $total.' Books' ;
	
	$pageSize	=	$_SESSION['publisher_pageSize'];
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
?>  
<div class="modal  fade bs-example-modal-sm" id="authors_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
						aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h1 class="modal-title" style="color:#526629;">Irish Interest - Select Authors</h1>
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>
  
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

<!-- Book Details Form ***Start*** -->      
<div class="col-md-1  col-sm-1 col-xs-12"></div>
<div class="col-md-10 col-sm-10 col-xs-12 event-panel" > 
	<div class="container-fluid" style="border-radius: 4px">
		<div class="container-pad greenlinks" id="property-listings" style="background-color: #f3be22; border: 0px solid; border-radius: 25px">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 ">
  							<div class="col-md-8">
  								 <div class="well well-sm" style="border-radius:25px">
  				<?php echo displayMessage();?>
 								 	<h4  class="text-center"><?php echo $heading;?></h4><br/>
								<form role="form" enctype="multipart/form-data" method="post" class="form-horizontal input-append" >
										<fieldset>

<!-- Title -->	
<div class="form-group <?php echo $titleErr ; ?>" style="padding-top:25px; padding-right:25px">
  <label class="col-md-2 col-sm-2 col-xs-12 ii_label control-label control-label.has-error" for="title">Title</label>  
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
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="author">Author(s)</label>  
  <div class="col-md-10 col-sm-10 col-xs-10">
  <div class="required-field-block">
         <div class="control-group " id="fields">
            <div class="controls" id="profs">
            	 <div id="field">
  			 		<div id="author_position_start"></div>
  			 		<div id="author_position_end"></div>
				</div> 
		</div>
		</div>
  
  <!--  Dynamic Form Fields (Bootsnip origin) -->
  		<input type="hidden" name="count" value="1" />
  <!-- 	End Dynamic Form Fields 	-->  
  
 <!-- input type="hidden" id="authorid" name="authorid" value="<?php //echo $_SESSION['authorid'];?>"> -->
 
 <span class="help-inline"><?php echo $authorMsg; ?></span>
    </div>
</div>
 <div class="alpha2_container">
		<div id="alpha2" class="hidden col-md-3 col-xs-8 col-sm-4  alpha2_positioner" style="border-radius:25px;">
			<form role="form" class="form-horizontal">
				<div class="alert dismiss well well-sm" style="border-radius: 25px; margin-top:20px;">
					<button type="button" class="close input-group-button" href="javascript:void(0)" onclick="dismissAlpha2();" style="padding-left: 0px">
						<span class="glyphicon glyphicon-remove  orange " style="text-shadow: black 1px 0px 0px;" title="Close"></span>
					</button>

					<fieldset style="text-center;">	
 						<?php  echo $link_A; ?></fieldset>
				</div>
			</form>
		</div>
</div>
</div>
<!-- Synopsis -->
<div class="form-group <?php echo $synopsisErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="synopsis">Synopsis</label>
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
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="area"> Tags</label>  
  <div class="col-md-10 col-xs-10">
  <div class="required-field-block">
  <input id="area" name="area" placeholder="Place name, County, Town, Persons, Events" class="form-control input-md" type="text"
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
  <label class="col-md-2 col-sm-2 control-label col-xs-12" for="genre">Category</label>  
  <div class="col-md-10 col-xs-10">
  <div class="input-group">
  <input id="genre" name="genre" placeholder="choose  a category from the dropdown list..." class="form-control input-md" type="text" readonly autocomplete="off"
  	value="<?php echo $_SESSION['genre'] ; ?>">
  <span class="help-inline"><?php echo $genreMsg; ?></span>

	<div class="input-group-btn">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
			name="categories" id="categories" >
		<span class="caret" style="height:20px;"></span>
		</button>
		<ul class="dropdown-menu-A dropdown-menu-right-A" role="menu" aria-labelledby="dropdownMenu">
<?php 
foreach($_SESSION['categories'] as $name=>$id)	{
	echo '<li> <a tabindex="-1" href="#">'.$name.'</a></li>';
}
?>
		</ul>
	</div>  <!--  input group button -->
  </div>
  </div>
</div>
<input type="hidden" id="categoryid" name="categoryid" value="<?php echo $_SESSION['categoryid'];?>">
<script>
$(function(){
	  $(".dropdown-menu-A li a").click(function(){
		document.getElementById('genre').value = $(this).text();
		var name = document.getElementById('genre').value ;
		var arrCategory = JSON.parse( '<?php 
			echo json_encode($_SESSION['categories']);
		?>' );
		document.getElementById('categoryid').value = arrCategory[name];
			  });
	});
</script>
<!--  New Date -->
<div class="row" style="padding-bottom:15px;">
<div class="col-md-8 col-sm-8 col-xs-7" style="padding:0px; padding-bottom:20px; margin:0px;">
<div class="form-group <?php echo $publishedErr ; ?>"> 
  	<label class="control-label col-md-2 col-sm-2 col-xs-12 published_label" for="date" >Published</label> 
	<div class="col-md-8  col-sm-8 col-xs-12 published_date" ><!--  -->
	  <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3" style="padding:0; margin:0"> <!-- day -->
   		<input id="day" type="text" value="<?php echo $day;?>"  name="day" class="form-control input-md"  style="padding:2; margin:0">
     </div>
      <div class="col-md-4 col-sm-3 col-xs-4" style="padding:0; margin:0"> <!--  month -->
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
      <div class="col-lg-4 col-md-5 col-sm-4 col-xs-4" style="padding-left:0; margin:0; margin-left:-1px"> <!--  year -->
        <input id="year" type="text" value="<?php echo $year;?>"  name="year" class="form-control input-md"  style="padding:4; margin-left:5" 
        	data-max="<?php echo 2100; //$thisYear;?>">
    </div>
   </div>

   	<div class="col-md-2"></div><span class="help-inline col-md-10"><?php echo $publishedMsg; ?></span>
</div>
<!--  Pages-->
<div class="form-group <?php echo $pagesErr ; ?>" > 
  	<label class="control-label col-md-2  col-sm-2 col-xs-12 pages_label"  for="pages" >Pages</label>  
	<div class="col-md-3 col-sm-3 col-xs-8 pages_field"  >
   		<input id="pages" type="text" value="<?php echo $_SESSION['pages'];?>"  name="pages" class="form-control input-md "  >
   	</div>
</div>
<!-- Language -->
<div class="form-group <?php echo $languageErr ; ?>" > 
	<label class="control-label col-md-2 col-sm-2 language_label"  for="language" >Language</label>
  	<div class="col-md-6 col-sm-4 language_field">
    	<input id="Language" name="language" placeholder="English, Irish, ..." class="form-control input-md"
    			value="<?php echo $_SESSION['language'];?>" type="text" >
  	</div>
</div>
</div>
<!-- Cover -->
<div class="col-md-4 col-sm-4 col-xs-7 cover" >
	<div class="col-md-12" style="border:1px solid #C0C0C0; border-radius:5px; padding-bottom:24; margin-left:7px;">
		<div class="controls">
			<label class="checkbox   small" for="checkboxes-0">
				<input name="hardback" id="hardback" value="1" type="checkbox" <?php echo ($_SESSION['hardback']) ? "checked" : '';?>>Hardback
			</label>
			<label class="checkbox   small" for="checkboxes-1">
				<input name="paperback" id="paperback" value="1" type="checkbox" <?php echo ($_SESSION['paperback']) ? "checked" : '';?>>Paperback
		    </label>
			<div class="form-group-sm">
		     	<div class="col-md-5" style="padding-left:0px;">
			    	<label class="checkbox   small" for="checkboxes-2">
			    		<input name="ebook" id="ebook" value="1" type="checkbox" <?php echo ($_SESSION['ebook']) ? "checked" : '';?>>e-Book
    				</label>
				    <label class="checkbox   small" for="checkboxes-3">
			    		<input name="audio" id="audio" value="1" type="checkbox" <?php echo ($_SESSION['audio']) ? "checked" : '';?>>Audio
				    </label>
    			</div>
   				<div class="col-md-7" style="padding-right:1px;">
			    	<label class="control-label small" >Size (Kb)</label>
			    	<input class="form-control input-sm" name="ebooksize" id="ebooksize" type="text" placeholder ="e.g. 1.5" value="<?php echo $_SESSION['ebooksize']; ?>">
   				</div>
			</div>
  		</div>
  	</div>
</div>
</div>

<!-- ISBN10 -->	
<div class="form-group <?php echo $isbnErr ; ?>" style="padding-right:25px"> 
  <label class="col-md-2 col-sm-2 col-xs-4 control-label" for="isbn">ISBN10</label> 
  <div class="col-md-10 col-xs-10">
  	<div class="col-md-3 col-sm-3" style="padding-left:0px">
  		<input id="isbn" name="isbn" placeholder="ISBN10" class="form-control input-md" type="text"
 		 	value="<?php echo $_SESSION['isbn'] ; ?>">
 		 <span class="help-inline"><?php echo $isbnMsg; ?></span>
 	</div>

<!-- ISBN13 -->	
 	 <label class="col-md-2  col-sm-2 control-label isbn13_label"  for="isbn13">ISBN13</label>  
 	 <div class="col-md-3 col-sm-3 isbn13_field" >
 		 <input id="isbn13" name="isbn13" placeholder="ISBN13" class="form-control input-md" type="text"
  			value="<?php echo $_SESSION['isbn13'] ; ?>">
  		<span class="help-inline"><?php echo $isbn13Msg; ?></span>
  	 </div>

<!-- ASIN  -->	
  <label class="col-md-1  col-sm-2 control-label" style="margin-left:-12px;" for="asin">ASIN</label>  
  	<div class="col-md-3 col-sm-3 asin_field" >
  	 	<input id="asin" name="asin" placeholder="ASIN" class="form-control input-md" type="text"
  			value="<?php echo $_SESSION['asin'] ; ?>">
  		<span class="help-inline"><?php echo $asinMsg; ?></span>
  	</div>
  </div>
</div>

<!-- Publisher -->
<div class="form-group <?php echo $publisherErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="publisher">Publisher</label>  
  <div class="col-md-10 col-sm-10 col-xs-10">
  <div class="input-group " >
  	<input id="publisher" name="publisher" placeholder="Publishing house, company name" class="form-control input-md" type="text" autocomplete="off"
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
	echo '<li> <a tabindex="-1" href="#genre">'.$name.'</a></li>';
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
		var arrPublishers = JSON.parse( `<?php 
			echo json_encode($_SESSION['publishers']);
		?>` );
		document.getElementById('publisherurl').value = arrPublishers[name];
			  });

	});
</script>

<!-- Publisher url -->
<div class="<?php echo $publisherUrlErr; ?>">
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="publisherurl"> <i>url</i></label>  
  <div class="col-md-10 col-sm-10 col-xs-10">
  <input id="publisherurl" name="publisherurl" placeholder="http://www. ..." class="form-control input-md" type="url"
  	value="<?php echo $_SESSION['publisherurl']; ?>">
  <span class="help-inline"><?php echo $publisherUrlMsg ; ?></span>
  </div>
</div>

</div>
<!-- Vendor Name Link Text -->
<div class="form-group <?php echo $vendorErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="vendor">Vendor</label>
  <div class="col-md-10 col-sm-10 col-xs-10">                     
    <input id="vendor" name="vendor" placeholder="name" class="form-control input-md" type="text"
value="<?php echo $_SESSION['vendor'] ; ?>">
  <span class="help-inline"><?php echo $vendorMsg; ?></span>
  </div>

<!-- Vendor URI -->
<div  class="<?php echo $vendorUrlErr ; ?>">
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="vendorurl"><i>url</i></label>
  <div class="col-md-10 col-sm-10 col-xs-10">                     
    <input id="vendorurl" name="vendorurl" placeholder="http://www. ..." class="form-control input-md"  type="url"
value="<?php echo $_SESSION['vendorurl']; ?>">
  <span class="help-inline"><?php echo $vendorUrlMsg; ?></span>
  </div>
</div>
</div>

<!-- Generic Link Text -->
<div class="form-group <?php echo $linkTextErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-sm-2 col-xs-12 control-label"  for="linktext">
  	More Info
  	</label>
  <div class="col-md-10 col-sm-10 col-xs-10">                     
    <input id="linktext" name="linktext" placeholder="text entered here will be appended to the book synopsis" class="form-control input-md" type="text"
			style="padding-right:0px; margin-right:0px;" value="<?php echo $_SESSION['linktext'] ; ?>">

  <span class="help-inline"><?php echo $linkTextMsg; ?></span>
  </div>

<!-- Generic URI -->
<div  class=" col-md-12  col-sm-12 <?php echo $linkUrlErr ; ?>" style="padding-left:0px; margin-left:0px; padding-right:0px; margin-right:0px;">
  <label class="col-md-2 col-sm-2 col-xs-10 control-label" for="linkurl">
      <a href="javascript:void(0)" onclick="triggerInfoModal();">
  	<span class="glyphicon glyphicon-info-sign" title="what's this?" style="margin:0px; padding:0px"></span>
  	</a> <i>url</i>
</label>
  <div class="col-md-10 col-sm-10 col-xs-10">                     
    <input id="linkurl" name="linkurl" placeholder="http://www. ..." class="form-control input-md"  type="url"
value="<?php echo $_SESSION['linkurl'] ; ?>">
  <span class="help-inline"><?php echo $linkUrlMsg; ?></span>
  </div>
</div>
</div>

<!-- Image -->	
 <div class="form-group <?php echo $imageErr ; ?>" style="padding-right:25px">
  <label class="col-md-2 col-sm-2 col-xs-12 control-label" for="Image">Image</label>
  <div class="col-md-10 col-xs-10">   
  <?php
  if($_SESSION['mode'] =='editBook')	{	
  	$image	=	"../upload/".$_SESSION['image']; ?>
	<div class="col-md-12" style="padding:0">
		<img src="<?php echo $image;?> " class="img-responsive" style="max-height:100px; width:auto; background-color:#FFFFFF" >
	</div> 
<?php  }  ?>                  
     <div class="control-group col-md-7">  
     	 
            <div class="controls" style="padding-bottom:25px; padding-top:25px">  
              <input class="input-file" id="image" name="image" type="file" >  
  				<span class="help-inline" style="color:800000"><?php echo $imageMsg;  ?></span>
            </div>  
     </div>
   </div>
   </div>
     <?php if($_SESSION['accessLevel']	== 10)	{?>
   <div class="form-group" style="padding-right:25px">
    <div class="col-md-2 ">
   			<label class="   small" for="editorschoice">Editors Choice			</label>
				<input name="editorschoice" id="editorschoice" value="1" type="checkbox" <?php echo ($_SESSION['editorschoice']) ? "checked" : '';?>>
   	 </div>
   	 <div class="col-md-10">
 		<textarea class="form-control" id="editorschoicenarrative" name="editorschoicenarrative" placeholder="Ed. - Why this book..">
<?php echo $_SESSION['editorschoicenarrative'] ; ?></textarea>
 
   	 </div>
   </div>
   	 <?php } ?>
   
<!-- Buttons -->	        
<div class="col-md-6"></div>
    
 <div class="col-md-6 pull-right">                     
      <button name="save" value="book" type="submit" class="btn btn-primary pull-right">Save</button>  
<?php  

$modalBody	=	" Click OK to continue or Cancel";
if($_SESSION['mode']	=='editBook')      {	?>
 <!-- DELETE BUTTON	-->
    <button type="button" class="btn btn-danger" onClick="triggerModal('<?php echo $book->id ; ?>')">Delete
    </button> 
 <!-- Cancel -->	        
      <button name="cancel" value="book" type="submit" class="btn btn-default ">Cancel</button>  
 
<?php } ?>

    <div id="largeModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h4 class="modal-title">Delete <?php echo $_SESSION['title'];?></h4>
                </div>
  
        <form method="post" id="action_submit" action="./?delete">     
              <div class="modal-body"><?php echo $modalBody;?>
                     <input type="hidden" name="titleId" id="the_id" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button name="delete" type="submit" class="btn btn-success btn-primary" value="<?php echo $_SESSION['bookID'];?>"><?php echo 'OK' ;?></button>

                </div>
              </form>
           </div>
        </div>
    </div>
  </div>

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
				
			
	
<!-- Collapsible Form ***END*** -->      

<?php 
$_SESSION['err']	=	array();
unset($_SESSION['ok']);
$this->publishmodel->resetSession();
/*var_dump($_SESSION);
die;
*/
?>


     <div class=" col-md-4" style="padding-right:0px">
   	    

 
  <div class="well well-sm" style="border-radius:25px">
  <h4 class="text-center">My Books</h4>

        <div class="" id="property-listings">
  			<div class="bodycontainer scrollable" style="background-color:#e8e8e8">
 
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
		?>
                <div class="col-md-12"> 
                    <!-- Begin Listing -->
                    <div class="brdr bgc-fff  box-shad btm-mrg-2 property-listing" style="padding-right:10px">
                        <div class="media">
                           <div class="pull-left"><a href="../publish/&edit?id=<?php echo $book->id;?>">
						<img src="<?php echo $image;?>" class="img-responsive"  style="height:50px; width:auto; background-color:#FFFFFF"></a></div>
                        <div class="clearfix visible-sm"></div>
                        <div class="media-body fnt-smaller">
                        	<div class="media-heading">
                        	<small class="pull-right"><?php echo $book->publisher;?></small>
							<small>
								<ul class="list-inline mrg-0 btm-mrg-10 clr-535353">
        	                  		<li><?php echo $book->published;?></li>
    	                      		<li style="list-style: none"></li>
    	                      	</ul>
                          		<span style="font-size: 14px;"><?php echo $book->title;?></span>
                        	  				
								<div class="col-md-12"><span class="fnt-arial"><b><?php echo $book->author;?></b></span></div>
							
							</small>
						</div>
							<span class="pull-right  fnt-arial" >
<?php echo '
							
<!-- EDIT LINK	-->							
<a href="../publish/&edit?id='.$book->id.'">
<span style="font-size: 20px; text-shadow: black 1px 0px 0px;" title="Edit" class="glyphicon glyphicon-book"></span></a>


<!--Book Id - hidden -->
  <input id="bookId" name="bookId" class="hidden" type="text" value="'.$book->id.'"/> 
			</span>
						</div>
						</div>
					</div>
					</div>

					';
			}
echo '</div></div></div>';
$pager = pager_div(); 
echo 		'<div class="row" >'.$pager.'</div>';

			echo '</div></div>';

echo '<div class="col-md-12 col-sm-12 col-xs-12" id="footer">
      <div class="container">
 
				<p class="text-center">This data is licensed to Irish Interest<br />
				for use strictly within Terms and Conditions.<br />
				Copyright &copy;  - Irish Interest - www.irishinterest.ie<br />
				All Trademarks acknowledged</p></div>
		</div></div>';
  ?>
</div></div>
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
function formatAuthors()	{

	return	'Show <a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"all">all Authors</a><br> or Filter by:<br>
	<center><a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"A">A</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"B">B</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"C">C</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"D">D</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"E">E</a><br>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"F">F</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"G">G</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"H">H</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"I">I</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"J">J</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"K">K</a><br>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"L">L</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"M">M</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"N">N</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"O">O</a><br>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"P">P</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"Q">Q</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"R">R</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"S">S</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"T">T</a><br>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"U">U</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"V">V</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"W">W</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"X">X</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"Y">Y</a>
				<a  href="#authors_modal" data-toggle="modal"  	data-link-a		=	"Z">Z</a></center>
				';
}
?>		
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

/********************************************************************************************************* 
 * 
 *				Javascript GLOBALS
 * 		
 **********************************************************************************************************/ 
if(typeof authors== 'undefined') {
    var authors 	= JSON.parse(<?php echo json_encode($authors); ?>);
    //console.log(<?php //foreach($authors as $author) { echo 'abc'.$author[0]. $author[1] .'<br>'; } ?>);
    //console.log('Authors = ' + authors);
}
var currentAuth =<?php echo $authCount;?>;
if(currentAuth == 0) currentAuth = 1;
var nextAuth = currentAuth+1;
console.log(currentAuth);

//console.log('GLOBALS - Next = ' + next);
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
<script>
 var miscFuncs={};
 function addAuthor(id,key,content) {
		html =  '<div class="col-md-11 col-sm-11" style="padding:0px;">' + 
		' <input id="auth' + id + '"' +
		'	name="auth' + id + '"' +
		' 	placeholder="click on the selector to choose an Author..."' +
		' 	class="form-control input-md"' +
		' 	type="text"'+
		' 	data-items="8"'+
		' 	readonly' +
		' 	autocomplete="off"' +
 		' 	value="'+ content + '"></div>' +
 		' <input id="authorHdnId' + id + '"' +
		' 	name="authorHdnId' + id + '"' +
		' 	type="hidden"'+
		' 	value="'+  key + '">' +
		' <div class="col-md-1 col-sm-1" style="padding:0px;"><button id="remove' + id + '"' +
	    ' 	class="btn btn-danger remove-me"' + 
	    '	type="button" >-</button></div>';
	    return(html);
 }
</script>	
<script>	// 	JS Setup Authors 
 html = '';
<?php
 $i = 0;
 foreach($bookAuthors as $authorID=>$authorName) { 
	$i++;?>
	i = <?php echo $i;?>;
	authorID = <?php echo  $authorID;?>;
	authorName = <?php echo  json_encode($authorName);?>;
	html = html + addAuthor( i,authorID ,authorName);
<?php	}	?>
	html = html + '<button id="b1" class="btn add-more" title="add an Author" type="button">Click here to add an Author</button></div>'
		$('#author_position_start').after(html);
</script>
<script> // JS Document Ready
   $(document).ready(function(){
	    miscFuncs.deleteAuthor = function(e,fieldNum) {
	            e.preventDefault();
	            var fieldID = "#auth" + fieldNum;
	            $(fieldID).remove();
	            $("#remove" + fieldNum).remove();
	            $("#authorHdnId" + fieldNum).remove();
	            console.log("field deleted  = " +fieldID);
	        };
		miscFuncs.showNewAuthorBtn = function() {
	            console.log("SHOW2");
		        
			    var addto 		= "#authorHdnId" + currentAuth;
		       	var addHidden 	= "#auth" + nextAuth;
		       	var addRemove	= "#remove" + currentAuth;
				var newInput = addAuthor(nextAuth,nextAuth,'');
		        $('#author_position_end').before(newInput);
		        
		        $("#remove" + nextAuth).attr('data-source',$(addRemove).attr('data-source'));
		        $("#count").val(nextAuth);
		        hideNewAuthorBtn()
		        showAlpha2();  
			    nextAuth++;
			    currentAuth++ 
				$('.remove-me').click(function(e){
				   	var fieldNum = parseInt(this.id.substr(this.id.lastIndexOf("e")+1)) ;
				   	miscFuncs.deleteAuthor(e,fieldNum)
			    });
	        };
	});
</script>
<script> // JS  add Author field Event 
	    $(".add-more").click(function(e){
	        e.preventDefault();
		    var addto 		= "#authorHdnId" + currentAuth;
	       	var addHidden 	= "#auth" + nextAuth;
	       	var addRemove	= "#remove" + currentAuth;
			var newInput = addAuthor(nextAuth,nextAuth,'');
	        $('#author_position_end').before(newInput);
	        
	        $("#remove" + nextAuth).attr('data-source',$(addRemove).attr('data-source'));
	        $("#count").val(nextAuth);
	        hideNewAuthorBtn()
	        showAlpha2();  
	        
		    nextAuth++;
		    currentAuth++ 
			$('.remove-me').click(function(e){
			   	var fieldNum = parseInt(this.id.substr(this.id.lastIndexOf("e")+1)) ;
			   	miscFuncs.deleteAuthor(e,fieldNum)
		    });
 	    });
 </script>
 <script>	// Remove Author field Event
	    $('.remove-me').click(function(e){
	    	var fieldNum = parseInt(this.id.substr(this.id.lastIndexOf("e")+1)) ;
	    	miscFuncs.deleteAuthor(e,fieldNum)
        });
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
<script type="text/javascript">
function changeContent(id, row, cell, content) {
	   var x = document.getElementById(id).rows[row].cells;
	    x[cell].innerHTML = content;
}
function changeAuthor(name, id) {
	console.log(currentAuth);
	fieldNum = currentAuth;
	if(fieldNum ==0) fieldNum = 1;
	var idString = $("#authorHdnId" + fieldNum).val;
	var nameString = $("#auth" + fieldNum).val;
	// change name received from "lastname, firstname" to "firstname lastname"
	var a = name.indexOf(',');
	var b = name.length -(a+2);
	
	var lastname = name.slice(0,a);
	var firstname = name.slice(-b);
	if(nameString.value	== '') {		//name is blank
		idString.value = 	'';
		nameAppend = 	'';
		idAppend		=	'';
	}
	else  {
		idAppend 		=	','
		nameAppend =	', ' 		
	}
	
	$("#auth" +(fieldNum)).val(firstname + ' ' + lastname) ;
	$("#authorHdnId" + (fieldNum)).val(id);
	showNewAuthorBtn(); 
}
function showAlphabet() {

    $('#showAlphabet').modal();
 
}
function hideNewAuthorBtn() {
	$("#b1").remove();
}
function showNewAuthorBtn(){
	$("#author_position_end").before('<button id="b1" class="btn add-more" title="add an Author" type="button">Click here to add an Author</button></div>');
	console.log("SHOW");
	$('.add-more').click(function(e){
	   	miscFuncs.showNewAuthorBtn();
    });
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
$('#authors_modal').on('hide.bs.modal', function () {
	
	//var authors 				=	JSON.parse(<?php //echo json_encode($authors); ?>);			// authors - Global: all authors
	var selectedIDs 		=	[];        																				// selected authors
	var inpfields 				=	this.getElementsByTagName('input');
	var nr_inpfields 			=	inpfields.length;
	var selectedID				= 	0;

	authName =  "auth" + nextAuth;																// initialize name & hidden field 
	hiddenId	='authorHdnId' + nextAuth
	$(authName).val 	= '';
	$(hiddenId).val	 	= '';
	
	for(var i=0; i<nr_inpfields; i++) {
		if(inpfields[i].checked == true) selectedID = inpfields[i].value.trim();
	  }
	  
	for(i=0;i<authors.length;i++)	{
		if(authors[i][1]	== selectedID) {
			changeAuthor(authors[i][0], authors[i][1]);						// name / ID
		}
	}
		
})
	$('#authors_modal').on('show.bs.modal', function(e) {
	
	    var letter		= $(e.relatedTarget).data('link-a');
	    var table = document.getElementById("authorTable");
	    var rowCount = table.rows.length;
	    for (var x=rowCount-1; x>0; x--) {
	       table.deleteRow(x);
	    }
	    rowCount = 1;
	    selection = '<h4 style="color:#526629;">[ ' + letter +' ]</h4>';
		if(letter == 'all') {
			selection = '<h4>all Authors</h4>';
		}
		    
	    changeContent('authorTable',0,0,selection); 
	    var j = 1;
	    for (i = 0; i < authors.length; i++) {
			var author  = '<div class="radio" style="margin-top:1px;margin-bottom:1px;color:#526629;  font-size: 12px ;">';
			author		= author + '<label><input type="radio" name="authorGroup"  value="'+authors[i][1]+'">'+authors[i][0]+'</label></div>';
		 	if(letter == 'all')	{
			    row = authorTable.insertRow(j);
			    row.insertCell(0);
		   	 	changeContent('authorTable',j,0,author);
			    j++;
				
			 	}
		 	else {
			 	if ((authors[i][0].indexOf(letter) ==  0 )  || (authors[i][0].indexOf(letter.toUpperCase()) == 0)){
			    row = authorTable.insertRow(j);
			    row.insertCell(0);
		   	 	changeContent('authorTable',j,0,author);
			    j++;
		    	}
		 	} 
	    }
		});
   function setAuthorID(name, authId) {
		console.log(authId);
		console.log(name);
	}
 	</script>
	</body>
</html>

