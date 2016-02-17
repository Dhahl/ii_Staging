<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Irish Interest - Events</title>
	<link rel="icon" type="image/png" href="../favicon.png" />

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
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
 if($_SESSION['mode'] =='editEvent')	
 	$heading = ' Edit Event';
else $heading = 'Add an Event'; 	

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
   			<li><a href="../publish/">Add Books / Edit Books</a></li>
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
  			<li><a href="../publish/">Add Books / Edit Books</a></li>
  			<li><a href="../authors/">Author Profiles</a></li>
  			<li><a href="../profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
  			<li><a href="../logout">Sign Out</a></li>
  			</ul>';
  }
 if($_SESSION['accessLevel']		=='3')	{
  	$userMenu .=	'
			<ul class="dropdown-menu" style="text-align:left">
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
<img alt="" src="../images/bookshop01.jpeg" style="max-height: 350px; width: 100%" class="image-responsive">
<div class="col-md-1 col-xs-12 col-sm-1"></div>
<div class="col-md-10 col-sm-10 col-xs-12 event-panel" > 
	<div class="container-fluid " style="border-radius: 4px">
		<div class="container-pad" id="property-listings" style="background-color: #f3be22; border: 0px solid; border-radius: 25px">
			<div class="row">
				<a href="../?home=1">
					<div class="glyphicon glyphicon-remove-circle   pull-right"	
								title="Home" style="margin-right:20px; font-size: 20px; text-shadow: black 0px 1px 1px;">
					</div>
				</a>
			</div>
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 col-xs-12 ">

  							<div class="col-md-1 col-sm-12 col-xs-12"></div>
  							<div class="col-md-8 col-sm-11 col-xs-12">
   								 <div class="well well-sm" style="border-radius:25px">
  				<?php echo displayMessage();?>
 								 	<h4  class="text-center"><?php echo $heading;?></h4><br/>
								<form role="form" enctype="multipart/form-data" method="post" class="form-horizontal" >
										<fieldset>

											<!-- Event Name-->
											<div class="form-group <?php echo $eventtitleErr ; ?>">
  												<label class="col-lg-3 col-md-12 col-sm-12 col-xs-12 control-label control-label.has-error ii_label"  for="eventtitle">Event  Title</label>
  												<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 ">
 												 	<div class="required-field-block">
												    	<input id="eventtitle" name="eventtitle" placeholder="event title" class="form-control input-md" required type="text"
													    	 value="<?php echo $_SESSION['eventTitle'] ; ?>" >
      											      	<div class="required-icon">
       												         <div class="text">*</div>
          											  	</div>
   													</div>
  												</div>
  												<div class="help-inline col-md-4"><?php echo $eventtitleMsg; ?></div>
											</div>

											<!-- Event Description -->
											<div class=" form-group <?php echo $eventdescriptionErr ; ?>">
  												<label class="col-lg-3 col-md-12  control-label control-label.has-error ii_label"   for="eventdescription">Event Description</label>
 											  	<div class="col-lg-8 col-md-12 ">
													<div class="required-field-block">
													    <input id="eventdescription" name="eventdescription" placeholder="event description" class="form-control input-md" required type="text"
   																 value="<?php echo $_SESSION['eventDescription'] ; ?>" >
      											      	<div class="required-icon">
     										           		<div class="text">*</div>
            											</div>
  													</div>
 													<span class="help-inline"><?php echo $eventdescriptionMsg; ?></span>
  												</div>
 											 	<div class="col-md-4"></div>
											</div>

											<!-- Location -->
											<div class="form-group <?php echo $locationErr ; ?>">
  												<label class="col-lg-3 col-md-12  control-label control-label.has-error ii_label"  for="location">Location</label>
												<div class="col-lg-8 col-md-12 ">
  													<div >
    													<input id="location" name="location" placeholder="where" class="form-control input-md" 
   														  type="text" value="<?php echo $_SESSION['eventLocation'] ; ?>" >
														<span class="help-inline"><?php echo $locationMsg; ?></span>
													</div>
  												</div>
											</div>
										
											<!-- Date/Time from --> 
												<?php
												
												if($_SESSION['eventDateTimeFrom']	!=	'')	{
													$arr_date 	=	 date_parse($_SESSION['eventDateTimeFrom']);
												}
												else	{
													$arr_date 	=	 date_parse(date('Y-m-d H:i'));
												}
												
												$dayFrom								=	$arr_date['day'];
												$monthFrom							=	$arr_date['month'];
												$selMonthFrom		 				=	array();
												$selmonthFrom[$monthFrom]	=	"selected";
												$yearfrom								=	$arr_date['year'];
												$currentDate 							=	date_parse(date("Y-m-d"));
												$thisYear								=	$currentDate['year'];	
												$hourFrom								= str_pad($arr_date['hour'],2, '0',STR_PAD_LEFT);
												$minutesFrom						= str_pad($arr_date['minute'],2,'0',STR_PAD_LEFT);
												?> 
 										<?php 
												
												if($_SESSION['eventDateTimeTo']	!=	'')	{
													$arr_date 	=	 date_parse($_SESSION['eventDateTimeTo']);
												}
												else	{
													$arr_date 	=	 date_parse(date('Y-m-d H:i'));
												}
												
												$dayTo							=	$arr_date['day'];
												$monthTo							=	$arr_date['month'];
												$selMonthTo		 				=	array();
												$selmonthTo[$monthTo]	=	"selected";
												$yearTo								=	$arr_date['year'];
												$currentDate 							=	date_parse(date("Y-m-d"));
												$thisYear								=	$currentDate['year'];	
												$hourTo								= str_pad($arr_date['hour'],2, '0',STR_PAD_LEFT);
												$minutesTo						= str_pad($arr_date['minute'],2,'0',STR_PAD_LEFT);
												?>
											<div class="form-group <?php echo $eventDateFromErr ; ?>"> 
  												<label class="control-label col-lg-3 col-md-12 col-sm-12 col-xs-12 ii_label" for="datefrom">On</label> 
												<div class="col-lg-5 col-md-7 col-sm-7 col-xs-7 " style="padding-right:0px;"><!--  -->
	  												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 " style="padding:0px; margin:0"> <!-- day -->
										   				<input id="dayfrom" type="text" value="<?php echo $dayFrom;?>"  name="dayfrom" class="form-control input-md"  style="padding:2px; margin:0px">
										     		</div>
										      		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 " style="padding:0; margin:0"> <!--  month -->
												      	<select name="monthfrom" style="padding-top:8px; padding-bottom:8px; padding-right:0px; margin:0px" value="<?php echo $monthFrom; ?>">
													      	<option <?php echo $selmonthFrom[1];?>>January</option>
													      	<option <?php echo $selmonthFrom[2];?>>February</option>
													      	<option <?php echo $selmonthFrom[3];?>>March</option>
													      	<option <?php echo $selmonthFrom[4];?>>April</option>
													      	<option <?php echo $selmonthFrom[5];?>>May</option>
													      	<option <?php echo $selmonthFrom[6];?>>June</option>
													      	<option <?php echo $selmonthFrom[7];?>>July</option>
													      	<option <?php echo $selmonthFrom[8];?>>August</option>
													      	<option <?php echo $selmonthFrom[9];?>>September</option>
													      	<option <?php echo $selmonthFrom[10];?>>October</option>
													      	<option <?php echo $selmonthFrom[11];?>>November</option>
													      	<option <?php echo $selmonthFrom[12];?>>December</option>
												      	</select>
										      		</div>
										      		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 " style="padding-left:0px; margin:0px; "> <!--  year -->
										        		<input id="yearfrom" type="text" value="<?php echo $yearfrom;?>"  name="yearfrom" style="padding:4px; " 
										        				data-max="<?php echo 2100; //$thisYear;?>">
										    		</div>
										   		</div>
										   		<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5" style="padding-right:0px; ">
										    		<label class="control-label col-lg-1 col-md-1 col-sm-1 col-xs-1 ii_label"  style="margin-left:-20px;"> At:</label>
  													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 " style="padding-left:10px; "> <!-- Hour -->
										   					<input id="hourfrom" type="text" value="<?php echo $hourFrom;?>"  name="hourfrom" class="form-control input-md"  style="padding:2px; margin:0px">
										     		</div>
	  												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 " style="padding-left:10px; margin-left:-20px;"> <!-- Minutes -->
										   				<input id="minutesfrom" type="text" value="<?php echo $minutesFrom;?>"  name="minutesfrom" class="form-control input-md"  style="padding:2px; margin:0px;">
										     		</div>
										 	 	</div>

											</div>
											<div class="form-group <?php echo $eventDateToErr ; ?>"> 
  												<label class="control-label col-lg-3 col-md-12 col-sm-12 col-xs-12 ii_label"  for="dateto">To</label> 
												<div class="col-lg-5 col-md-7 col-sm-7 col-xs-7 " style="padding-right:0px;"><!--  -->
	  												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 " style="padding:0; margin:0px"> <!-- day -->
										   				<input id="dayto" type="text" value="<?php echo $dayTo;?>"  name="dayto" class="form-control input-md"  style="padding:2px; margin:0px">	
											     	</div>
												    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 " style="padding:0px; margin:0"> <!--  month -->
												      	<select name="monthto" style="padding-top:8px; padding-bottom:8px; padding-right:0px; margin:0px" value="<?php echo $monthTo; ?>">
													      	<option <?php echo $selmonthTo[0];?>></option>
													      	<option <?php echo $selmonthTo[1];?>>January</option>
													      	<option <?php echo $selmonthTo[2];?>>February</option>
													      	<option <?php echo $selmonthTo[3];?>>March</option>
													      	<option <?php echo $selmonthTo[4];?>>April</option>
													      	<option <?php echo $selmonthTo[5];?>>May</option>
													      	<option <?php echo $selmonthTo[6];?>>June</option>
													      	<option <?php echo $selmonthTo[7];?>>July</option>
													      	<option <?php echo $selmonthTo[8];?>>August</option>
													      	<option <?php echo $selmonthTo[9];?>>September</option>
													      	<option <?php echo $selmonthTo[10];?>>October</option>
													      	<option <?php echo $selmonthTo[11];?>>November</option>
													      	<option <?php echo $selmonthTo[12];?>>December</option>
												      	</select>
													</div>
										      		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 " style="padding-left:0px; margin:0px; "> <!--  year -->
										       			<input id="yearto" type="text" value="<?php echo $yearTo;?>"  name="yearto" style="padding:4px; " 
													        	data-max="<?php echo 2100; ?>">
												    </div>
												</div>
										   		<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5" style="padding-right:0px;">
 												    <label class="control-label col-lg-1 col-md-1 col-sm-1 col-xs-1 ii_label"  style="margin-left:-20px;"> At:</label>
 													<div class="col-lg-5 col-md-5  col-sm-5 col-xs-6" style="padding-left:10px; "> <!-- Hour -->
										   				<input id="hourto" type="text" value="<?php echo $hourTo;?>"  name="hourto" class="form-control input-md"  style="padding:2px; margin:0px">
											     	</div>
	  												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 " style="padding-left:10px; margin-left:-20px;"> <!-- Minutes -->
										   				<input id="minutesto" type="text" value="<?php echo $minutesTo;?>"  name="minutesto" class="form-control input-md"  style="padding:2px; margin:0px">
										     		</div>
										  		</div>

											</div>
										
											<!-- Organisers  
											<div class="form-group <?php //echo $organiserErr ; ?>">
  												<label class="col-md-3 control-label control-label.has-error" for="organiser">Organiser</label>
	  											<div class="col-md-8">
   		 											<input id="organiser" name="organiser" placeholder="Organiser" class="form-control input-md" 
    														 type="text" value="<?php // echo $_SESSION['eventOrganiser'] ; ?>" >
 													<span class="help-inline"><?php // echo $positionMsg; ?></span>
	  											</div>
  												<div class="col-md-4"></div>
											</div>-->
											<!-- Telephone 
											<div class="form-group <?php // echo $telephoneErr ; ?>">
	  											<label class="col-md-3 control-label control-label.has-error" for="telepohone">Contact Phone</label>
	  											<div class="col-md-8">
  													<div class="controls">
   		 												<input id="telephone" name="telephone" placeholder="contact telephone" class="form-control input-md" 
     															type="text" value="<?php // echo $_SESSION['eventContactPhone'] ; ?>" >
													</div>
 													<span class="help-inline"><?php // echo $telephoneMsg; ?></span>
  												</div>
  												<div class="col-md-4"></div>
											</div>-->

											<!-- EMail 
											<div class="form-group  <?php // echo $emailErr ; ?>">
		  										<label class="col-md-3 control-label control-label.has-error" for="email">Contact e-mail</label>
		  										<div class="col-md-8">
	    											<input type="email" id="email" name="email" placeholder="contact e-mail address" class="form-control input-md" 
    													 size="40" value="<?php // echo $_SESSION['eventContactEmail'] ; ?>" >
		  										</div>
		  										<span class="help-inline col-md-4"><?php //echo $emailMsg; ?></span>
		 									</div>-->
		 									
											<!-- Event url -->
											<div class="form-group <?php echo $eventUrlErr; ?>">
												<label class="col-lg-3 col-md-12 col-xs-12 control-label ii_label" for="eventurl"> Web site</label>  
												<div class="col-lg-8 col-md-12 col-xs-12">
													<input id="eventurl" name="eventurl" placeholder="http://www. ..." class="form-control input-md" type="url"
										  				value="<?php echo $_SESSION['eventUrl']; ?>">
											  		<span class="help-inline"><?php echo $eventUrlMsg ; ?></span>
											  	</div>
											</div>

<?php /* 
										<!--  Book  
										<div class="form-group echo $bookErr ; ?>">
  											<label class="col-md-3 control-label control-label.has-error" for="book">Book</label>
											<div class="col-md-6">
  												<div class="input-group " >
    												<input id="book" name="book" placeholder="book" class="form-control input-md" 
   														  type="text" value="<?php echo $_SESSION['eventbookidbook'] ; ?>" >
													<span class="help-inline"><?php echo $bookMsg; ?></span>
													<div class="input-group-btn">
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
															name="books" id="books" >
															<span class="caret">	</span>
														</button>
														<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu">
														<?php 
														foreach($_SESSION['books'] as $idx=>$book)	{
															echo '<li> <a tabindex="-1" href="#">'.$book.'</a></li>';
														}
														?>
														</ul>
													</div>  
  												</div>
  											</div>
										</div>					-->
														<script>
														$(function(){
																  $(".dropdown-menu li a").click(function(){
																				document.getElementById('book').value = $(this).text();
																					  });
																		});
														</script>
										<!-- Author -->
										<div class="form-group <?php echo $AuthorErr ; ?>">
  											<label class="col-md-3 control-label control-label.has-error" for="Author">Author</label>
											<div class="col-md-6">
  												<div class="input-group " >
    												<input id="author" name="authro" placeholder="Author name" class="form-control input-md" 
   														  type="text" value="<?php echo $_SESSION['author'] ; ?>" >
													<span class="help-inline"><?php echo $authorMsg; ?></span>
													<div class="input-group-btn">
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
															name="authors" id="authors" >
															<span class="caret">	</span>
														</button>
														<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu">
														<?php 
														foreach($_SESSION['authorNames'] as $idx=>$authorName)	{
															echo '<li> <a tabindex="-1" href="#">'.$authorName.'</a></li>';
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
																				document.getElementById('author').value = $(this).text();
																					  });
																		});
														</script>
*/?>
											<!-- Image -->	
 											<div class="form-group <?php echo $imageErr ; ?>" style="padding-right:25px">
 												<label class="col-md-3 col-xs-12 control-label" for="Image">Image</label>
  												<div class="col-md-9 col-xs-10">   
											<?php
												if($_SESSION['mode'] =='editEvent')	{	
													if($_SESSION['eventImage'] == '' ) $image ='../placeholder.jpg';
													else $image	=	"../upload/".$_SESSION['eventImage']; ?>
													<div class="col-md-4" style="padding:0";>
														<img src="<?php echo $image;?> " class="img-responsive" style="max-height:100px; background-color:#FFFFFF;">
													</div> 
												<?php  
												}  ?>                  
												   	<div class="control-group col-md-4">  
     	 
														<div class="controls" style="padding-bottom:25px; padding-top:25px">  
										              		<input class="input-file" id="image" name="image" type="file" >  
										  					<span class="help-inline" style="color:800000"><?php echo $imageMsg;  ?></span>
										            	</div>  
												    </div>
  													</div>
  												</div>
  												<div class="form-group">
											<!-- Buttons -->	        
  													<div class="col-md-6 pull-right">                     
										      			<button name="save" value="event" type="submit" class="btn btn-primary pull-right">Save</button>  
													<?php        
														$modalBody	=	" Click OK to continue or Cancel";
														if($_SESSION['mode']	=='editEvent')      {	?>
														 <!-- DELETE BUTTON	-->
														    <button type="button" class="btn btn-danger" onClick="triggerModal('<?php echo $event->id ; ?>')">Delete
														    </button> 
														 <!-- Cancel -->	        
													     <button name="cancel" value="event" type="submit" class="btn btn-default ">Cancel</button>  
													    <?php 
    													echo '  
													    <div id="largeModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													        <div class="modal-dialog">
													            <div class="modal-content">
														            <div class="modal-header" id="myModalLabel">
														                <button type="button" class="close" data-dismiss="modal" >x</button>
													                    <h4 class="modal-title">Delete Event "'.$_SESSION['eventTitle'].'"</h4>
													                </div>
  
															        <form method="post" id="action_submit" action="./?delete">     
														            	<div class="modal-body">'.$modalBody.'
													                    	<input type="hidden" name="titleId" id="the_id" >
																		</div>
										                				<div class="modal-footer">
														                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';?>
														                    <button name="delete" type="submit" class="btn btn-success btn-primary" value="<?php echo $_SESSION['eventId'];?>"><?php echo 'OK' ;?></button>
																	<?php  echo '
														                </div>
																	</form>
														        </div>
				        									</div>
														</div>';
?>
  													</div>
   												</div>


 <?php } ?>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="col-md-3 col-sm-8 col-xs-8">
 								 <div class="well well-sm" style="border-radius:25px">
 								 	<h4  class="text-center">Irish Interest Events</h4><br/>	
 								 	<?php 
 								 	foreach($events as $event) {
 								 		$eventDate = date('d/m/y',strtotime($event->date_time_from));
 								 		echo '<div class="form-group"><a href=../events/&edit?id='.$event->id.'>'.$eventDate.' - '.$event->title.'</a></div>';
 								 		
 								 	}
 								 	
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
<script>
$(function() {
    $('.required-icon').tooltip({
        placement: 'left',
        title: 'Required field'
        });
});
</script>    
        <script>
            $("input[name='yearfrom']").TouchSpin({
                min: 1,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
                buttondown_class: 'btn btn-mini',
                buttonup_class: 'btn btn-mini',
           });

           
        </script>
        <script>
        $("input[name='dayfrom']").TouchSpin({
            min: 1,
            max: 31,
            step: 1,
            decimals: 0,
            verticalbuttons:true,
            buttondown_class: 'btn btn-mini',
            buttonup_class: 'btn btn-mini',
       });
      </script>
        <script>
            $("input[name='hourfrom']").TouchSpin({
                min: 0,
                max: 23,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
                buttondown_class: 'btn btn-mini',
                buttonup_class: 'btn btn-mini',
           });
        </script>
        <script>
            $("input[name='minutesfrom']").TouchSpin({
                min: 00,
                max:59,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
                buttondown_class: 'btn btn-mini',
                buttonup_class: 'btn btn-mini',
           });
            </script>
            <script>
            $("input[name='dayto']").TouchSpin({
                min: 1,
                max:31,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
                buttondown_class: 'btn btn-mini',
                buttonup_class: 'btn btn-mini',
           });
        </script>
            
            <script>
            $("input[name='yearto']").TouchSpin({
                min: 1,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
                buttondown_class: 'btn btn-mini',
                buttonup_class: 'btn btn-mini',
           });
        </script>
            <script>
            $("input[name='hourto']").TouchSpin({
                min: 0,
                max: 23,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
                buttondown_class: 'btn btn-mini',
                buttonup_class: 'btn btn-mini',
           });
        </script>
        <script>
            $("input[name='minutesto']").TouchSpin({
                min: 0,
                max:59,
                step: 1,
                decimals: 0,
                verticalbuttons:true,
                buttondown_class: 'btn btn-mini',
                buttonup_class: 'btn btn-mini',
           });
        </script>
<script type="text/javascript">
function triggerModal(avalue) {
 
    document.getElementById('the_id').value = avalue;
 
    $('#largeModal').modal();
 
}
</script>        
		
