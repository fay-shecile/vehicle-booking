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
$tableContent = '';
$start = '';
$selectStmt = $con->prepare('SELECT * FROM vehicles ORDER BY tmstmp DESC limit 10');
$selectStmt->execute();
$users = $selectStmt->fetchAll();

foreach ($users as $user)
{
    $tableContent = $tableContent.'<tr>'.
            '<td>'.$user['vid'].'</td>'
            .'<td>'.$user['tmstmp'].'</td>'
			.'<td>'.$user['des'].'</td>'
			.'<td>'.$user['lat'].'</td>'
			.'<td>'.$user['lon'].'</td>';
}

if(isset($_POST['search']))
{
$start = $_POST['start'];
$tableContent = '';
$selectStmt = $con->prepare('SELECT * FROM vehicles WHERE tmstmp like :start');
$selectStmt->execute(array(
        
         ':start'=>$start.'%'
));

$users = $selectStmt->fetchAll();

foreach ($users as $user)
{
    $tableContent = $tableContent.'<tr>'.
            '<td>'.$user['vid'].'</td>'
            .'<td>'.$user['tmstmp'].'</td>'
			.'<td>'.$user['des'].'</td>'
			.'<td>'.$user['lat'].'</td>'
			.'<td>'.$user['lon'].'</td>';
}
    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Search & Display Using Selected Values</title>  
        <style>
            table,tr,td
            {
               border: 1px solid #000; 
            }
            
            td{
                background-color: #ddd;
            }
			body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: white;
}

* {
  box-sizing: border-box;
}

/* Add padding to containers */
.container {
  padding: 16px;
  background-color: #f1f1f1;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: white;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: white;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #0071C1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #0071C1;
  text-align: center;
}
        </style>   
    </head>
    <body>
        <h1><c> History of Routes </c></h1>
        <form action="vehicles.php" method="POST">
            <!-- 
For The First Time The Table Will Be Populated With All Data
But When You Choose An Option From The Select Options And Click The Find Button, The Table Will Be Populated With specific Data 
             -->
            <select name="start">
                <option value="null"<?php if($start == 'null'){echo '';}?>>Select a time</option>
                <option value="20191127 06:31:18" <?php if($start == '20191127 06:31:18'){echo 'selected';}?>>20191127 06:31:18</option>
				
            </select>
            <input type="submit" name="search" value="Find">
			
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
 $( ".date" ).datepicker({
 dateFormat : 'mm/dd/yy',
 showOn: "both",
 buttonImage: "b_calendar.png",
 buttonImageOnly: true,
 buttonText: "Select date",
 changeMonth: true,
 changeYear: true,
 yearRange: "-100:+0"
 }); 
}); 
</script>
<br>

					
            <div class="container">
			<hr>
            <table class="table">
			<thead>
                <tr>
                    <th>Vehicle ID</th>
                    <th>time</th>
					<th>destincation</th>
					<th>latitude</th>
					<th>Longitude</th>
                </tr>
            </thead>

			<tbody>
                <?php
			if(isset($_POST['search'])){
				echo $tableContent;
			}
                ?>
				</tbody>
            </table>
			<hr>
            </div>
        </form>

    </body>    
</html>