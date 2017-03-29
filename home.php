<?php
session_start();
require_once 'classes/User.php';
$user_home = new User();

//wenn keine Sessoin gestartet: redirect zum Login
if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

//stellt Inhalte wzB UserName für Navigation bereit
$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include('view/partials/head.php'); ?>
  </head>
  
  <body class ="home">
	<!--navigation-->
	<?php include('view/partials/nav.php'); ?>
	
	<!-- Homepage Inhalte -->
       <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2>Dummy Homepage</h2>
                </div>
            </div>
             <div class="row">
                <div class="col-md-12">
                    verwendet eine Abwandlung von Landing-Page-Bootstrap-Theme <br/>
                    Licence im Hauptpfad

                </div>
            </div>

        </div>
	<footer class="footer"><?php include('view/partials/footer.php'); ?></footer>
	
	<?php include('view/partials/scripts.php'); ?>
  </body>
</html>