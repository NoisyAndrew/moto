<?php

// members DB variables
$host="localhost"; // Host name 
$user="partymee"; // Mysql username 
$password="Spacey7303"; // Mysql password 
$db_name="partymee_moto"; // Database name 

// **Create connection**
$db = new mysqli($host, $user, $password, $db_name);
// Always check for errors
if($db->connect_errno){
    echo "Members Connection failed: " . $db->connect_error . "<BR>";
    }

$sql = "SELECT username, balance FROM members ORDER BY balance DESC";
$result = $db->query($sql);
// Always check for errors
if($db->connect_errno){
    echo "DB Connection failed: " . $db->connect_error . "<BR>";
}


echo "<center><table><tr><th colspan=2>Points Balances</th></tr>";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if ($row["username"] != "admin"){
            echo "<tr><td>" . $row["username"]. "</td><td>" . $row["balance"]. "</td></tr>";
        }
    }
}

echo "</table></center>";

?>
