<?php
    include('dbcon.php');
    include('check.php');

    if (is_login()){
        ;
    }else
        header("Location: index.php"); 

	include('head.php');
?>

<div align="center">
<?php
	$user_id = $_SESSION['user_id'];

	try { 
		$stmt = $con->prepare('select * from users where username=:username');
		$stmt->bindParam(':username', $user_id);
		$stmt->execute();

   } catch(PDOException $e) {
		die("Database error: " . $e->getMessage()); 
   }

   $row = $stmt->fetch();
   
?>

<?php 
//capitalize username
$string = $_SESSION['user_id']; 
$username = ucfirst($string);
?>

<head>
<title> Home - Centro Bus Web Application </title>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

<style>
.jumbotron {
	background-color:#0071C1;
	color:white;
}

.tab-content {
	border-left: 1px solid #ddd
	border-right: 1px solid #ddd
	border-bottom: 1px solid #ddd
	padding: 10px;
}

.nav-tabs {
	margin-bottom: 0;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #0071C1;
  margin-bottom: 25px;
}
</style>
</head>

<div class="container-fluid">
<div class="jumbotron">
<p>
<h1 class="display-3">Welcome, <?php echo $username; ?>!</h1>
</div>
</div>

      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2>Routes</h2>
            <p>Select specific routes and obtain respective stops.</p>
            <p><a class="btn btn-secondary" href="routes.php" role="button">View Routes &raquo;</a></p>
			<hr>
          </div>
          <div class="col-md-6">
            <h2>Schedules</h2>
            <p>View the schedule of selected routes.</p>
            <p><a class="btn btn-secondary" href="schedules.php" role="button">View Schedules &raquo;</a></p>
			<hr>
          </div>
        </div>

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>