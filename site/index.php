<!DOCTYPE html>
<html lang="en-US">
<HTML>
<HEAD>
<TITLE>MotoGP bidding 2025</TITLE>
<link rel='shortcut icon' type='image/x-icon' href='cog.ico'></link>
<LINK REL="STYLESHEET" HREF="/css/main.css" TYPE="text/css" MEDIA="screen"></LINK>
<meta http-equiv='pragma' content='no-cache' />  
<meta http-equiv='expires' content='-1' />
<meta http-equiv='CACHE-CONTROL' content='NO-CACHE'>
</HEAD>

<BODY>
<center>
<h2>Welcome MotoGP bidding 2025</H2>
<center><IMG SRC="/images/DannyPed.png" ALT="Zoooomm.."></center>
<BR>


<?php
// check it's not a race day.
$bidsok=0;
$pastrace = 0;
$roundnumber = 1;
date_default_timezone_set('UTC');
$raceday= file('dates.txt');
$today=time();
// $today=time()-10800;

foreach ($raceday as $race){
    $race=strtotime($race);
//    $race = $race + 18000;
    if($today < ($race + 79200) && $today > $race){
    echo "<H2>Bids are closed.</H2><p>It's Race week of Round ".$roundnumber. ". <br>So cool your heals untill the next round.<p> See below for who got what rider.";

    $bidsok = 1;
    //echo $race. " -- ".$qualifying;
    include 'rider-bids.txt';
    $hours = round(($today - ($race+86400))/60/60);
    echo "<p>Next race is <H3>".date('d-F-Y', strtotime($raceday[$roundnumber]))."</H3><p>and biding will be open again in". $hours ." hours time.<br>Then closing 12am UTC the day of this race.";
    //include 'comment-box-only.php';
    }

    if($today < $race && $pastrace == 0){    
    $thisrace = $race;
    $pastrace = 1;
    //echo " if#2, ";
    }
    ++$roundnumber;
}

// it's not race/cutoff day code
if($bidsok == 0){
    
// do count down to cut off
    $diff = $thisrace - $today;
    $next_day = intval($diff / 86400);
    $next_hour = intval(($diff - ($next_day * 86400))/3600);
    $next_minute = intval(($diff - ($next_day * 86400) - ($next_hour * 3600))/60);
    echo "<H3>The next bid cut off is ". $next_day ." days ". $next_hour." hours ". $next_minute." minutes</H3><BR>";
    
 // do page diplay   
    echo "<div class='messagebox'>";
    include 'message.txt';
    echo "</div><BR><BR>";
    include 'balance-table.php';
    echo "<BR>";    

    include 'comment-box-only.php';
    echo "<BR><BR>";
    include 'login-table.php';

   
    echo "<BR><div class='messagebox'>";
    echo "<h4>Payouts </h4> <P> Incase you have forgotten or never really knew?  The payouts run <br>30, 24, 19, 15, 12, 10, 9, 8.";
    echo "<p>Starting at first and running to eigth. ";
    echo "So bidding zero for a    shaggy rider who finishes seventh or eighth is pretty cool";
    echo "<center><a href='http://moto.partymeeple.com.au/last-bids.php'>Click here to view the last round's bids</a></center><BR>";
    echo "</div><BR><BR>";
    
    
}

?>

<center><P>~~coded with bad form and boxing fleas~~</center>
</BODY>
</HTML>
