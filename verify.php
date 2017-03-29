<?php
require_once 'classes/User.php';
$user = new User();

if(empty($_GET['id']) && empty($_GET['code']))
{
	$user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	$statusY = "Y";
	$statusN = "N";
	
	$stmt = $user->runQuery("SELECT userID,userStatus FROM tbl_users WHERE userID=:uID AND tokenCode=:code LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":code"=>$code));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0)
	{
		if($row['userStatus']==$statusN)
		{
			$stmt = $user->runQuery("UPDATE tbl_users SET userStatus=:status WHERE userID=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();	
			
			$msg = "
		           <div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>Willkommen!</strong>  Dein Account wurde aktiviert : <a href='index.php'>Weiter zum Login</a>
			       </div>
			       ";	
		}
		else
		{
			$msg = "
		           <div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>Fehler!</strong>  Dein Account ist bereits aktiviert : <a href='index.php'>Weiter zum Login</a>
			       </div>
			       ";
		}
	}
	else
	{
		$msg = "
		       <div class='alert alert-error'>
			   <button class='close' data-dismiss='alert'>&times;</button>
			   <strong>sorry !</strong>  Kein Account gefunden : <a href='signup.php'>Hier neu Anmelden</a>
			   </div>
			   ";
	}	
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include('view/partials/head.php'); ?>
   
  </head>
  <body class="background">
		<div class="container clear-top">
			<div class= "row">
					<div class="col-md-4 col-md-offset-4">

						<?php
						if(isset($msg))
						{?>
                            <div class='alert alert-success'>
								<?php echo $msg; ?>
							</div>
						<?php }
						?>
					</div>
				
			</div><!--Ende div row -->
		</div> <!--Ende div container -->
	<footer class="footer"><?php include('view/partials/footer.php'); ?></footer>
   
	<?php include('view/partials/scripts.php'); ?>
   
  </body>
</html>
