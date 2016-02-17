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
 if($_SESSION['mode'] =='editBanner')	
 	$heading = ' Edit Banner';
else $heading = 'Add a Banner'; 	

$userMenu =	'
	<button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown" 
    				style="border-radius: 10px; font-weight:900;">'
  					.$_SESSION['user'].'
    				<span class="caret"></span>
	</button>';

$userMenu .=	'
  	  	<ul class="dropdown-menu" style="text-align:left">
		  	<li><a href="../admin/">Publishers</a></li>
		  	<li><a href="../categories/">Categories</a></li>
		  	<li><a href="#">Banners</a></li>
		 	<li><a href="../utilities/">Utilities</a></li>
		  	<li class="divider"></li>
  			<li><a href="../publish/">Add Books / Edit Books</a></li>
  			<li><a href="../authors/">Author Profiles</a></li>
  			<li><a href="../profile"><i>'.$_SESSION['user'].'</i> Profile</a></li>
		  	<li class="divider"></li>
  			<li><a href="../?home=1">Home Page</a></li>
  			<li><a href="../logout">Sign Out</a></li>
		  	  			</ul>';
  
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
  							<div class="col-md-1"></div>
  							<div class="col-md-7">
   								 <div class="well well-sm" style="border-radius:25px">
  									<?php echo displayMessage();?>
 								 	<h4  class="text-center"><?php echo $heading;?></h4><br/>
									<form role="form" enctype="multipart/form-data" method="post" class="form-horizontal" >
										<fieldset>

											<!-- Banner Name-->
											<div class="form-group <?php echo $bannernameErr ; ?>">
  												<label class="col-md-3 control-label control-label.has-error" for="bannername">Banner Name</label>
  												<div class="col-md-8">
 												 	<div class="required-field-block">
												    	<input id="bannername" name="bannername" placeholder="banner name" class="form-control input-md" required type="text"
													    	 value="<?php echo $_SESSION['bannerName'] ; ?>" >
      											      	<div class="required-icon">
       												         <div class="text">*</div>
          											  	</div>
   													</div>
  												</div>
  												<div class="help-inline col-md-4"><?php echo $bannernameMsg; ?></div>
											</div>

											<!-- Banner Description -->
											<div class=" form-group <?php echo $bannerdescriptionErr ; ?>">
  												<label class="col-md-3 control-label control-label.has-error" for="eventdescription">Banner Description</label>
 											  	<div class="col-md-8">
													<div class="required-field-block">
													    <input id="bannerdescription" name="bannerdescription" placeholder="banner description" class="form-control input-md" required type="text"
   																 value="<?php echo $_SESSION['bannerDescription'] ; ?>" >
      											      	<div class="required-icon">
     										           		<div class="text">*</div>
            											</div>
  													</div>
 													<span class="help-inline"><?php echo $bannerdescriptionMsg; ?></span>
  												</div>
 											 	<div class="col-md-4"></div>
											</div>

											<!-- Image -->	
 											<div class="form-group <?php echo $imageErr ; ?>" style="padding-right:25px">
 												<label class="col-md-3 col-xs-12 control-label" for="Image">Image</label>
  												<div class="col-md-9 col-xs-10">   
											<?php
												if($_SESSION['mode'] =='editBanner')	{	
													if($_SESSION['bannerImage'] == '' ) $image ='../placeholder.jpg';
													else $image	=	'../'.$_SESSION['bannerImage']; ?>
													<div class="col-md-12" style="padding:0";>
														<img src="<?php echo $image;?> " class="img-responsive" style="padding-left:10px;height:200px;">
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
											<!-- Buttons -->	
											<div class="form-group">        
  													<div class="col-md-6 pull-right">                     
										      			<button name="save" value="banner" type="submit" class="btn btn-primary pull-right">Save</button>  
													<?php        
														$modalBody	=	" Click OK to continue or Cancel";
														if($_SESSION['mode']	=='editBanner')      {	?>
														 <!-- DELETE BUTTON	-->
														    <button type="button" class="btn btn-danger" onClick="triggerModal('<?php echo $_SESSION['bannerid'] ; ?>')">Delete
														    </button> 
														 <!-- Cancel -->	        
													     <button name="cancel" value="banner" type="submit" class="btn btn-default ">Cancel</button>  
													    <?php 
    													echo '  
													    <div id="largeModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													        <div class="modal-dialog">
													            <div class="modal-content">
														            <div class="modal-header" id="myModalLabel">
														                <button type="button" class="close" data-dismiss="modal" >x</button>
													                    <h4 class="modal-title">Delete Banner "'.$_SESSION['bannerName'].'"</h4>
													                </div>
  
															        <form method="post" id="action_submit" action="./?delete">     
														            	<div class="modal-body">'.$modalBody.'
													                    	<input type="hidden" name="titleId" id="the_id" >
																		</div>
										                				<div class="modal-footer">
														                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';?>
														                    <button name="delete" type="submit" class="btn btn-success btn-primary" value="<?php echo $_SESSION['bannerId'];?>"><?php echo 'OK' ;?></button>
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
 								 	<h4  class="text-center">Existing Banners</h4><br/>	
 								 	<?php 
 								 	foreach($banner as $bann) {
 								 		echo '<div class="form-group"><a href=../banner/&edit?id='.$bann->id.'>'.$bann->name.'</a></div>';
 								 		
 								 	}
 								 	
 								 	?>		
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
<script type="text/javascript">
function triggerModal(avalue) {
 
    document.getElementById('the_id').value = avalue;
 
    $('#largeModal').modal();
 
}
</script>        
		

