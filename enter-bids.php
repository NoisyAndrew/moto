<?php
// makes the table for the rider selection.
// reads the list of riders from a text file and them arranges them in a form

$names=file('rider-list.txt');

echo "<H3> Enter Your Bids</H3>
    <CENTER><TABLE>
    <FORM method='post' action='main.php'>
    <TR><TD>Bid 1 </TD><TD> Amount</TD></TR>
    <TR><TD> <select name='rider-1' size='5'>";
    foreach ($names as $name){
    echo "<option value='$name'>$name</option>";
    }
  echo "</select>
    </TD><TD>
   <input name='amount-1' type='number' value= '0' style='width: 50px' min='0'>
    </TD></TR>

    <TR><TD>Bid 2 </TD><TD> Amount </TD></TR>
    <TR><TD><select name='rider-2' size='5'>";
    foreach ($names as $name){
    echo "<option value='$name'>$name</option>";
    }
  echo "</select>
    </TD><TD>
   <input name='amount-2' type='number' value= '0' style='width: 50px' min='0'>
    </TD></TR>

    <TR><TD>Bid 3 </TD><TD> Amount </TD></TR>
    <TR><TD><select name='rider-3' size='5'>";
    foreach ($names as $name){
    echo "<option value='$name'>$name</option>";
    }
  
    echo "</select>
    </TD><TD>
    <input name='amount-3' type='number' value= '0' style='width: 50px' min='0'>
    </TD></TR>
    <input name='state' type='hidden' value= 'bids'>
    <input name='myusername' type='hidden' value= '$myusername'>
    <input name='mypassword' type='hidden' value= '$mypassword'>        
    <input name='email' type='hidden' value= '$useremail'>
    <input name='balance' type='hidden' value= '$userbalance'>
   
    <TR><TD><input type='submit' value='Submit your bids'></TD></TR>
    </FORM></TABLE></CENTER>";

?>
