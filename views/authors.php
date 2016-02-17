<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Irish Interest - Authors</title>
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
 if($_SESSION['mode'] =='editAuthor')	
 	$heading = ' Edit Author details';
else $heading = 'Add Author details'; 	

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
  	  	  			<li><a href="../publish/">Edit Books</a></li>
  				<li><a href="#">Author Profiles</a></li>
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
  				<li><a href="#">Author Profiles</a></li>
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
  ?>
<div class="row" >
	
	<a href='../'> 
		<div class="col-md-2 col-sm-2 voffset6" style="background-color:#ffffff; z-index:1000; " >
			<img alt="" src="../ii_circle.png" class="image-responsive ii_circle" >
		</div>
		<div class="col-md-3  col-sm-4 voffset8 ii_text_div" >
		
			<img alt="" src="../IRISH_INTEREST_text.png" class="image-responsive ii_text" >
		</div>
	</a>
	
	<div class="col-md-7 primaryMenu voffset6">
		<div class="col-md-6" ></div>
		<div class="col-md-5">
			<div class="col-md-8 pull-right" style="border: 0px solid; border-radius: 10px; line-height: 2; font-weight: 900; font-size: 14px; font: Impact, Charcoal, sans-serif;">
				<?php echo $userMenu; ?>
			</div>
			
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
<div class="col-md-10 col-sm-10 col-xs-12 event-panel" > 
	<div class="container-fluid" style="border-radius: 4px">
		<div class="container-pad" id="property-listings" style="background-color: #f3be22; border: 0px solid; border-radius: 25px">
			<div class="row"><a href="../?home=1">
				<div class="glyphicon glyphicon-remove-circle   pull-right"	
								title="Home" style="margin-right:20px; font-size: 20px; text-shadow: black 0px 1px 1px;"></div>
						</a></div>';
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 ">

  							<div class="col-md-1"></div>
  							<div class="col-md-8">
   								 <div class="well well-sm" style="border-radius:25px">
  				<?php echo displayMessage();?>
 								 	<h4  class="text-center"><?php echo $heading;?></h4><br/>
								<form role="form" enctype="multipart/form-data" method="post" class="form-horizontal" >
										<fieldset>

											<!-- First Name-->
											<div class="form-group <?php echo $authorfirstnameErr ; ?>">
  												<label class="col-md-3 control-label control-label.has-error" for="firstname">First Name</label>
  												<div class="col-md-8">
 												 	<div class="required-field-block">
												    	<input id="firstname" name="firstname" placeholder="Author's first or christian name" class="form-control input-md" required type="text"
													    	 value="<?php echo $_SESSION['authorFirstName'] ; ?>" >
      											      	<div class="required-icon">
       												         <div class="text">*</div>
          											  	</div>
   													</div>
  												</div>
  												<div class="help-inline col-md-4"><?php echo $authorfirstnameMsg; ?></div>
											</div>

											<!-- Last Name-->
											<div class=" form-group <?php echo $authorlastnameErr ; ?>">
  												<label class="col-md-3 control-label control-label.has-error" for="lastname">Last Name</label>
 											  	<div class="col-md-8">
													<div class="required-field-block">
													    <input id="lastname" name="lastname" placeholder="Author's last name or Surname" class="form-control input-md" required type="text"
   																 value="<?php echo $_SESSION['authorLastName'] ; ?>" >
      											      	<div class="required-icon">
     										           		<div class="text">*</div>
            											</div>
  													</div>
 													<span class="help-inline"><?php echo $authorlastnameMsg; ?></span>
  												</div>
 											 	<div class="col-md-4"></div>
											</div>
										
											<!-- Date of BIrth --> 
											<div class="form-group <?php echo $authorDOBErr ; ?>"> 
												<?php
												
												if($_SESSION['authorDOB']	!=	'')	{
													$arr_date 	=	 date_parse($_SESSION['authorDOB']);
												
													$day								=	$arr_date['day'] == 0 ? '' :	$arr_date['day'];
													$month							=	$arr_date['month'];
													$selMonth		 				=	array();
													$selmonth[$month]			=	"selected";
													$year							=	$arr_date['year']	== 0 ? ''	:	$arr_date['year'];
												}
												$currentDate 							=	date_parse(date("Y-m-d"));
												$thisYear								=	$currentDate['year'];	
												?> 
  												<label class="control-label col-md-3 col-xs-2" for="datefrom">Born</label> 
												<div class="col-md-6 col-xs-12 col-sm-12"><!--  -->
	  												<div class="col-md-2 col-xs-3 col-sm-1" style="padding:0; margin:0"> <!-- day -->
										   				<input id="day" type="text" value="<?php echo $day;?>"  name="day" class="form-control input-md"  style="padding:2px; margin:0px">
										     		</div>
										      		<div class="col-md-4 col-xs-4 col-sm-2" style="padding:0; margin:0"> <!--  month -->
												      	<select name="month" style="padding-top:8px; padding-bottom:8px; padding-right:0px; margin:0px" value="<?php echo $month; ?>">
													      	<option <?php echo $selmonth[0];?>></option>
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
										      		<div class="col-md-4 col-xs-4 col-sm-2" style="padding-left:0px; margin:0px; margin-left:-3px"> <!--  year -->
										        		<input id="year" type="text" value="<?php echo $year;?>"  name="year" style="padding:4; " 
										        				data-max="<?php echo $thisYear; //$thisYear;?>">
										    		</div>
										   		</div>
											</div>

											<!-- Profile -->
											<div class="form-group <?php echo $profileErr ; ?>">
  												<label class="col-md-3 control-label control-label.has-error" for="profile">Profile</label>
												<div class="col-md-8">
  													<div >
    													<textarea id="profile" name="profile" placeholder="information about this Author ..." class="form-control input-md" ><?php echo $_SESSION['authorProfile'] ; ?></textarea>
														<span class="help-inline"><?php echo $profileMsg; ?></span>
													</div>
  												</div>
											</div>
										
											<!-- Address -->
											<div class="form-group <?php echo $addressErr ; ?>">
	  											<label class="col-md-3 control-label control-label.has-error" for="address">Address</label>
	  											<div class="col-md-8">
  													<div class="controls">
   		 												<input id="address" name="address" placeholder="Author's place of residence ..." class="form-control input-md" 
     															type="text" value="<?php echo $_SESSION['authorAddress'] ; ?>" >
													</div>
 													<span class="help-inline"><?php echo $addressMsg; ?></span>
  												</div>
  												<div class="col-md-4"></div>
											</div>

											<!-- url -->
											<div class="form-group  <?php echo $urlErr ; ?>">
		  										<label class="col-md-3 control-label control-label.has-error" for="url">Author's Web site</label>
		  										<div class="col-md-8">
	    											<input type="url" id="url" name="url" placeholder="http:// ..." class="form-control input-md" 
    													 size="40" value="<?php echo $_SESSION['authorUrl'] ; ?>" >
		  										</div>
		  										<span class="help-inline col-md-4"><?php echo $urlMsg; ?></span>
		 									</div>

											<!-- Alternative Link  -->
											<div class="form-group <?php echo $altLinkErr ; ?>">
  												<label class="col-md-3 control-label control-label.has-error" for="organiser">More Information</label>
	  											<div class="col-md-8">
   		 											<input id="altlink" name="altlink" placeholder="alternative web address for information about this author..." class="form-control input-md" 
    														 type="text" value="<?php echo $_SESSION['authorAltLink'] ; ?>" >
 													<span class="help-inline"><?php echo $contactMsg; ?></span>
	  											</div>
  												<div class="col-md-4"></div>
											</div>
											
											<!-- Image -->	
 											<div class="form-group <?php echo $imageErr ; ?>" style="padding-right:25px">
 												<label class="col-md-3 col-xs-12 control-label" for="Image">Image</label>
  												<div class="col-md-9 col-xs-10">   
											<?php
												if($_SESSION['mode'] =='editAuthor')	{	
													if($_SESSION['authorImage'] == '' ) $image ='../placeholder.jpg';
													else $image	=	"../upload/".$_SESSION['authorImage']; ?>
													<div class="col-md-12" style="padding:0";>
														<img src="<?php echo $image;?> " class="img-responsive"  style="height:150px; width:auto; background-color:#FFFFFF">
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
											<!-- Buttons -->	        
  													<div class="col-md-6 pull-right">                     
										      			<button name="save" value="author" type="submit" class="btn btn-primary pull-right">Save</button>  
													<?php        
														$modalBody	=	" Click OK to continue or Cancel";
														if($_SESSION['mode']	=='editAuthor')      {	?>
														 <!-- DELETE BUTTON	-->
														    <button type="button" class="btn btn-danger" onClick="triggerModal('<?php echo $author->id ; ?>')">Delete
														    </button> 
														 <!-- Cancel -->	        
													     <button name="cancel" value="author" type="submit" class="btn btn-default ">Cancel</button>  
													    <?php 
    													echo '  
													    <div id="largeModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													        <div class="modal-dialog">
													            <div class="modal-content">
														            <div class="modal-header" id="myModalLabel">
														                <button type="button" class="close" data-dismiss="modal" >x</button>
													                    <h4 class="modal-title">Delete Author "'.$_SESSION['authorFirstName'].' '.$_SESSION['authorLastName'].'"</h4>
													                </div>
  
															        <form method="post" id="action_submit" action="./?delete">     
														            	<div class="modal-body">'.$modalBody.'
													                    	<input type="hidden" name="titleId" id="the_id" >
																		</div>
										                				<div class="modal-footer">
														                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';?>
														                    <button name="delete" type="submit" class="btn btn-success btn-primary" value="<?php echo $_SESSION['authorId'];?>"><?php echo 'OK' ;?></button>
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
							<div class="col-md-3">
 								 <div class="well well-sm" style="border-radius:25px">
  								 	<h4  class="text-center">Irish Interest Authors</h4><br/>	
								   			<div class="authorbodycontainer scrollable style="background-color:#e8e8e8"">
 								 
 								 	<?php 
 								 	foreach($authors as $author) {
 								 		
 								 		echo '<div class="form-group"><a href=../authors/&edit?id='.$author->id.'>'.$author->lastname.',  '.$author->firstname.'</a></div>';
 								 		
 								 	}
 								 	
 								 	?>	
 								 			</div>	
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
            $("input[name='day']").TouchSpin({
               
                max: 31,
                step: 1,
                decimals: 0,
                verticalbuttons:true
            });
        </script>
        <script>
            $("input[name='year']").TouchSpin({
                
                step: 1,
                decimals: 0,
                verticalbuttons:true,
           });
        </script>
<script type="text/javascript">
function triggerModal(avalue) {
 
    document.getElementById('the_id').value = avalue;
 
    $('#largeModal').modal();
 
}
</script>        
		

