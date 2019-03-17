<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

<!--since cannot use external link for style, the icon for menu will not be shown  -->

<style>
body {font-family: Arial, Helvetica, sans-serif;}
.navbar {
  width: 100%;
  background-color: #555;
  overflow: auto;
}
.navbar a {
  float: left;
  padding: 12px;
  color: white;
  text-decoration: none;
  font-size: 17px;
}
.active {
  background-color: #4CAF50;
}
.dropdown {
    float: left;
    overflow: hidden;
}
.dropdown .dropbtn {
    font-size: 16px;    
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
}
.navbar a:hover, .dropdown:hover .dropbtn {
    background-color:  #000;
}
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}
.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}
.dropdown-content a:hover {
    background-color: #ddd;
}
.dropdown:hover .dropdown-content {
    display: block;
}
@media screen and (max-width: 500px) {
  .navbar a {
    float: none;
    display: block;
  }
}
</style>
</head>

<body>
<div class="navbar">
  <a href="index.php"><i class="fas fa-home"></i> Movie Database</a> 

  <div class="dropdown">
    <button class="dropbtn"><i class="fas fa-plus"></i> Add 
      <i class="fas fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="AddAD.php">Add new actor/director</a>
      <a href="AddMovie.php">Add new movie information</a>
      <a href="AddMA.php">Add new movie/actor relation</a>
      <a href="AddMD.php">Add new movie/director relation</a>
      <a href="AddReview.php">Add new review</a>
    </div>
  </div>

  <a class="active" href="search.php"><i class="fas fa-search"></i> Search</a> 

  <div class="dropdown">
    <button class="dropbtn"><i class="fas fa-glasses"></i> Browse 
      <i class="fas fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="ActorInformation.php">Browse actor Information</a>
      <a href="MovieInformation.php">Browse movie information</a>
    </div>
  </div>
 
</div>

<form role="form" action="search.php" method="get">
  <div class="form-group">
    <label for="input">Search: </label>
    <input name="input" type="text" class="form-control" id="inputsm" placeholder="Search">
  </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>


<?php
function display_row($fields, $row, $link) {
  echo "<tr>";
  foreach ($fields as $field) {
   //echo "<td>" . $row[$field] . "</td>";  //dispaly fields for each row without link
   //echo "<td>" .'<a href='.$link.'?rowfield='.$row[$field].'>'.$row[$field].'</a>' ."</td>";  //use rowid=$row[field] gives link identifier value equal to the field value, rather than Actor.id or Movie.id
   echo "<td>" .'<a href='.$link.'?rowid='.$row[$fields[0]].'>'.$row[$field].'</a>' ."</td>"; //use rowid= $row[$fields[0]] gives same link identifier value for fields at the same row, which is the 0th index in fields array, i.e. Actor.id or Movie.id
  }
  echo "</tr>";
}

$db = new mysqli('localhost', 'cs143', '', 'CS143');
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
$Input = $_GET["input"];
$Inputs = explode(" ", $Input); //delimite inpout by space

foreach ($Inputs as $key => $n){
  if ($key < 2 and $n != ''){
    $N = "((last like '%" .$Inputs[0]. "%' AND first like '%" .$Inputs[1]. "%') OR (last like '%" .$Inputs[1]. "%' AND first like '%" .$Inputs[0]. "%')) ";
  } 
  if ($key >= 2){
    $N = "1=0 ";
  }    
}
//echo $N."<br>";
$query1 = "SELECT * FROM Actor WHERE ". $N . "ORDER BY last";
//echo $query1."<br>";

foreach ($Inputs as $key => $t){
   if ($key < 1){
    $T = "title RLIKE '". $Inputs[0] . "' ";
   } 
   if ($key >= 1 and $t !=''){
    $T .="AND title RLIKE '". $t . "' ";
   } 
}
//echo $T."<br>";
$query2 = "SELECT id, title, year FROM Movie WHERE ". $T ."ORDER BY title";
//echo $query2."<br>";

$result1 = mysqli_query($db, $query1);
echo "<h2>Matching actors are:</h2><br>";
echo "<table class='table'>";
echo "<tr><th>Actor ID</th><th>Last Name</th> <th>First Name</th><th>Sex</th> <th>Birth Date</th> <th> Death Date</th></tr>";
while($row1 = mysqli_fetch_array($result1)) {
  display_row(array("id", "last", "first", "sex", "dob", "dod"), $row1, "ActorInformation.php");
}
echo "</table>";

$result2 = mysqli_query($db, $query2);
echo "<h2>Matching movies are:</h2><br>";
echo "<table class='table'>";
echo "<tr><th>Movie ID</th><th>Title</th> <th>Year</th></tr>";
while($row2 = mysqli_fetch_array($result2)) {
  display_row(array("id", "title", "year"), $row2, "MovieInformation.php");
}
echo "</table>";

mysqli_close($db); 
?>

</body>
</html>
