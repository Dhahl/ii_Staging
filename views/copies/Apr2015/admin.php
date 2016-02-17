<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Irish Interest - Administrator</title>

	<link rel="icon" type="image/png" href="../publish_favicon/favicon.png" />
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
  <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
  </head>
 <body role="document">
    <div class="container">
    <!-- Fixed navbar -->
    <div class="navbar" role="navigation">
   
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

<?php 
$hdg	=	"";
if(!$_SESSION['userPublisher']	==	"")	{
	$hdg	.=	$_SESSION['userPublisher'];
}
else	{
	$hdg	.=	$_SESSION['userFirstName'].' '.$_SESSION['userLastName'];
}
php ?>    

          <div class="navbar-brand" style="width:100%; font-family: arial; font-size: 16px;"></div>
        <center style="font-family: arial; font-size: 24px;"><?php echo $hdg; ?></center></div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user']?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li class="divider"></li>
	               	<li><a href="../publish/?user=<?php echo $_SESSION['user'];?>">My Books</a>
                   	<li class="divider"></li>
 
  <?php
if($_SESSION['accessLevel']	== '10')	{ ?>
                   <li class="divider"></li>
                   <li><a href="../admin/">Publishers (Admin)</a></li>
                  <li class="divider"></li>
<?php } ?>
                  <li><a href="logout">Logout</a></li>
                </ul>
              </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
 
      <div class="container-fluid">
  <?php 
  /*
   * 	Setup "Active" Radios & "Type" Select
   */
  	$active	=	'';
  	$inactive	=	'';
 	if( ($_SESSION['editactive']	==	'y')	|| ($_SESSION['editactive']	==	'Y') )	{
		$active	=	' checked="checked"';	
	}
	else {
		$inactive	=	' checked="checked"';
	}
  
 	if($_SESSION['editaccess']	==	"1")	{			//	publisher
      	$selPublisher	=	" selected ";
 	}
 	elseif($_SESSION['editaccess']	=="2")	{			//	Unaffiliated
 		$selUnaffiliated=	" selected";
 	}
 	elseif($_SESSION['editaccess']	==	"10")	{		//	admin;
    	$selAdmin		=	" selected ";
 	}
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
			case 'companyname':
				$companyNameErr	=	"has-error";
				$companyNameMsg	=	$_SESSION['err']['msg'][$idx];	
				break;
		}
	}
 	if($_SESSION['ok']	=== false)	{
?> 	
	<div class="col-md-6">	
		<div class="alert alert-warning" style="margin-bottom:0px">

        	<a href="#" class="close" data-dismiss="alert">&times;</a>

        	<strong>An error occurred!</strong> Your information was not saved - please correct the errors below and try again.

    	</div>
    </div>
<?php 		
 	}
 if($_SESSION['ok']		===	true)	{
	 	$done	=	$_SESSION['deleted'] ==	true	?	' deleted. '	:	'updated. ';
 		$entity	=	$_SESSION['entity']	== 'company'	?	'Company'	:	'User';
 		$message	=	$entity.' <b>'.$_SESSION['editusername'].'</b> '.$done;
		$message 	.=	'<a href=../publish/?user='.$_SESSION['user'].'> Back to books...</a>';
		$_SESSION['editfirstname']		=	'';
    	$_SESSION['editlastname']		=	'';
    	$_SESSION['editpublishername']	=	'';
    	$_SESSION['editemail']			=	'';
    	$_SESSION['edittelephone']		=	'';
    	$_SESSION['editposition']		=	'';
    	$_SESSION['editaccess']			=	'';
    	$_SESSION['editactive']			=	'';
    	$_SESSION['editpassword']		=	'';
    	$_SESSION['editpasswordconfirm']=	'';
		$_SESSION['mode']				=	'';
?>
	<div class="col-md-6">	
		<div class="alert alert-success" style="margin-bottom:0px">

        	<a href="#" class="close" data-dismiss="alert">&times;</a><?php echo $message;?>
        </div>
    </div>
<?php 			
 }
	?>
<!-- EDIT USER form -->
  <div class="col-md-8" ;>
<div class="panel panel-success">
 <div class="panel-heading"><?php echo $mode; ?>User details</div>
   <div class="panel-body">

