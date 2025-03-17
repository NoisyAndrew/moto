<!doctype html>
<html lang="en">

<head>
    <title>MotoGP bidding 2025</title>
    <link rel='shortcut icon' type='image/x-icon' href='cog.ico'></link>
    <link rel="stylesheet" href="main.css" type="text/css" media="screen"></link>
    <meta http-equiv='pragma' content='no-cache' />
    <meta http-equiv='expires' content='-1' />
    <meta http-equiv='cache-control' content='no-cache'>
</head>

<body>
    <center>
        <h2>Welcome MotoGP bidding 2025</h2>
        <center><img src="/images/dannyped.png" alt="Zoooomm.."></center>
        <br>

        <?php
        // check it's not a race day.
        $bidsok = 0;
        $pastrace = 0;
        $roundnumber = 1;
        date_default_timezone_set('UTC');
        $raceday = file('dates.txt');
        $today = time();
        // $today=time()-10800;

        foreach ($raceday as $race) {
            $race = strtotime($race);
            //    $race = $race + 18000;
            if ($today < ($race + 79200) && $today > $race) {
                echo "<h2>Bids are closed.</H2><p>It's Race week of Round " . $roundnumber . ". <br>So cool your heals untill the next round.<p> See below for who got what rider.";

                $bidsok = 1;
                //echo $race. " -- ".$qualifying;
                include 'rider-bids.txt';
                $hours = round(($today - ($race + 86400)) / 60 / 60);
                echo "<p>Next race is <h3>" . date('d-F-Y', strtotime($raceday[$roundnumber])) . "</H3><p>and biding will be open again in" . $hours . " hours time.<br>Then closing 12am UTC the day of this race.";
                //include 'comment-box-only.php';
            }

            if ($today < $race && $pastrace == 0) {
                $thisrace = $race;
                $pastrace = 1;
                //echo " if#2, ";
            }
            ++$roundnumber;
        }

        // it's not race/cutoff day code
        if ($bidsok == 0) {

            // do count down to cut off
            $diff = $thisrace - $today;
            $next_day = intval($diff / 86400);
            $next_hour = intval(($diff - ($next_day * 86400)) / 3600);
            $next_minute = intval(($diff - ($next_day * 86400) - ($next_hour * 3600)) / 60);
            echo "<h3>The next bid cut off is " . $next_day . " days " . $next_hour . " hours " . $next_minute . " minutes</h3><br>";

            // do page diplay   
            echo "<div class='messagebox'>";
            readfile('message.txt');
            echo "</div><br><br>";
            include 'balance-table.php';
            echo "<br>";
            include 'comment-box-only.php';
            echo "<br><br>";
            readfile('login-table.html');


            echo "<br><div class='messagebox'>";
            echo "<h4>Payouts </h4> <p> Incase you have forgotten or never really knew?  The payouts run <br>30, 24, 19, 15, 12, 10, 9, 8.";
            echo "<p>Starting at first and running to eigth. ";
            echo "So bidding zero for a    shaggy rider who finishes seventh or eighth is pretty cool";
            echo "<center><a href='http://moto.partymeeple.com.au/last-bids.php'>Click here to view the last round's bids</a></center><br>";
            echo "</div><br><br>";
        }

        ?>

        <center>
            <p>~~coded with bad form and boxing fleas~~</p>
        </center>
</body>

</html>