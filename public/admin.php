<?php
include '.env.php';

echo "<HTML><HEAD><TITLE>MotoGP Admin</TITLE>
    <link rel='shortcut icon' type='image/gif' href='images/meeple.gif'></link>
    <LINK REL='STYLESHEET' HREF='/css/main.css' TYPE='text/css' MEDIA='screen'></link>
    </HEAD> 
    <center><h2> Admin Screen</h2></center>";

//get post variables
$state=$_POST['state'];
if ($state == 'login'){
    $state = 5;
}


//Check for propper access
if ($state == 0){
    echo "<H2> You don't belong here!! </H2>";
     echo "<a href='http://motogo.partymeeple.com.au/admin-door.php'>click here to try loging in again</a></center>";
} else {

// **Create connection**
$db = new mysqli($host, $user, $password, $db_name);
// Always check for errors
if($db->connect_errno){
    echo "Members Connection bloody failed: " . $db->connect_error . "<BR>";
    }



echo "<center><H2>Entry state is - ". $state."</H2></center>";

//get rider list
$rider_names=file('rider-list.txt');

//do the work
switch ($state) { 
    case 1:
        //Proccess Bids
        //initiate bid file variable
        $bidfile = "<center><table>";

        foreach ($rider_names as $name){
            $name = str_replace(' ','_',$name);
            $sql = "SELECT username, $name FROM bids WHERE $name IS NOT NULL ORDER BY $name DESC";
                        
            // **Execute query**
            $result = $db->query($sql);
            // Always check for errors
            if($db->connect_errno){
                echo "DB Connection failed: " . $db->connect_error . "<BR>";
            }            
            // check if there are bids            
            if ($result->num_rows > 0) {           
                // output data of each row and set high bid check
                $highbid = 0;
                $bidfile = $bidfile."<tr><th colspan='2'> ".$name." </th></tr>";
                 while($row = $result->fetch_assoc()) {
                    $bidder = array_values($row);
                    $bidfile = $bidfile."<tr><td>".$bidder[0]."</td><td>".$bidder[1]."</td></tr>";
                    if ($highbid == 0){
                        $sql1= "SELECT balance FROM members WHERE username= '$bidder[0]'";
                        // **get users balance**
                        if($userbalance = $db->query($sql1)){
                            $oldbalance = $userbalance -> fetch_assoc();
                            $newbalance= $oldbalance['balance'] - $bidder[1];
                            echo "rider ".$name."  ".$bidder[0]."** old ".$oldbalance['balance']." bid ".$bidder[1]." new balance ".$newbalance;
                            $sql = "UPDATE members SET balance='$newbalance' WHERE username ='$bidder[0]'";
                            if ($db->query($sql) == TRUE) {
                                echo "** Balance updated<BR>";
                            } else {
                                echo "Error updating user balance: " . $db->error."<BR>";
                            }
                        }else{
                        "DB balance query failed: " . $db->connect_error . "<BR>";
                        }
                        
                    }  
                //echo $highbid. " high bid ";
                ++$highbid;                
                }
            
            }            
                
        }
        $bidfile = $bidfile."</table></center>";
        echo $bidfile;
        //email file to me
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
        if(mail("andrew@partymeeple.com.au","MotoGP bids backup",$bidfile,$headers)){
        echo "<p>Email sent OK to me.. <BR>";
        }
        if(mail("gelignite@aloku.net","MotoGP bids backup",$bidfile,$headers)){
        echo "<p>Email sent OK to Joce.. <BR>";
        }
        //save the txt file that is the winning bids
        $bids_txt = fopen("rider-bids.txt", "w");
        fwrite($bids_txt, $bidfile);
        fclose($bids_txt);
        break;

    case 2:
        //add a player
        echo "<P>Adding Player<BR>";
	$new_player = $_POST['new_player'];
	$new_password = $_POST['new_password'];
	$new_email = $_POST['new_email'];

    //hash password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
	
	// update SQL member table
	$sql = "INSERT INTO members (`username`, `password`, `email`,`balance`) VALUES ('$new_player','$hashed_password','$new_email', 20)";
	if ($db->query($sql) == TRUE) {
        	echo "** New User Created in member table**<BR>";
                } else {
                echo "Error creating new user " . $db->error." -- ". $db->errno ."<BR>";
	}
    // update SQL bids table
    $sql = "INSERT INTO bids (`username`) VALUES ('$new_player')";
	if ($db->query($sql) == TRUE) {
        	echo "** New user added to bid table **<BR>";
                } else {
                echo "Error creating adding user to bid table " . $db->error." -- ". $db->errno ."<BR>";
	}
	
	//email the new player
	$messagefile =" Hi ". $new_player .",<p>welcome to the 2018 MotoGP bidding game.<p>The password you've chosen is <b>". $new_password . "</b>.<p>
	Go to <b>motogo.partymeeple.com.au</b> and login before race day to place your 3 bids.  <p>Cutoff is from 12am (UTC) the day of the race. 
	You have 20 pts to spend as an opening balance. <p> Good luck..";
	$headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
        if(mail($new_email,"Welcome to 2019 MotoGP bidding",$messagefile,$headers)){
        echo "<p>Email sent OK.. <BR>";
        }
        break;

    case 3:
        //Do race results
        echo "<P>Proccessied Results <BR>";
        include 'do-results.php';
        break;

    case 4:
        //Clear bid table
	$sql = "UPDATE bids SET ";	
	foreach ($rider_names as $name){
	$name = str_replace(' ','_',$name);
        $sql = $sql . $name ." = NULL,"; 
	}
	$sql = rtrim($sql, "\,");

        if ($db->query($sql) != TRUE) {
            	echo "<p>Error clearing bid table<br> " . $db->error;
            	}else{
		echo "<P>Bid table Cleared OK<BR>";
		}               
        break;
    case 5:
        //Entry case
        echo "<p>Admin entry screen. <BR><P>Waiting for an action.";
        break;
    case 6:
        //write new message
        $new_message = $_POST['message_text'];
        $message_file = fopen('message.txt', 'w');
        fwrite($message_file, $new_message);
        fclose($message_file);    
        //clear comments box
        $comment_file = fopen('comments.txt', 'w');       
        fwrite($comment_file, '');
        fclose($comment_file);
        echo "<p>Comments box has been cleared <BR>";
        break;
    case 7:
        //reset user password
        $player = $_POST['player'];
	    $new_password = $_POST['new_password'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
              
        $sql = "UPDATE members SET password = '$hashed_password' WHERE username = '$player'";
	    if ($db->query($sql) == TRUE) {
        	echo "<center>** New password for user ". $player ." added to member table **</center><BR>";
                } else {
                echo "<center>DB Error setting password in member table " . $db->error." -- ". $db->errno ."</center><BR>";
	    }
        
}

//Proccess bids
echo "<center><HR><H2>Proccess The Bids</H2>
      clicking here creates a winning bid file that can be posted to the fron page.";
echo "<form method='post' action='admin.php'>";
echo "<input name='state' type='hidden' value= '1'>
      <input type='submit' value='CLICK to post bids'>
      </form></center><HR>"; 

//Clear bid table
echo "<center><H2>Clear The Bid Table</H2>
     Remember to clear the bids each round";
echo "<form method='post' action='admin.php'>";
echo "<input name='state' type='hidden' value= '4'>
      <input type='submit' value='CLICK to clear'>
      </form></center><HR>";

//Enter Race results
echo "<form method='post' action='admin.php'>";
echo "<center><H2>Final Rider Race Positions</H2>";
          
for ($pos = 1; $pos <= 8; $pos++){
    $fplace = 'place'.$pos;
    echo "Finishing Place ".$pos."<BR>";    
    echo  "<select name='$fplace' size='4'>";
    foreach ($rider_names as $name){
    echo "<option value='$name'>$name</option>";
    }
    echo "</select><BR><BR>";
}
echo "<input name='state' type='hidden' value= '3'>
      <input type='submit' value='Enter rider positions'>
        </form></center><HR>";

//Add a new player
echo "<center><H2>Add A New Player</H2>
     You can add a new player here and send them a confirmation email";
echo "<form method='post' action='admin.php'>";
echo "<input name='new_player' type='text' value= 'name' style='width: 150px'><BR>
      <input name='new_password' type='text' value= 'password' style='width: 150px'><BR>
      <input name='new_email' type='text' value= 'email@email.com' style='width: 150px'><BR>";
echo "<input name='state' type='hidden' value= '2'>
      <input type='submit' value='Enter New Player'>
      </form></center><HR>";
//Reset a password
echo "<center><H2>Reset a players password</H2>
     Enter the players name and new password";
echo "<form method='post' action='admin.php'>";
echo "<input name='player' type='text' value= 'player name' style='width: 150px'><BR>
      <input name='new_password' type='text' value= 'new password' style='width: 150px'><BR>";
echo "<input name='state' type='hidden' value= '7'>
      <input type='submit' value='Enter players new password'>
      </form></center><HR>";
 

//Clear comments box
echo "<form method='post' action='admin.php'>";
echo "<center><H2>Clear The Comments</H2>
    Clicking here will reset the comments box<BR> and add content to the news/message box<BR>
     <textarea name='message_text' rows='8' cols='50'>    
    </textarea><BR>";
echo "<input name='state' type='hidden' value= '6'>
      <input type='submit' value='CLICK to clear comments'>
      </form></center><HR>";     

$db->close();
}
echo "<P><BR><BR><center>end admin code..<center> </HTML>";
?>