<form role="form" class="form-horizontal" method="post">
<fieldset>
<div class="row">
<div class="col-md-8">
<!-- User Name-->
<div class="form-group <?php echo $firstnameErr ; ?>">
  <label class="col-md-5 control-label control-label.has-error" for="firstname">First Name</label>
  <div class="col-md-7">
  	<div class="required-field-block">
    	<input id="firstname" name="firstname" placeholder="login" class="form-control  input-md"  required type="text"
    	 value="<?php echo $_SESSION['editfirstname'] ; ?>"> 
            <div class="required-icon">
                <div class="text">*</div>
            </div>
   	</div>
 	<span class="help-inline"><?php echo $firstnameMsg; ?></span>
 </div>
    
</div>

<!-- Full name -->
<div class=" form-group <?php echo $lastnameErr ; ?>">
  <label class="col-md-5 control-label control-label.has-error" for="lastname">Last Name</label>
   <div class="col-md-7">
  <div class="required-field-block">
    <input id="lastname" name="lastname" placeholder="name" class="form-control input-md" required type="text"
    value="<?php echo $_SESSION['editlastname'] ; ?>" >
            <div class="required-icon">
                <div class="text">*</div>
            </div>
    
  </div>
 <span class="help-inline"><?php echo $lastnameMsg; ?></span>
  </div>
</div>

<!-- Publisher -->
<div class="form-group <?php echo $publishernameErr ; ?>">
  <label class="col-md-5 control-label control-label.has-error" for="publishername">Publishing Company</label>
  <div class="col-md-7">
   <div class="input-group " >
     <input id="publishername" name="publishername" placeholder="company" class="form-control input-md" 
       type="text" value="<?php echo $_SESSION['editpublishername'] ; ?>" >
 	 <span class="help-inline"><?php echo $publishernameMsg; ?></span>
	 <div class="input-group-btn">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
		  	name="publishers" id="publishers" >
		  <span class="caret" style="height:20px"> </span>
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
  <label class="col-md-5 control-label control-label.has-error" for="telepohone">Telephone</label>
  <div class="col-md-7">
  <div class="controls">
    <input id="telephone" name="telephone" placeholder="telephone" class="form-control input-md" 
     type="text" value="<?php echo $_SESSION['edittelephone'] ; ?>" >
    
  </div>
 <span class="help-inline"><?php echo $telephoneMsg; ?></span>
  </div>
</div>

<!-- Position -->
<div class="form-group <?php echo $positionErr ; ?>">
  <label class="col-md-5 control-label control-label.has-error" for="position">Position</label>
  <div class="col-md-7">
  <div class="required-field-block">
    <input id="position" name="position" placeholder="position" class="form-control input-md" 
    required type="text" value="<?php echo $_SESSION['editposition'] ; ?>" >
           <div class="required-icon">
                <div class="text">*</div>
            </div>
    
  </div>
 <span class="help-inline"><?php echo $positionMsg; ?></span>
  </div>
</div>

<!-- EMail -->
<div class="form-group  <?php echo $emailErr ; ?>">
  <label class="col-md-5 control-label control-label.has-error" for="email">e-mail</label>
  <div class="col-md-7">
  <div class="required-field-block">
    <input type="email" id="email" name="email" placeholder="e-mail" class="form-control input-md" 
    	required size="40" value="<?php echo $_SESSION['editemail'] ; ?>" >
             <div class="required-icon">
                <div class="text">*</div>
            </div>
  </div>
  <span class="help-inline"><?php echo $emailMsg; ?></span>
  </div>
</div>

<!-- Password & Confirmation -->
 <div class="form-group <?php echo $passwordErr ; ?>">
    <label for="editPassword" class="col-md-5 control-label control-label.has-error">Password</label>
    <div class="col-md-7">
    <div class="controls">
      <input name="editpassword" type="text" data-minlength="4" class="form-control" id="editPassword" 
      	placeholder="*password" value="<?php echo $_SESSION['editpassword'];?>">
     </div>
      <span class="help-inline"><?php echo $passwordMsg; ?></span>    </div>
	  <div class="col-md-5"></div>	
	  <div class="col-md-7">
      <div class="help-inline"><small>*If this field is not entered then the password will remain unchanged</small></div>
      <div class="col-md-5"></div>
	
    <!--div class="col-md-7">
      < input name="editpasswordconfirm" type="password" class="form-control" id="editPasswordConfirm" 
      	data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="*re-enter password to confirm" 
      	value="<?php echo $_SESSION['editpasswordconfirm'];?>">
      <div class="help-block"><small>*If these fields are not entered then the password will remain unchanged</small></div>
     -->
    </div>
  </div>
</div>
<!-- Active-->
<div class="col-md-4">
<div class="form-group">
  <label class="col-md-4 control-label" for="active">Active</label>
  <div class="col-md-3">
  <div class="radio inline ">
    <label for="radios-0">
      <input name="active" id="radios-0" value="1"<?php echo $active;?> type="radio">
      Yes
    </label>
	</div>
