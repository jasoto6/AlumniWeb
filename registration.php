<?php
require_once 'header.php';
require_once 'database.php';

$error = "";
$fail = "";
$message = "Welcome to UTEP Alumni website, you need to register for full access:";
$salt1 = "$)*)IH(!00ou291)";

if (isset($_SESSION['loggedin'])) {
  header('Location: studentList.php');
  exit();
}

//$username = $password = $firstName = $lastName = $year = $studentId = $email = $major = "";
$username = $password = $year = $studentId = $email = $major = "";
if (isset($_POST['username'])) $username =fix_string($_POST['username']);
if (isset($_POST['password'])) $password =fix_string($_POST['password']);
if (isset($_POST['firstName'])) $firstName =fix_string($_POST['firstName']);
if (isset($_POST['lastName'])) $lastName =fix_string($_POST['lastName']);
if (isset($_POST['year'])) $year =fix_string($_POST['year']);
if (isset($_POST['term'])) $term =fix_string($_POST['term']);
if (isset($_POST['levelcode'])) $levelcode =fix_string($_POST['levelcode']);
if (isset($_POST['studentId'])) $studentId =fix_string($_POST['studentId']);
if (isset($_POST['email'])) $email =fix_string($_POST['email']);
if (isset($_POST['major'])) $major =fix_string($_POST['major']);
if (isset($_POST['degree'])) $degree =fix_string($_POST['degree']);
if (isset($_POST['phoneno'])) $phoneno =fix_string($_POST['phoneno']);
if (isset($_POST['briefbio'])) $briefbio =fix_string($_POST['briefbio']);


if (isset($_POST['username']) || isset($_POST['password'])){
  $fail = validate_username($username);
  $fail .= validate_password($password);
//  $fail .= validate_firstname($firstName);
//  $fail .= validate_lastname($lastName);
//  $fail .= validate_year($year);
//  $fail .= validate_studentid($studentId);
//  $fail .= validate_email($email);
//  $fail .= validate_major($major);
  $error = $fail;
}

if ($fail == ""){
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = hash('sha256', $salt1.$_POST['password'].$username);

    $dbconn = new mysqli($hn, $un, $pw, $db);
    //$dbconn = new mysqli("localhost", "root", "", "ms_login");
    if ($dbconn -> connect_error) {
      die("Oops! Something is wrong. Please try again later.");
      exit();
    }
    $query = "SELECT 1 FROM MYPROFILE WHERE Username='$username'";
    $result = mysqli_query($dbconn,$query);
    if (!$result) die($dbconn -> error);
    $rowcount= mysqli_num_rows($result);

    if ($rowcount == 1){
      $error = "Username already in use";
      //$error = $firstName;
    } else {
      $validation_query = "SELECT 1 FROM ALUMNI WHERE FirstName='$firstName' and LastName='$lastName' and Major='$major' and id='$studentId'";
      $result = mysqli_query($dbconn,$validation_query);
      if (!$result) die($dbconn -> error);
      $rowcount= mysqli_num_rows($result);

      if ($rowcount == 1) {
        $message="Alumni found.<br>";
        $error = "Alumni not found.<br>";
          /*
        $query1 = "INSERT INTO MYPROFILE (Username, FirstName, LastName,Major,Email,GraduationYear,Degree,Phoneno,BriefBio) VALUES ('$username', '$firstName', '$lastName','$major','$email','$year','$degree','$phoneno',$briefbio); ";
        */

        /*
        $query1 = "INSERT INTO MYPROFILE (Username, FirstName, LastName,Email,Major,Degree,GraduationYear,Phoneno,BriefBio) VALUES ('$username', '$firstName', '$lastName','$email',$major','$degree','$year','$phoneno',$briefbio)";
        */



        $query1 = "INSERT INTO MYPROFILE (Username,Password,FirstName,LastName,Email,Major,Degree,GraduationYear,Phoneno,Briefbio, Term, LevelCode) VALUES ('".$username."','".$password."','".$firstName."','".$lastName."','".$email."','".$major."','".$degree."','".$year."','".$phoneno."','".$briefbio."', '".$term."', '".$levelcode."')";

        $query2 = "UPDATE ALUMNI SET Username='$username' WHERE id='$studentId'";

        $query3 = "INSERT INTO members (user,pass) VALUES ('".$username."','".$password."')";


        $result1 = mysqli_query($dbconn,$query1);
        $result2 = mysqli_query($dbconn,$query2);
        $result3 = mysqli_query($dbconn,$query3);

        if($result1 || $result2 || $result3){
                 $message = 'User Created Successfully. You can now <a href="login.php">Log In</a> with your credentials.';
               } else {
                 die($dbconn -> error);
                 exit();
                 $error = "Oops! Something is wrong. Please try again later.";
               }
      }
/*
      $query = "INSERT INTO USER (USERNAME, PASSWORD) VALUES ('$username', '$password')";
      $result = mysqli_query($dbconn,$query);
      if($result){
               $message = 'User Created Successfully. You can now <a href="login.php">Log In</a> with your credentials.';
             } else {
               die($dbconn -> error);
               exit();
               //$error = "Oops! Something is wrong. Please try again later.";
             }
             */
    }
  }
}



