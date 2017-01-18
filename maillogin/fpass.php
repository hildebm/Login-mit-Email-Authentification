<?php
session_start();
require_once 'classes/User.php';
$user = new User();

//gibt true zurück, wenn Session gestartet
if($user->is_logged_in()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-submit']))
{	
	//Nutzer gibt Email für Passwort Rücksetzung ein
	$email = $_POST['txtemail'];
	
	//DB-Eintarg des Nutzers
	$stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['userID']);
		$code = md5(uniqid(rand()));
		
		$stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		//Mail-Inhalt
		$message= "
				   Hallo , $email
				   <br /><br />
				   Um dein Passwort zurückzusetzen klick bitte auf folgenden Link, dann kannst du dein neues Passwort eingeben: 
				   <br /><br />
				   <a href='http://localhost/maillogin/resetpass.php?id=$id&code=$code'>Mein Passwort jetzt zurücksetzen!</a>
				   <br /><br />
				   Mit freundlichen Grüßen,
				   <br /><br />... 
				   ";
		$subject = "Password Zuruecksetzen";
		
		$user->send_mail($email,$message,$subject);
		
		//Meldung an Nutzer nach Eingabe der Mail-Adresse
		$msg = "<div class='alert alert-success'>
					<button class='close' data-dismiss='alert'>&times;</button>
					Es wurde eine Mail an $email verschickt.
                    Klick auf 'Mein Passwort jetzt zurücksetzen!'. 
			  	</div>";
	}
	else
	{
		//Fehlermeldung falls Mail-Adresse nicht in DB vorhanden
		$msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Fehler!</strong>  Email nicht gefunden. 
			    </div>";
	}
}?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include('view/partials/head.php'); ?>
   
  </head>
  <body class="background">
		<div class="container">
			<div class= "row">
				<div class="col-md-4 col-md-offset-4">
					
					<form method="post">
					
						<?php
						if(isset($msg))
						{
							//Fehlermeldung oder Information, dass Email verschickt wurde
							echo $msg;
						}
						else
						{
							?>
							<div class='alert alert-info'>
								Bitte gib deine Email-Adresse ein um dein Passwort zurückzusetzten!
							</div>  
							<?php
						}
						?>
        
						<input type="email" class="form-control" placeholder="Email-Addresse" name="txtemail" required />
						<button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Link anfordern</button>
					</form>
					
				</div><!--Ende von col-6-->
				
			</div><!--Ende div row -->
		</div> <!--Ende div container -->
	<footer class="footer"><?php include('view/partials/footer.php'); ?></footer>
   
	<?php include('view/partials/scripts.php'); ?>
   
  </body>
</html>