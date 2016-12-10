<?php //login.php
  require_once 'header.php';
  echo "<div class='main'><h3>Please enter your details to log in</h3>";
  $error = $user = $pass = "";

  if ($loggedin){
    header('Location: index.php');
    exit();
  }

  if (isset($_POST['Username']))
  {
    $user = sanitizeString($_POST['Username']);
    $pass = sanitizeString($_POST['password']);

    if ($user == "" || $pass == "")
        $error = "Not all fields were entered<br>";
    else
    {
    /*
      $result = queryMySQL("SELECT user,pass FROM members
        WHERE user='$user' AND pass='$pass'");
    */

      $result = queryMySQL("SELECT user FROM members
        WHERE user='$user'");

      if ($result->num_rows == 0)
      {
        $error = "<span class='error'>Username/Firstname
                  invalid</span><br><br>";
      }
      else
      {
        $_SESSION['Username'] = $user;
        $_SESSION['password'] = $pass;
         die("You are now logged in. Please <a id='loginout' href='studentList.php'>" .
            "click here</a> to continue.<br><br>");
        /*
        die("You are now logged in. Please <a href='members.php?view=$user'>" .
            "click here</a> to continue.<br><br>");*/
      }
    }
  }

  echo <<<_END
    <form method='post' action='login.php'>$error
    <span class='fieldname'>Username</span><input type='text'
      maxlength='16' name='Username' value='$user'><br>
    <span class='fieldname'>Password</span><input type='password'
      maxlength='16' name='password' value='$pass'>
_END;

function validate_username($field)
{
  if ($field == "") return "No Username was entered.<br>";
  else if (strlen($field) < 5) return "Username must be 5 characters.<br>";
  else if (preg_match("/[^a-zA-Z0-9_-]/",$field)) return "Only a-z, A-Z, 0-9, - and _ allowed in Username.<br>";
  return "";
}

function validate_password($field)
{
  if ($field == "") return "No Password was entered.<br>";
  else if (strlen($field)<8) return "Password must be at least 8 characters.<br>";
  else if (!preg_match("/[^a-z]/", $field) || !preg_match("/[A-Z]/", $field) || !preg_match("/[0-9]/", $field))
    return "Password requires one each of a-z, A-Z and 0-9.<br>";
  return "";
}

function fix_string($string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return htmlentities ($string);
  }

$fail = validate_username($user);
$fail .= validate_password($pass);

if ($fail == "")
{
    echo "Form data successfully validated: $user,$pass";

    exit;
}
?>
<!--- JavaScript Validation --->
<script>

function validate(form)
{
  fail = validateUsername(form.username.value)
  fail += validatePassword(form.password.value)

  if (fail == "") return true
  else {alert(fail); return false}
}

function validateUsername(field)
{
  if (field == "") return "No Username was entered.\n"
  else if (field.length < 5) return "Username must be 5 characters.\n"
  else if (/[^a-zA-Z0-9_-]/.test(field)) return "Only a-z, A-Z, 0-9, - and _ allowed in Username.\n"
  return ""
}

function validatePassword(field)
{
  if (field == "") return "No Password was entered.\n"
  else if (field.length<8) return "Password must be at least 8 characters.\n"
  else if (/![a-z]/.test(field) || /![A-Z]/.test(field) || /![0-9]/.test(field))
    return "Password requires one each of a-z, A-Z and 0-9.\n"
  return ""
}

 </script>

    <br>
    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Login' onSubmit="return validate(this)">
    </form><br></div>
  </body>
</html>