</div>
<div class="col-md-3">
  <div class="radio inline">
    <label for="radios-1">
      <input name="active" id="radios-1" value="2" <?php echo $inactive;?>type="radio">
      No
    </label>
	</div>
  </div>
</div>
<!--  Access Level -->

<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Type</label>
  <div class="col-md-8">
    <select id="selectbasic" name="access" class="form-control">
      <option value="1"  <?php 	echo $selPublisher	;?> >Publisher</option>
      <option value="2"  <?php echo $selUnaffiliated;?> >Unaffiliated</option>
      <option value="10" <?php 	echo $selAdmin		;?> >Administrator</option>
    </select>
  </div>
</div>

<!-- Button -->
 
  <div class="controls">
   <div class="row text-center" style="padding:50px">
    <button type="submit" id="save" name="save" value="user" class="btn btn-primary ">Save</button>
   </div>	
<?php if(($_SESSION['mode']	=='edit') && ($_SESSION['entity'] ==	'user'))     {	?>
  <!-- Cancel -->	        
   <div class="row text-center">
      <button name="cancel" value="user" type="submit" class="btn btn-default ">Cancel</button>
   </div>  
<!-- DELETE BUTTON	-->
   <div class="row text-center" style="padding:10px">
    <button type="button" class="btn btn-danger" onClick="triggerModal('<?php echo $_SESSION['id'] ; ?>')">Delete
    </button>
   </div>  
<?php $modalBody	=	"<center>Click OK to continue or Cancel</center>";
 } ?>

   </div>
</div>
</div>
</fieldset>
   <div id="largeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h4 class="modal-title"><center>Delete User: <b><?php echo $_SESSION['editfirstname'].' '.$_SESSION['editlastname'];?></b></center></h4>
            </div>
  
        	<form method="post" id="action_submit" action="./?delete">     
              <div class="modal-body"><?php echo $modalBody ;?>
                     <input type="hidden" name="titleId" id="the_id" >
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                 <button name="delete" type="submit" class="btn btn-success btn-primary" value="<?php echo $_SESSION['id'];?>"><?php echo 'OK' ;?></button>
              </div>
             </form>
          </div>
        </div>
    </div>
</form>
</div>
</div>
<!-- Company Form -->
 <div class="panel panel-success">
   <div class="panel-heading"><?php echo $mode; ?>Company details</div>
   <div class="panel-body">
  
     <form role="form" class="form-horizontal" method="post">

		<fieldset>
		  <div class="row">
			<div class="col-md-8">
			<!-- Company Name-->
				<div class="form-group <?php echo $companyNameErr ; ?>">
  				  <label class="col-md-5 control-label control-label.has-error" for="companyname">Company Name</label>
 				  <div class="col-md-7">
    				  <input id="companyname" name="companyname" placeholder="Company" class="form-control  input-md"  required type="text"
   				 	    value="<?php echo $_SESSION['companyname'] ; ?>"> 
 				    <span class="help-inline"><?php echo $companyNameMsg; ?></span>
 				  </div>
 				</div>

			<!-- Company url -->
				<div class="form-group <?php echo $companyUrlErr ; ?>">
  				  <label class="col-md-5 control-label control-label.has-error" for="companyurl">Url</label>
 				  <div class="col-md-7">
  				    <div class="required-field-block">
    				  <input id="companyurl" name="companyurl" placeholder="http:// ..." class="form-control  input-md"  type="url"
   				 	    value="<?php echo $_SESSION['companyurl'] ; ?>"> 
   				    </div>
 				    <span class="help-inline"><?php echo $companyurlMsg; ?></span>
 				  </div>
 				</div>
   			</div>
<!-- Button -->
			<div class="col-md-4">
  				<div class="controls">
   					<div class="row text-center" style="padding:10px">
    					<button type="submit" id="save" name="save" value="company" class="btn btn-primary ">Save</button>
   					</div>	
