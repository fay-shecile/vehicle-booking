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
$selectStmt = $con->prepare('SELECT * FROM schedule order by day');
$selectStmt->execute();
$users = $selectStmt->fetchAll();

foreach ($users as $user)
{
    $tableContent = $tableContent.'<tr>'.
            '<td>'.$user['rt'].'</td>'
			.'<td>'.$user['time'].'</td>'
			.'<td>'.$user['day'].'</td>';;
}

if(isset($_POST['search']))
{
$start = $_POST['start'];
$tableContent = '';
$selectStmt = $con->prepare('SELECT * FROM schedule WHERE stopid like :start order by day, rt');
$selectStmt->execute(array(
       
         ':start'=>$start.'%'
));

$users = $selectStmt->fetchAll();

foreach ($users as $user)
{
    $tableContent = $tableContent.'<tr>'.
            '<td>'.$user['rt'].'</td>'
			.'<td>'.$user['time'].'</td>'
			.'<td>'.$user['day'].'</td>';
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
        <h1><c> Schedules </c></h1>
        <form action="schedules.php" method="POST">
            <!-- 
For The First Time The Table Will Be Populated With All Data
But When You Choose An Option From The Select Options And Click The Find Button, The Table Will Be Populated With specific Data 
             -->
            <select name="start">
                <option value="">[Select a Stop ID]</option>
				<option value="">---Blue Route---</option>
					<option value="15521" <?php if($start == '15521'){echo 'selected';}?>>SUNY OSWEGO CAMPUS CENTER</option>
				<option value="">---Green Route---</option>
					<option value="15521" <?php if($start == '15521'){echo 'selected';}?>>SUNY OSWEGO CAMPUS CENTER</option>
					<option value="17941" <?php if($start == '17941'){echo 'selected';}?>>RICE CREEK</option>
					<option value="16306" <?php if($start == '16306'){echo 'selected';}?>>LAKER HALL</option>
				<option value="">---Oswego to Syracuse---</option>	
<option value="7755" <?php if($start == '7755'){echo 'selected';}?>>DESTINY USA</option>
<option value="3757" <?php if($start == '3757'){echo 'selected';}?>>GREAT NORTHERN MALL</option>
<option value="10223" <?php if($start == '10223'){echo 'selected';}?>>OSWEGO ST + CYPRESS ST</option>
<option value="8984" <?php if($start == '8984'){echo 'selected';}?>>OSWEGO RD & PINE HOLLOW DRIVE</option>
<option value="15556" <?php if($start == '15556'){echo 'selected';}?>>PUBLIC SAFETY OCJ</option>
<option value="47" <?php if($start == '47'){echo 'selected';}?>>REGIONAL TRANSPORTATION CENTER</option>
<option value="15558" <?php if($start == '15558'){echo 'selected';}?>>ROUTE 57 + LOCK ST</option>
<option value="9673" <?php if($start == '9673'){echo 'selected';}?>>RIVER GLENN SQUARE - FULTON</option>       
<option value="10121" <?php if($start == '10121'){echo 'selected';}?>>SARAH LOGUEN BUS SHELTER</option>
<option value="9863" <?php if($start == '9863'){echo 'selected';}?>>S FRANKLIN ST + W WASHINGTON ST</option>
  <option value="6767" <?php if($start == '6767'){echo 'selected';}?>>S STATE ST + MADISON ST</option>      
<option value="9671" <?php if($start == '9671'){echo 'selected';}?>>TOWPATH TOWERS - FULTON</option>           

				
				<option value="3579" <?php if($start == '3579'){echo 'selected';}?>>W Bridge St & W 3th St</option>				
				
				
				
				
			
				
            </select>
            <input type="submit" name="search" value="Find">
            <div class="container">
			<hr>
            <table class="table">
			<thead>
                <tr>
                    <th>Route</th>
					<th>Time</th>
					<th>Day</th>
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