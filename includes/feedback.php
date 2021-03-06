<?php 
include('includes/config.php');//connect to database

$name = isset($_POST['name']) ? $_POST['name'] : '';
$people = isset($_POST['people']) ? $_POST['people'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : ''; 
//$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = array("name" => "","people" => "", "feedback" => "","database" => "", "check" => "");


if($_POST){
    if(!empty($_POST['website'])) die(); //honeypot - if not empty - scrypt stop;

    if(strlen($name)>0 && strlen($feedback)>0 && strlen($people) && strlen($date)) {

         //test sql injection        
        $name = $conn->real_escape_string($name);
		$people = $conn->real_escape_string($people);
		$feedback = $conn->real_escape_string($feedback);
        
        //Write to the table 
        $saved = $conn->query("INSERT INTO `feedback`(`name`, `people`, `datetime`, `mesage`) VALUES ('$name','$people', '$date', '$feedback')");
            if($saved){
                $_SESSION['success_msg'] = "Your message has been successfully sent";
                header('Location:' . $_SERVER['PHP_SELF']); 
                 
            }else{ 
				$error['database'] = "Error when saving"; //if not save to DB
			}

    } else { //cheking input one by one
        if(strlen($name) == 0){
            $error['name'] = 'Error - Please fill name field!';
        }
        if(strlen($name) > 70){
            $error['name'] = 'Error - Max charakters reached!';
        }
        if(strlen($people) == 0){
            $error['people'] = 'Error - Please fill people field!';
        }
        if(strlen($feedback) == 0){
            $error['feedback'] = 'Error - Please fill in feedback field!';
        }
       
    }
}

?>
<div id="response"><!-- you message will appear here --></div>
<form method="POST" id="form" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <span><?php echo $error['name']; ?></span><input type="text" required name="name" placeholder="Name" 
            value="<?php echo $name;?>" />
        <span><?php echo $error['people']; ?></span><input type="number" placeholder="How many people" required name="people"
            value="<?php echo $people;?>"/>
        <input type="datetime-local" placeholder="Date and time" required name="date" value="2018-10-15T20:00"/>
            <?php echo $feedback;?>
        <span><?php echo $error['feedback']; ?></span><textarea name="feedback" placeholder="Message"><?php echo $feedback;?></textarea>
        <input type="text" id="website" name="website"/>
        <span><?php echo $error['database']; ?></span>
        <button type="submit" class="submit" >SEND MESSAGE</button>
</form>
<!-- notification message -->
<?php if (isset($_SESSION['success_msg'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success_msg']; 
            unset($_SESSION['success_msg']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>
