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

  <a href="search.php"><i class="fas fa-search"></i> Search</a>

  <div class="dropdown">
    <button class="dropbtn"><i class="fas fa-glasses"></i> Browse 
      <i class="fas fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a class="active" href="ActorInformation.php">Browse actor Information</a>
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
$db = new mysqli('localhost', 'cs143', '', 'CS143');
if($db->connect_errno > 0){
  die('Unable to connect to database [' . $db->connect_error . ']');
}
$aid= $_GET['rowid'];

echo "<h2>Actor information: </h2>";
echo "Note: Need to search actor first in order to show Actor information.<br>";
$query3 = "SELECT * FROM Actor WHERE id=". $aid;
//echo $query3. "<br>";
$result3 = mysqli_query($db, $query3);
echo "<table class='table'>";
echo "<tr><th>Actor ID</th><th>Last Name</th> <th>First Name</th><th>Sex</th> <th>Birth Date</th> <th> Death Date</th></tr>";
$fields_A= array("id", "last", "first", "sex", "dob", "dod");
while($row3 = mysqli_fetch_array($result3)) {
  echo "<tr>";
  foreach ($fields_A as $field) {
   echo "<td>" . $row3[$field] . "</td>";
  }
  echo "</tr>";
}
echo "</table>";

echo "<br><h2>Actor's movie and role: </h2>";
$query4 = "SELECT MovieActor.mid, Movie.title, MovieActor.role FROM Movie, MovieActor WHERE MovieActor.mid= Movie.id AND aid=". $aid . " ORDER BY Movie.title";
//echo $query4. "<br>";
$result4 = mysqli_query($db, $query4);
echo "<table class='table'>";
echo "<tr><th>Movie ID</th><th>Movie Title</th><th>Role</th></tr>";
$fields_AM= array("mid", "title", "role");
while($row4 = mysqli_fetch_array($result4)) {
  echo "<tr>";
  foreach ($fields_AM as $field) {
   echo "<td>" .'<a href="MovieInformation.php?rowid='.$row4[$fields_AM[0]].'">'.$row4[$field].'</a>' ."</td>";  //syntac is: <a href="page2.php?val=1">Link that pass the value 1</a>
  }
  echo "</tr>";
}
echo "</table>";

mysqli_close($db); 
?>
</body>
</html>
