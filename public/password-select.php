<?php

echo "<br><br><p>Give your self a new password? 
    <BR> This is only mates playing on motorbikes (on?) but do use something sensible. 
    <BR> As in not your user name or some such? <BR>
    <H3>Change Password</H3>
    <CENTER><table> <TR> <TD>  New Password <BR>  
    <form method='post' action='password-change.php'>
    <input type='password' name='password-1'></TD></TR>
    <TR> <TD>  New Password Again<BR>
    <input type='password' name='password-2'></TD></TR>
    <TR> <TD> 
    <input name='state' type='hidden' value= 'password'>
    <input name='member' type='hidden' value= '$myusername'>
    <input type='submit' value='Submit new password'>
    </TD></TR></FORM></TABLE></CENTER>";
?>
