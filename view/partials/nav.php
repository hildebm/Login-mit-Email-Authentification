<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
	<div class="container-fluid">
	
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
	
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<!--<li class="nav-item">
			  <a class="nav-link" href="index.php">Home</a>
			</li>-->
			<li class="nav-item">
			  <a class="nav-link" href="#"><?php echo $row['userName']; ?></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="logout.php">Logout</a>
			</li>
		  </ul>
		 </div>
	 </div>
</nav>