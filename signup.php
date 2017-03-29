<?php
session_start();
require_once 'classes/User.php';

$reg_user = new User();

//ist true wenn eine User-Session existiert
if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}

/* 
* Der neue Nutzer registriert sich und erhält eine Mail mit einem activation link 
*/

if(isset($_POST['btn-signup']))
{
	$firstName = trim($_POST['txtfirstname']); 
	$lastName = trim($_POST['txtlastname']);
	$uname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
	$ucpass = trim($_POST['txtcpass']); //wiederholtes passwort. Übereinstimmung wird in valid_signup.js geprüft
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC); //associative array
	
	if($stmt->rowCount() > 0)
	{
		//error message: Email existiert bereits
		$msg = "<strong>Fehler !</strong>Deine Email ist bereits registriert. Hast du dein <a href='fpass.php'>Passwort vergessen</a>?</span>";
	}
	else
	{
		if($reg_user->register($uname,$firstName,$lastName,$email,$upass,$code))
		{		
			echo "has registred.";
			//entnimmt ID des neuregistrierten Nutzers
			$id = $reg_user->lasdID();
			//Verschlüsselt ID für den activation-link
			$key = base64_encode($id);
			$id = $key;
			
			//Mail Inhalt
			$message = "					
						Hello $uname,
						<br /><br />
						Willkommen!<br/>
						Um deinen Account zu aktivieren, klick auf folgenden Link!<br/>
						<br /><br />
						<a href='http://localhost/maillogin/verify.php?id=$id&code=$code'>Meinen Account aktivieren!</a>
						<br /><br />
						Regards, ...";
						
			$subject = "Anmeldung abschließen";
						
			$reg_user->send_mail($email,$message,$subject);	
			
			//Nachricht an Nutzer nach erfolgreicher Registrierung
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Email verschickt</strong> an $email.
						Klick auf den Link um deine Anmeldung zu bestätigen. 
			  		</div>
					";
		}
		else
		{
			echo "Query konnte nicht ausgeführt werden...";
		}		
	}
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include('view/partials/head.php'); ?>
   
  </head>
  <body class="background">
		<div class="container">
			
			<div class= "row"><!--für Login Formular-->
				<div class="col-md-4 col-md-offset-4">
					<!-- id register-form für jQuery validation: valid_signup.js -->
					<form method="post" id="register-form">
						<?php 
						//Fehlermeldung:Nutzer-email existiert schon oder Nachricht, dass eine Mail verschickt wurde
						if(isset($msg))
						{?>
                            <div class='alert alert-success'>
								<?php echo $msg; ?>
							</div>
						<?php }
						?>
                        
                        <h2>Neu Anmelden</h2>
						<span>
							<a href="index.php">oder Login</a>
						</span>
						
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Vorname" name="txtfirstname" required />
							<span class="help-block" id="error"></span>  <!-- jQuery validation errors-->
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Nachname" name="txtlastname" required />
							<span class="help-block" id="error"></span>  <!-- jQuery validation errors-->
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Nutzername" name="txtuname" required />
							<span class="help-block" id="error"></span>  <!-- jQuery validation errors-->
						</div>
						<div class="form-group">
							<input type="email" class="form-control" placeholder="Email-Addresse" name="txtemail" required />
							<span class="help-block" id="error"></span>  <!-- jQuery validation errors-->
						</div>
						<div class="form-group">
							<input type="password" id="passwort" class="form-control" placeholder="Passwort" name="txtpass" required />
							<span class="help-block" id="error"></span>  <!-- jQuery validation errors-->
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Passwort wiederholen" name="txtcpass" required />
							<span class="help-block" id="error"></span>  <!-- jQuery validation errors-->
						</div>
							<button class="btn btn-block btn-primary" type="submit" name="btn-signup">Register</button>
					</form>

				</div><!--Ende von col-4 für Formular-->
				
			</div><!--Ende div row -->
		</div> <!--Ende div container -->
	<footer><?php include('view/partials/footer.php'); ?></footer>
   
	<?php include('view/partials/scripts.php'); ?>
   
  </body>
</html>
