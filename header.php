<?php //header.php

  ini_set("session.cookie_lifetime","604800"); //an hour
  ini_set("session.cookie_httponly", 1);
  ini_set("session.use_only_cookies", 1);
  //ini_set("session.save_path", "sessions");

  session_name('UTEPAlumni');
  session_start();

  echo "<!DOCTYPE html>\n<html><head>";

  require_once 'functions.php';

  $userstr = ' (Guest)';

  if (isset($_SESSION['Username']))
  {
    $user     = $_SESSION['Username'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;

  echo "<title>$appname$userstr</title><link rel='stylesheet' " .
       "href='styles.css' type='text/css'>"                     .
       "</head><body> "  .
       "<img src='UTEPAlumniBanner.jpg'> " .
       "<div class='appname'>$appname$userstr</div>";

  if ($loggedin)
  {
    echo "<ul class='menu'>" .
         "<li><a href='members.php?view=$user'>Home</a></li>" .
         "<li><a href='studentList.php'>Alumni</a></li>"         .
         "<li><a href='messages.php'>Bulletins</a></li>"       .
         "<li><a href='profile.php'>Edit Profile</a></li>"    .
         "<li><a href='logout.php'>Log out</a></li></ul>";
  }
  else
  {
    echo ("<ul class='menu'>" .
          "<li><a href='index.php'>Home</a></li>"                .
          "<li><a href='studentList.php'>Alumni</a></li>"         .
          "<li><a href='registration.php'>Sign up</a></li>"            .
          "<li><a href='login.php'>Log in</a></li></ul>");
  }
?>
