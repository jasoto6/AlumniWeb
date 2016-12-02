<?php //index.php
  require_once 'header.php';

  echo "<br><div id='welcome' class='main'>Welcome to $appname,";

  if ($loggedin) echo " $user, you are logged in.";
  else           echo ' please sign up and/or log in to join in.';
?>

    </div><br><br>
  </body>
</html>
