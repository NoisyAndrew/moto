<?php
echo "<HTML><HEAD><TITLE>MotoGP Admin</TITLE>
    <link rel='shortcut icon' type='image/x-icon' href='cog.ico'></link>
    <LINK REL='STYLESHEET' HREF='/css/main.css' TYPE='text/css' MEDIA='screen'></link>
    </HEAD> <h2> Welcome to the admin login</h2>";

echo "<form name='form1' method='post' action='main.php'>
 <center>User<BR>
 <input name='myusername' type='text' value='admin'><BR>
Password<BR>
<input name='mypassword' type='password' ><BR>
<input name='message_text' type='hidden' value= ''>
<input name='state' type='hidden' value= 'login'>
<input type='submit' value='Submit'>
</center>
 </form>";

echo "</html>";
?>