<?php if(($_SESSION['mode']	=='edit')      && ($_SESSION['entity'] ==	'company')) {	?>
  <!-- Cancel -->	        
   				<div class="row text-center style="padding:10px"">
      				<button name="cancel" value="user" type="submit" class="btn btn-default ">Cancel</button>
<!-- DELETE BUTTON	-->
    				<button type="button" class="btn btn-danger" onClick="triggerCompanyModal('<?php echo $_SESSION['companyname'] ; ?>')">Delete
    				</button>
   				</div>  
<?php $modalBody	=	"<center>Click OK to continue or Cancel</center>";
 } ?>

   				</div>
  			</div>  
   		  </div>
   <div id="deleteCompanyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header" id="myModalLabel">
                <button type="button" class="close" data-dismiss="modal" >x</button>
                    <h4 class="modal-title"><center>Delete Company: <b><?php echo $_SESSION['companyname'];?></b></center></h4>
            </div>
  
        	<form method="post" id="action_submit" action="./?delete">     
              <div class="modal-body"><?php echo $modalBody ;?>
                     <input type="hidden" name="titleId" id="the_id" >
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                 <button name="deletecompany" type="submit" class="btn btn-success btn-primary" value="<?php echo $_SESSION['companyname'];?>"><?php echo 'OK' ;?></button>
              </div>
             </form>
          </div>
        </div>
    </div>
   		  
   		</fieldset>
     </form>
    </div>
   </div>
</div>
<div class="col-md-4">
 <div class="panel panel-default">
   <div class="panel-heading">Publishers</div>
   <div class="panel-body" style="padding:0px;">
	 <div class="userbodycontainer scrollable" style="background-color:#ffffff; padding:5px">
<?php
unset($_SESSION['ok']); 
$_SESSION['editfirstname']		=	"";
$_SESSION['editlastname']		=	"";
$_SESSION['editpublishername']	=	"";
$_SESSION['editposition']		=	"";
$_SESSION['edittelephone']		=	"";
$_SESSION['editemail']			=	"";
$_SESSION['editactive']			=	"";
$_SESSION['editaccess']			=	"";
$_SESSION['editpassword']		=	"";
$_SESSION['editpasswordconfirm']=	"";
$_SESSION['err']				=	"";
$_SESSION['mode']				=	"";
$_SESSION['deleted']			=	"";
  /*
   * 	Build the grid.
   */
$page	=	'<b>'.$row.'</b>';

foreach($admin as $key=>$user)	{										// Data
	switch ($user->access_level)	{
		case '1':
			$access_level	=	'Publisher';
			break;
		case '2':
			$access_level	=	'Unaffiliated';
			break;
		case '10':
			$access_level	=	'Administrator';
			break;	
		}
	if($user->active 	==	"y")	$active	= "Active";
	else $active	=	'<b style="color:red">  Not Active</b>';
	
	$row	=	'<small><div class="row ">';
	$row	.=	'<div class="col-xs-8 "><a href="edit?user='.$user->id.'">'. $user->real_name.' '.$user->lastname. '</a></div>';
	$row	.=	'<div class="col-xs-4">'. $access_level.'</div>';
//	$row	.=	'<div class="col-xs-2 main-area">'. $user->position. '</div>';
	$row	.=	'<div class="col-xs-8 ">'. $user->email. '</div>';
	$row	.=	'<div class="col-xs-4 ">'. $user->publisher. '</div>';
	$row	.=	'<div class="col-xs-12">'. $active. '</div>';
	//	$row	.=	'<div class="col-md-1"> edit...</div>'
	;
	
	$row 	.=	'</div></small><hr>';
	$page	.=	$row;
}
echo $page;
//var_dump($_SESSION['mode']);
?>
</div></div></div></div>

<!-- 
		Companies List  
							-->

<div class="col-md-4">
 <div class="panel panel-default">
   <div class="panel-heading">Companies</div>
   <div class="panel-body" style="padding:0px; padding-top:15px">
	 <div class="companybodycontainer scrollable" style="background-color:#ffffff; padding:5px">
<?php
  /*
   * 	Build the grid.
   */
$page	=	'';

foreach($_SESSION['publisherNames'] as $idx=>$company)	{
	$row	=	'<small><div class="row ">';
	$row	.=	'<div class="col-xs-8 "><a href="edit?company='.base64_encode($company).'">'. $company. '</a></div>';
	$row 	.=	'</div></small>';
	$page	.=	$row;
}
echo $page;
//var_dump($_SESSION['mode']);
?>
</div></div></div></div>


</div>	
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
function triggerModal(avalue) {
 
    document.getElementById('the_id').value = avalue;
 
    $('#largeModal').modal();
 
}
</script>
<script type="text/javascript">
function triggerCompanyModal(avalue) {
 
    document.getElementById('the_id').value = avalue;
 
    $('#deleteCompanyModal').modal();
 
}
</script>
<script>
function choosePublisher(data)
{
   document.getElementById("publishername").value = data.value;
}</script>
</body>
</html>
