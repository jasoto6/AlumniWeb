<?php //members.php
  require_once 'header.php';


  echo "<br> <div class='main'>";

  if (isset($_GET['view']))
  {
    $view = sanitizeString($_GET['view']);

    $result = queryMysql("SELECT * FROM MYPROFILE WHERE Username='$view'");

    $row = $result->fetch_assoc();

    if (!$row['LastName'])

    {
      echo "<div class='profile'>The alumni hasn't registered yet.</div>";
      exit();
    }



    echo "<h3>" . $row['LastName']. "'s Profile</h3>";

    echo "<div class='profile'> First name: \t" . $row['FirstName'] . "</div><br>";
    echo "<div class='profile'>Last name: \t" . $row['LastName'] . "</div><br>";
    echo "<div class='profile'>Academic Year: \t" . $row['AcademicYear'] . "</div><br>";
    echo "<div class='profile'>Term: \t" . $row['Term'] . "</div><br>";
    echo "<div class='profile'>Major: \t" . $row['Major'] . "</div><br>";
    echo "<div class='profile'>Level Code: \t" . $row['LevelCode'] . "</div><br>";
    echo "<div class='profile'>Degree: \t" . $row['Degree'] . "</div><br>";
    if (!$row['EmailPri']) echo "<div class='profile'>Email: \t" . $row['Email'] . "</div><br>";
    if (!$row['PhonenoPri']) echo "<div class='profile'>Phone: \t" . $row['Phoneno'] . "</div><br>";
    if (!$row['BriefBioPri']) echo "<div class='profile'>Brief Bio: \t" . $row['BriefBio'] . "</div><br>";

    die("</div></body></html>");
  }


?>
