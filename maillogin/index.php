<?php
session_start();
require_once 'classes/User.php';
$user_login = new User();

//ist true wenn eine User-Session existiert
if($user_login->is_logged_in()!="")
{
	$user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	
	//ckeckt Nutzer-Status(aktiviert/nicht aktiviert) und Passwort. Setzt Session_id
	if($user_login->login($email,$upass))
	{
		$user_login->redirect('home.php');
	}
}
?>


<!-- User logt sich ein, 

oder bekommt eine Fehlermeldung mit Link 

um sein Passwort ggf. zurückzusetzten -->


<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include('view/partials/head.php'); ?>
   
  </head>
  <body class="background">
		<div class="container">
			<div class= "row">
				<div class="col-md-6 col-md-offset-3">
					
					<?php 
					if(isset($_GET['inactive']))
					{
					?>
						<div class='alert alert-error'>
							<button class='close' data-dismiss='alert'>&times;</button>
							<strong>Sorry!</strong> Dieser Account ist noch nicht aktiviert. Bitte check deine Emails. 
						</div>
					<?php
					}
					?>
				</div><!--Ende von col-6 für Überschrift-->
			</div><!--Ende der row-->
			
			<div class= "row"><!--für Login Formular-->
				<div class="col-md-4 col-md-offset-4">
				
					<form method="post">
						<?php
						//Wenn login nicht erfolgreich: Fehlermeldung. Link um Passwort zurücksetzen
						if(isset($_GET['error']))
						{
						?>
							<div class='alert alert-success'>
								<button class='close' data-dismiss='alert'>&times;</button>
								<strong>Falsche Email oder Passwort</strong> <br>
								<span><a href="fpass.php">Passwort vergessen!</a></span>
							</div>
						<?php
						}
						?>
						<h2>Login</h2>
						<span>
							<a href="signup.php">oder neu anmelden</a>
						</span>
						
						<div class="form-group">
							<input type="email" class="form-control" placeholder="Email" name="txtemail" required />
							<input type="password"  class="form-control" placeholder="Passwort" name="txtupass" required />
							<button class="btn btn-block btn-primary" type="submit" name="btn-login">Login</button>
						</div>
					</form>
					
				</div><!--Ende von col-4 für Formular-->
				
			</div><!--Ende div row -->
		</div> <!--Ende div container -->
      
	<footer><?php include('view/partials/footer.php'); ?></footer>
   <?php include('view/partials/scripts.php'); ?>
	
   
  </body>
</html>