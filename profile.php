<?php //profile.php
  require_once 'header.php';

  if (!$loggedin) die();

  $BriefBioPri = $EmailPri = $PhonenoPri = "";
  if (isset($_POST['BriefBioPri'])) $BriefBioPri =fix_string($_POST['BriefBioPri']);
  if (isset($_POST['EmailPri'])) $EmailPri =fix_string($_POST['EmailPri']);
  if (isset($_POST['PhonenoPri'])) $PhonenoPri =fix_string($_POST['PhonenoPri']);

  //echo $BriefBioPri, $EmailPri, $PhonenoPri;

  if (isset($_POST['privacy']) && isset($_SESSION['Username']))
  {
    $EmailPri = $_POST['EmailPri'];
    queryMysql("UPDATE MYPROFILE SET EmailPri=$EmailPri, PhonenoPri=$PhonenoPri, BriefBioPri=$BriefBioPri where Username='$user'");
  }

  echo "<div class='main'><h3>Your Profile</h3>";

  $result = queryMysql("SELECT * FROM MYPROFILE WHERE Username='$user'");

/*  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result->num_rows)
         queryMysql("UPDATE MYPROFILE SET text='$text' where Username='$user'");
    else queryMysql("INSERT INTO MYPROFILE VALUES('$user', '$text')");
  }
  else
  {
*/
  $row = $result->fetch_assoc();
  echo <<<_END
  <form method='post' action='profile.php'>
_END;
  echo "<div class='profile'> First name: \t" . $row['FirstName'] . "</div><br>";
  echo "<div class='profile'>Last name: \t" . $row['LastName'] . "</div><br>";
  echo "<div class='profile'>Academic Year: \t" . $row['AcademicYear'] . "</div><br>";
  echo "<div class='profile'>Term: \t" . $row['Term'] . "</div><br>";
  echo "<div class='profile'>Major: \t" . $row['Major'] . "</div><br>";
  echo "<div class='profile'>Level Code: \t" . $row['LevelCode'] . "</div><br>";
  echo "<div class='profile'>Degree: \t" . $row['Degree'] . "</div><br>";
  echo "<div class='profile'>Email: \t" . $row['Email'] . "<br>";
  if ($row['EmailPri']){
    echo <<<_END
    Public<input type='radio' name='EmailPri' value='0' >
    Private<input type='radio' name='EmailPri' value='1' checked='checked'>
    </div>
    <br>
_END;
  } else {
    echo <<<_END
    Public<input type='radio' name='EmailPri' value='0' checked='checked'>
    Private<input type='radio' name='EmailPri' value='1' >
    </div>
    <br>
_END;
}
  echo "<div class='profile'>Phone: \t" . $row['Phoneno'] . "<br>";
  if ($row['PhonenoPri']){
    echo <<<_END
    Public<input type='radio' name='PhonenoPri' value='0' >
    Private<input type='radio' name='PhonenoPri' value='1' checked='checked'>
    </div>
    <br>
_END;
  } else {
    echo <<<_END
    Public<input type='radio' name='PhonenoPri' value='0' checked='checked'>
    Private<input type='radio' name='PhonenoPri' value='1' >
    </div>
    <br>
_END;
}
  echo "<div class='profile'>Brief Bio: \t". $row['BriefBio'] . "<br>";
  if ($row['BriefBioPri']){
    echo <<<_END
    Public<input type='radio' name='BriefBioPri' value='0' >
    Private<input type='radio' name='BriefBioPri' value='1' checked='checked'>
    </div>
    <br>
_END;
  } else {
    echo <<<_END
    Public<input type='radio' name='BriefBioPri' value='0' checked='checked'>
    Private<input type='radio' name='BriefBioPri' value='1' >
    </div>
    <br>
_END;
}

  echo <<<_END
        <input type='hidden' name='privacy' value='1'>
        <input type='submit' value='Save'></form><br>
        </div><br>
        </body>
      </html>
_END;

function fix_string($string)
{
  if (get_magic_quotes_gpc()) $string = stripcslashes($string);
  return htmlentities ($string);
}

?>
