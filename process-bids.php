<?php
include .env.php;

// POST variables
//$username = $_POST["member"];
//$useremail = $_POST["email"];
$userbalance = $_POST["balance"];
$rider_1 = str_replace(' ','_',$_POST["rider-1"]);
$amount_1 = $_POST["amount-1"];
$rider_2 = str_replace(' ','_',$_POST["rider-2"]);
$amount_2 = $_POST["amount-2"];
$rider_3 = str_replace(' ','_',$_POST["rider-3"]);
$amount_3 = $_POST["amount-3"];

$rider_names=file('rider-list.txt');
$rider_names = str_replace(' ', '_', $rider_names);

echo " made it here"; 

// Create connection
$db = new mysqli($host, $user, $password, $db_name);
// Always check for errors
if($db->connect_errno){
    echo "Connection failed: " . $db->connect_error . "<BR>";
    }

// check that date is ok..
$roundnumber=0;
$bidsok=0;
$raceday= file('dates.txt');
$today=strtotime('today');
foreach ($raceday as $race){
    ++$roundnumber;
    $race=strtotime($race);
    if($today > $race) $this_round = $roundnumber+1;
    if($race == $today){
    echo "<center><IMG SRC='/images/DannyPed.jpg' ALT='Zoooomm..'></center>";
    echo "<H2>Bids are closed.</H2><p>It's Race week end (UTC time) <br>so cool your heals untill the next round.";
    echo "<p>Next race is <H4>".date('d-F-Y', strtotime($raceday[$this_round]))."</H4><p>and biding will be open Monday.<p>Closing 12am the day before the next race.";
    include 'rider-bids.txt';
    echo "<center><a href='http://motogo.partymeeple.com.au/index.php'>Click here to head back to the login screen</a></center>";
    $bidsok = 1;
    }
}

// if bids are OK save the bids and report back
if($bidsok == 0){
    // calculate new balance and see if they can aford it.
    $newuserbalance = $userbalance - $amount_1 - $amount_2 - $amount_3;
    if ($newuserbalance>'-1'){
    // Execute SQL queries.
    //reset any previous bids first.
    //then enter new bids
    $sql = "UPDATE bids SET rider1=null, bid1=null, rider2=null, bid2=null, rider3=null, bid3=null WHERE username='$username'";
    echo "not enough points for those bids";
    
    if ($db->query($sql) != TRUE) {
            echo "Error re-seting record in poor flee code: <BR>" . $db->error;
    } else {
            $sql = "UPDATE bids SET rider1='$rider_1', bid1='$amount_1', rider2='$rider_2', bid2='$amount_2', rider3='$rider_3', bid3='$amount_3' WHERE username='$username'";
                if ($db->query($sql) == TRUE) {
                echo "<H2>Hi ". $username. " your saved bids are</H2>";
                } else {
                echo "<H2> Damn there was an error updating the bid record<BR> Please logout and try again.. </H2> " . $db->error;
                $sqlbiderror = 1;
                }
    }
    //close db conection
    $db->close();
    
    //post bids to html
        echo "<CENTER><TABLE>
            <TR><TD>".str_replace("_"," ",$rider_1)."</TD><TD>".$amount_1."</TD></TR>
            <TR><TD>".str_replace("_"," ",$rider_2)."</TD><TD>".$amount_2."</TD></TR>
            <TR><TD>".str_replace("_"," ",$rider_3)."</TD><TD>".$amount_3."</TD></TR>
            </TABLE>
            <P>You can come back and revise these if you have a sudden confidence sag.<BR>";
    //email the user
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
        if ($sqlbiderror ==1){
            $msg = "The damn SQL bummed out saving your bids<H2>Plese login later and try again</H2>";
            $msg2 = "The SQL bummed out while ".$useremail." was trying to ender their bids<br> sorry to ruin your day";
            mail("spare@partymeeple.com.au","MotoGO bid SQL error",$msg2,$headers);
        }else{
        $msg = "Hi ".$username.",<BR> Your MotoGo bids for round ".$this_round. " are <BR>".$rider1." you bid ".$amount1." pts <BR>" .$rider2." you bid ".$amount2. " pts <BR>".$rider3." you bid ".$amount3. " pts<BR> Good Luck. <BR><BR> Do not reply to this mailbox. It is not checked.";
        }
        mail($useremail,"MotoGo bids for round ".$this_round,$msg,$headers);
        echo "<H4>Good luck.. An email has been sent to <BR>". $useremail . " </H4></CENTER>";
    } else {
        echo "<center>Umm, you don't actually have that many REVS/points<BR>YOU actually have ".$userbalance." REVS/points.<BR>
           Best try again eh?<BR>";
        include 'enter-bids.php';
        echo "</center>";
    }
}
?>
