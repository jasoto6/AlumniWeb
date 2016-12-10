<?php
require_once 'header.php';
//require_once 'functions.php';
// require_once 'database.php';
$filterLevel="";
$sortLevel="";
$message = "";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// $conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
$query ="SELECT * FROM ALUMNI ORDER BY LastName";
//$query ="SELECT * FROM cs5339team14fa16.ALUMNI ORDER BY LastName";
if(isset($_POST['students'])){
  $filterLevel = $_POST['students'];
  $sortLevel = $_POST['sort'];
  $message = $filterLevel;
  if ($filterLevel != 'all' && $sortLevel == 'lastName') $query="SELECT * FROM ALUMNI WHERE LevelCode = '$filterLevel' ORDER BY LastName";
  //if ($filterLevel != 'all') $query="SELECT * FROM cs5339team14fa16.ALUMNI WHERE LevelCode = '$filterLevel' ORDER BY LastName";
  elseif ($filterLevel != 'all' && $sortLevel == 'year') $query="SELECT * FROM ALUMNI WHERE LevelCode = '$filterLevel' ORDER BY AcademicYear";
  elseif ($filterLevel != 'all' && $sortLevel == 'all') $query="SELECT * FROM ALUMNI WHERE LevelCode = '$filterLevel'";
  else $query ="SELECT * FROM ALUMNI";
  // else $query ="SELECT * FROM ALUMNI ORDER BY LastName";
  //else $query ="SELECT * FROM cs5339team14fa16.ALUMNI ORDER BY LastName";
}
// if (isset($_POST['filter_level' == 'undergrad' && $_POST['filter_sort'] == 'alphabet']) ){
// }
// if ($POST['filter-level' == 'no_order' && $_POST['filter-level'] =='all'])
//   $query("SELECT * FROM cs5339team14fa16.ALUMNI")
// else {
//   $query("SELECT * FROM cs5339team14fa16.ALUMNI")
// }
// elseif ($POST['filter-level' == 'no_order' && $_POST['filter-level'] =='all'] {
//   $query("SELECT * FROM cs5339team14fa16.ALUMNI WHERE LevelCode = '".$filterLevel"'")
// }
$result = $conn->query($query);
// if(isset($_GET['sorting']) && !empty($_GET['sorting']))
// {
//   if ($_GET['sorting'] == 'alphabet') $result. = "ORDER BY LastName");
//   if ($_GET['sorting'] == 'degree') $result. = "ORDER BY Degree");
// }
  echo <<<_END
     <br>
     <div id="sort-filter">
     <div id='sorting'>
       <form action="studentList.php" method="post">
       Sorting Options:
       <select id="filter_sort" name="sort">
         <!-- <select id="filter_sort" name="sort" method="post" onchange="studentList.php"> -->
         <option value="all">No order</option>
         <option value="lastName">by Last Name</option>
         <option value="year">by Year</option>
       </select>
     </div>
     <div id='filters'>
       <!-- <form action="studentList.php" method="post"> -->
       Filter options:
       <select id="filter_level" name="students">
         <option value="all">All Levels</option>
         <option value="UG">Undergraduate</option>
         <option value="GR">Graduate</option>
         <option value="DR">Doctorate</option>
       </select>
     <!-- </form> -->
     <!-- <form> -->
     </div>
     <input type="submit" value="Filter" id="filterButton">
     </form>
     </div>
_END;
  echo "<div id=data overflow-x:auto><h2 id='alumniHeader'>Alumni List</h2><table id='table' border='1'>
  <tr>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Academic Year</th>
  <th>Term</th>
  <th>Major</th>
  <th>Level</th>
  <th>Degree</th>
  <th>Profile</th>
  </tr>";
  while ($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['AcademicYear'] . "</td>";
    echo "<td>" . $row['Term'] . "</td>";
    echo "<td>" . $row['Major'] . "</td>";
    echo "<td>" . $row['LevelCode'] . "</td>";
    echo "<td>" . $row['Degree'] . "</td>";
    $view = $row['Username'];
    if($row['Username']!=null) echo "<td>" . "<button type='button' class='profileButton'><a href='members.php?view=$view'>Profile</a></button>";
    else echo "<td>" . "<button type='button' class='profileButton'><a href='members.php?view=$view'>Profile</a></button>";
    echo "</tr>";
  }
  //echo "</table></div><br></body></html>";
  echo "</table></div>";
 ?>
     <!-- <script>
      $('select#filter_level').on('change', function(){
        alert('refresh');
        var filter = $('select#filter_level').val();
        $.post('studentList.php',{filter_level: filter_level}, function(data){
          $('table#table').empty();
          $('table#table').append(data);
        })
      })
    </script> -->
    <!-- <script>//
    $(document).ready(function(){
        $('#table').after('<div id="nav"></div>');
        var rowsShown = 20;
        var rowsTotal = $('#table tbody tr').length;
        var numPages = rowsTotal/rowsShown;
        for(i = 0;i < numPages;i++) {
            var pageNum = i + 1;
            $('#data').append('<a href="#" id="pageNo" rel="'+i+'">'+pageNum+'</a> ');
        }
        $('#table tbody tr').hide();
        $('#table tbody tr').slice(0, rowsShown).show();
        $('#data a:first').addClass('active');
        $('#data a').bind('click', function(){
            $('#data a').removeClass('active');
            $(this).addClass('active');
            var currPage = $(this).attr('rel');
            var startItem = currPage * rowsShown;
            var endItem = startItem + rowsShown;
            $('#table tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
                    css('display','table-row').animate({opacity:1}, 300);
        });
    });
    </script> -->
    <?php include_once 'footer.php'; ?>
