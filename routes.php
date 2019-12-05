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
$selectStmt = $con->prepare('SELECT * FROM routes');
$selectStmt->execute();
$users = $selectStmt->fetchAll();

foreach ($users as $user)
{
    $tableContent = $tableContent.'<tr>'.
            '<td>'.$user['rt'].'</td>'
            .'<td>'.$user['rtnm'].'</td>';
}

if(isset($_POST['search']))
{
$start = $_POST['start'];
$tableContent = '';
$selectStmt = $con->prepare('SELECT * FROM stops WHERE rtnm like :start');
$selectStmt->execute(array(
        
         ':start'=>$start.'%'
));

$users = $selectStmt->fetchAll();

foreach ($users as $user)
{
    $tableContent = $tableContent.'<tr>'.
            '<td>'.$user['rtnm'].'</td>'
            .'<td>'.$user['stpnm'].'</td>';
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
        
        <form action="routes.php" method="POST">
            <!-- 
For The First Time The Table Will Be Populated With All Data
But When You Choose An Option From The Select Options And Click The Find Button, The Table Will Be Populated With specific Data 
             -->
            <select name="start">
                <option value="">[Select a Route]</option>
       
                <option value="OSW10" <?php if($start == 'OSW10'){echo 'selected';}?>>SUNY Oswego Blue Route</option>
				<option value="OSW11" <?php if($start == 'OSW11'){echo 'selected';}?>>SUNY Oswego Green Route</option>
                <option value="OSW1A" <?php if($start == 'OSW1A'){echo 'selected';}?>>Walmart via 104</option>
				<option value="OSW1B" <?php if($start == 'OSW1B'){echo 'selected';}?>>Walmart - Hamilton Homes</option>
                <option value="OSW1C" <?php if($start == 'OSW1C'){echo 'selected';}?>>Walmart via Seneca Street</option>
				<option value="OSW1D" <?php if($start == 'OSW1D'){echo 'selected';}?>>Walmart via Brandonwood</option>
                <option value="OSW2A" <?php if($start == 'OSW2A'){echo 'selected';}?>>College via 104</option>
				<option value="OSW2B" <?php if($start == 'OSW2B'){echo 'selected';}?>>College via West Seneca</option>
                <option value="OSW2C" <?php if($start == 'OSW2C'){echo 'selected';}?>>College via West Utica</option>
				<option value="OSW2D" <?php if($start == 'OSW2D'){echo 'selected';}?>>College via Ellen St</option>
				<option value="OSW46" <?php if($start == 'OSW46'){echo 'selected';}?>>Oswego - Syracuse</option>		
            </select>
            <input type="submit" name="search" value="Find">
            <div class="container">
			<hr>
            <table class="table">
			<thead>
                <tr>
                    <th>Route ID</th>
                    <th>Stop Name</th>
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