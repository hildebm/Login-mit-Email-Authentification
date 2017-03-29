<?php
require_once 'classes/User.php';
$user = new User();

//aus Link um Nutzer-Passwort zurückzusetzen:
//bei fehlerhaften Informationen redirect zum Login
if(empty($_GET['id']) && empty($_GET['code']))
{
	$user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	//code mit token vergleichen
	$stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid AND tokenCode=:token");
	$stmt->execute(array(":uid"=>$id,":token"=>$code));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() == 1)
	{
		if(isset($_POST['btn-reset-pass']))
		{
			//neues Passwort zweimal eingeben 
			$pass = $_POST['pass'];
			$cpass = $_POST['confirm-pass'];
			
			if($cpass!==$pass)
			{
				$msg = "<div class='alert alert-block'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Passwörter stimmen nicht überein.</strong>   
						</div>";
			}
			else
			{
				//neus Passwort speichern
				$password = md5($cpass);
				$stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userID=:uid");
				$stmt->execute(array(":upass"=>$password,":uid"=>$rows['userID']));
				
				$msg = "Neues Passwort gespeichert.";
						
				//nach 5 Sekunden zurück zum Login
				header("refresh:5;index.php");
			}
		}	
	}
	else
	{
		$msg = "<div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				Nutzer nicht gefunden.
				</div>";
				
	}
	
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include('view/partials/head.php'); ?>
   
  </head>
  <body class ="background">
		<div class="container">
			<div class= "row">
				<div class="col-md-4 col-md-offset-4">
					
					<div class='alert alert-success'>
						<strong>Hallo, <?php echo $rows['userName'] ?>!</strong> Du bist hier um dein Passwort zurückzusetzen.
					</div>
					
					<form method="post">
					<?php
						//Fehlermeldung oder Passwort erfolgreich zurückgesetzt
						if(isset($msg))
						{ ?>
                            <div class='alert alert-success'>
                                <button class='close' data-dismiss='alert'>&times;</button>
                                <?php echo $msg; ?>
                            </div>
				    <?php }?>
					
					<input type="password" class="form-control" placeholder="Neues Passwort" name="pass" required />
					<input type="password" class="form-control" placeholder="Passwort erneut eingeben" name="confirm-pass" required />
					<button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Neus Password bestätigen.</button>
					
				  </form>



				</div><!--Ende col-4 -->
				
			</div><!--Ende div row -->
		</div> <!--Ende div container -->
	<footer class="footer"><?php include('view/partials/footer.php'); ?></footer>
   
	<?php include('view/partials/scripts.php'); ?>
   
  </body>
</html>
