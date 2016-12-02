<?php
require_once 'header.php';
require_once 'functions.php';

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

// $search = "";

  echo "<div id=data overflow-x:auto><table id='table' border='1'>
  <tr>
  <th>First Name</th>
  <th>Last Name</th>
  </tr>";

  $result = $conn->query("SELECT * FROM members");
  while ($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>" . $row['user'] . "</td>";
    echo "</tr>";
  }
  echo "</table></div>";


//
//   if ($search == "")
//   {
//     $result = query("SELECT * FROM members");
//   }
//   else
//   {
//     $result = query("SELECT * FROM members WHERE user='$user'");
//   }
//   $num_rows=$result->num_rows;
// }

 ?>
<!doctype html>
<html>
<head>
</head>
  <body>
    <!-- <form action= 'studentList.php' method='post'>
      <button type='button' name='searchButton'>Display Students</button>
    </form> -->
    <div id='filters'>
      <h2>Filter options:</h2>
      <input type="checkbox" id="year" name="year">
      <label for="year">by Year</label>
      <input type="checkbox" id="major" name="major">
      <label for="major">by Major</label>
      <input type="checkbox" id="degree" name="degree">
      <label for="degree">by Degree</label>
    </div>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
    function getEmployeeFilterOptions(){
      var opts = [];
      $checkboxes.each(function(){
        if(this.checked){
          opts.push(this.name);
        }
      });
      return opts;
    }
    </script>
    <script>
    $(document).ready(function(){
        $('#table').after('<div id="nav"></div>');
        var rowsShown = 2;
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
    </script>
  </body>
</html>
