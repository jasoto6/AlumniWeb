<?php //profile.php
  require_once 'header.php';

  if (!$loggedin) die();

  if (isset($_POST['privacy']) && isset($_SESSION['user']))
  {
    $GraduationYearPri = $_POST['GraduationYearPri'];
    queryMysql("UPDATE profiles SET GraduationYearPri=$GraduationYearPri where user='$user'");
  }

  echo "<div class='main'><h3>Your Profile</h3>";

  $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result->num_rows)
         queryMysql("UPDATE profiles SET text='$text' where user='$user'");
    else queryMysql("INSERT INTO profiles VALUES('$user', '$text')");
  }
  else
  {
    //if ($result->num_rows)
    //{
    $rows = $result -> num_rows;
    for ($j=0; $j <$rows; ++$j)
    {
      //$result -> data_seek($j);
      $row = $result->fetch_array(MYSQLI_NUM);
    }

      //$text = stripslashes($rows['text']);
      echo <<<_END
      <form method='post' action='profile.php'>
_END;
      echo $row[0]."<br>";
      echo $row[1]."<br>";
      echo $row[2]."<br>";
      echo $row[3]."<br>";
      echo $row[4]."<br>";
      echo $row[5]."<br>";
      echo $row[6]."<br>";
      echo $row[7];
      echo <<<_END
      Public<input type='radio' name='LastName' value='0' checked='checked'>
      Private<input type='radio' name='LastName' value='1' >
      <br>
      <br>
_END;
      if ($row[11]) {
        echo $row[8];
        echo <<<_END
        Public<input type='radio' name='GraduationYearPri' value='0'>
        Private<input type='radio' name='GraduationYearPri' value='1' checked='checked'>
        <br>
_END;
      } else {
        echo $row[8];
        echo <<<_END
        Public<input type='radio' name='GraduationYearPri' value='0' checked='checked'>
        Private<input type='radio' name='GraduationYearPri' value='1' >
        <br>
_END;
      }

      echo $row[9]."<br>";
      echo $row[10]."<br>";
      echo <<<_END
      <input type='hidden' name='privacy' value='1'>
      <input type='submit' value='Save'></form><br>
      </div><br>
    </body>
  </html>
_END;

      //$row  = $result->fetch_array(MYSQLI_ASSOC);
      //$text = stripslashes($row['text']);
    //}
    //else $text = "";
  }

  //$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));



/*
  if (isset($_FILES['image']['name']))
  {
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }

  //showProfile($user);

  echo <<<_END
    <form method='post' action='profile.php' enctype='multipart/form-data'>
    <h3>Enter or edit your details and/or upload an image</h3>
    <textarea name='text' cols='50' rows='3'>$text</textarea><br>
_END;
?>

    Image: <input type='file' name='image' size='14'>
    <input type='submit' value='Save Profile'>
    </form></div><br>

  </body>


</html>
*/