if (!isset($_SESSION['count'])) $_SESSION['count'] = 0;
else ++$_SESSION['count'];

//echo "<br>",$_SESSION['count'];

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

function validate_firstname($field)
{
  if ($field == "") return "No Password was entered.<br>";
  else if (strlen($field)<8) return "Password must be at least 8 characters.<br>";
  else if (!preg_match("/[^a-zA-Z]/", $field))
    return "Password requires one each of a-z, A-Z and 0-9.<br>";
  return "";
}

function validate_lastname($field)
{
  if ($field == "") return "No Password was entered.<br>";
  else if (strlen($field)<8) return "Password must be at least 8 characters.<br>";
  else if (!preg_match("/[a-zA-Z]/", $field))
    return "Password requires one each of a-z, A-Z and 0-9.<br>";
  return "";
}

function validate_studentid($field)
{
  if ($field == "") return "No Password was entered.<br>";
  else if (strlen($field)<8) return "Password must be at least 8 characters.<br>";
  else if (!preg_match("/[0-9]/", $field))
    return "Password requires one each of a-z, A-Z and 0-9.<br>";
  return "";
}

function validate_email($field)
{
  if ($field == "") return "No Password was entered.<br>";
  else if (strlen($field)<8) return "Password must be at least 8 characters.<br>";
  else if (!preg_match("/[a-z]/", $field) || !preg_match("/[A-Z]/", $field) || !preg_match("/[0-9]/", $field))
    return "Password requires one each of a-z, A-Z and 0-9.<br>";
  return "";
}

function validate_major($field)
{
  if ($field == "") return "No Password was entered.<br>";
  else if (strlen($field)<8) return "Password must be at least 8 characters.<br>";
  else if (!preg_match("/[A-Za-z]/", $field))
    return "Password requires one each of a-z, A-Z and 0-9.<br>";
  return "";
}

function fix_string($string)
{
  if (get_magic_quotes_gpc()) $string = stripcslashes($string);
  return htmlentities ($string);
}

?>


<!DOCTYPE html>
<html>
<head><title>Registration Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

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
</head>
<body>
<br>
<h1>Registration Page</h1>
<form action="registration.php" method="post" onsubmit="return validate(this)">
<br>
<p><?php if ($error == "") {echo $message;} else {echo $error;} ?></p>
<br>
<p><span class='fieldname'>Username: </span><input type="text" name="username"><br>
<span class='fieldname'>Password: </span><input type="password" name="password"><br>
<span class='fieldname'>First Name: </span><input type="text" name="firstName"><br>
<span class='fieldname'>Last Name: </span><input type="text" name="lastName"><br>
<span class='fieldname'>Academic Year: </span><input type="text" name="year"><br>
<span class='fieldname'>Term: </span><input type="text" name="term"><br>
<span class='fieldname'>Level Code: </span><input type="text" name="levelcode"><br>
<span class='fieldname'>Student ID: </span><input type="text" name="studentId"><br>
<span class='fieldname'>Email: </span><input type="text" name="email"><br>
<span class='fieldname'>Major: </span><input type="text" name="major"><br>
<span class='fieldname'>Degree: </span><input type="text" name="degree"><br>
<span class='fieldname'>Phone: </span><input type="text" name="phoneno"><br>
<span class='fieldname'>Brief Bio: </span><input type="text" name="briefbio"><br></p>
<p><input type="submit" value="Register" /></p>
<br>
</body>
</html>
