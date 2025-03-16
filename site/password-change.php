<?php
echo "<HTML><HEAD><TITLE>MotoGP bidding 2018</TITLE>
    <link rel='shortcut icon' type='image/gif' href='images/meeple.gif'></link>
    <LINK REL='STYLESHEET' HREF='/css/main.css' TYPE='text/css' MEDIA='screen'></link>
    </HEAD>";

// username and password sent from form 
$pswd1 =$_POST['password-1']; 
$pswd2 =$_POST['password-2'];
$user =$_POST['member'];

if ($pswd1 == $pswd2)
    {echo "<h2> Hi " .$user. " Your passwords matched </H2><br>";
//set up db variables
    $host="localhost"; // Host name 
    $username="partymee_andrew"; // Mysql username 
    $password="Spacey7303"; // Mysql password 
    $db_name="partymee_moto"; // Database name 
    $tbl_name="members"; // Table name 

// Create connection
    $db = new mysqli($host, $username, $password, $db_name);
// Check for errors
    if($db->connect_errno){
    echo "Database Connection failed: " . $db->connect_error;
    }
    $hashed_password = password_hash($pswd1, PASSWORD_DEFAULT);
    $sql = "UPDATE members SET password='$hashed_password' WHERE username ='$user'";
    if ($db->query($sql) == TRUE) {
        echo "<center> Your new pasword was updated successfully<BR>
              <a href='http://moto.partymeeple.com.au'>Now click here to login in again</a>
              <BR>Best write it down as I'm too lazy to script an 'I forgot my password script'.";
        } else {
        echo "Error updating member record: " . $db->error;
}

$db->close();


    }else{
    echo "<h2>Your passwords are difrent.  Which one would you like us to save?</H2>
     <BR> <center>Shall we try that again?<BR>";
    include 'password-select.php';
    }

echo "</center></html>";
?>
