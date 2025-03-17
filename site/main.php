<!DOCTYPE html>
<html lang="en-US">
<HTML><HEAD><TITLE>MotoGP bidding 2025</TITLE>
<link rel='shortcut icon' type='image/x-icon' href='cog.ico'></link>
<LINK REL='STYLESHEET' HREF='main.css' TYPE='text/css' MEDIA='screen'></link> 
<meta http-equiv='pragma' content='no-cache' />  
<meta http-equiv='expires' content='-1' />
<meta http-equiv='CACHE-CONTROL' content='NO-CACHE'>
</HEAD>

<?php
include '.env.php';

date_default_timezone_set('UTC');
$racetime = date('d-F-Y');

// username, password, state, sent from index.php login form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];
$state=$_POST['state'];

// get password
password_hash($mypassword, PASSWORD_DEFAULT);

if($myusername == 'admin'){
	$state = 'admin';
	$myusername = 'Noisy';
}

// Create connection
$db = new mysqli($host, $user, $password, $db_name);

// Check for errors
if($db->connect_errno){
    echo "Database Connection failed: " . $db->connect_error . "<BR>";
}


// Execute query
$result = $db->query("SELECT password, username, email, balance FROM members WHERE username='$myusername' ");

// Always check for errors
if($db->connect_errno){
    echo "Database query failed: " . $db->connect_error . "<BR>";
}

//close db conection
$db->close();

// read data from database, check if user exsists

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $useremail = $row["email"];
        $userbalance = $row["balance"];
        $username = $row["username"];
        $hashed_password = $row['password'];
    }
}else{
    $state = 'imposter';
}

date_default_timezone_set('UTC');

//echo "DEBUG ** state is -- ".$state."<BR>";
//echo "DEBUG ** user is -- ".$username."<BR>";
//echo "DEBUG ** pswrd is -- ".$hashed_password."<BR>";


// state engine entry
switch ($state) {
    case 'login':
        if ($mypassword == password_verify($mypassword, $hashed_password)){
            echo "<CENTER><h2> Hey ".$myusername." welcome back.<BR>";
            echo "Place your 3 rider bids </H2>";
            echo "<p> The date is.. ".$racetime."<BR>
                You have ". $userbalance . " points in your account <BR><BR>";            
            include 'enter-bids.php';
            include 'password-select.php';
        } else {
            echo "<CENTER><h2> Hey ".$myusername." you got your password wrong.<BR>";
            echo "Best put the beer down and have another go? </H2>";
            readfile('login-table.html');
            
        }
        //echo "DEBUG ** made it int to the pasword checking loop<BR>";
        break;
     
    case 'admin':
    	if ($mypassword == password_verify($mypassword, $hashed_password)){
       		include 'admin.php'; 
       	} else {
            echo "<CENTER><h2> Hey ".$myusername." you got your admin password wrong.<BR></H2> ";
            readfile('login-table.html');          
        }      
        break;
    
    case 'bids':
        include 'process-bids.php';
        break;
    case 'imposter':
        echo "<H1> Who the hell are you?<BR>Get the fuck off our lawn!!</H1>";
        break;

    case 'race':
        include 'rider-bids.txt';
        break;

// switch statment brace
}


// if($result line) brace
//}
echo "<P><BR><BR><center><a href='http://moto.partymeeple.com.au'>Click here to go back or to log out</a><center>";

//echo "<br><br>Current PHP version: " . phpversion();

//veriable testing/debuggin area.
//echo "TESTING<BR>My name is  ". $myusername." --- ".$username."<BR>";
//echo " My xxx is  ". $mypassword." --- ".$password;

?>
