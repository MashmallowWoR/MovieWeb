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
      <a href="ActorInformation.php">Browse actor Information</a>
      <a class="active" href="MovieInformation.php">Browse movie information</a>
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
$mid= $_GET['rowid'];

echo "<h2>Movie information: </h2>";
echo "Note: Need to search movie first in order to show Movie information.<br>";
$query5a = "SELECT Movie.id, Movie.title, Movie.year, Movie.rating, Movie.company FROM Movie WHERE Movie.id=". $mid;
//echo $query5a. "<br>";
$query5b = "SELECT Director.first, Director.last, dob, dod FROM Director, MovieDirector WHERE Director.id=MovieDirector.did AND MovieDirector.mid=". $mid;
//echo $query5b. "<br>";
$query5c = "SELECT genre FROM MovieGenre WHERE mid=". $mid;
//echo $query5c. "<br>";

$result5a = mysqli_query($db, $query5a);
$result5b = mysqli_query($db, $query5b);
$result5c = mysqli_query($db, $query5c);

echo "<table class='table'>";
echo "<tr> <th>Movie ID</th> <th>Title</th> <th>Year</th> <th>Rating</th> <th>Company</th> </tr>";
$fields_M = array("id", "title", "year", "rating", "company");
while($row5a = mysqli_fetch_array($result5a)) {
  echo "<tr>";
  foreach ($fields_M as $field) {
   echo "<td>" . $row5a[$field] . "</td>";
  }
  echo "</tr>";
}
echo "</table>";

echo "Director name:";
$fields_Mb = array("id", "first", "last", "dob", "dod");
while($row5b = mysqli_fetch_array($result5b)){
  foreach($fields_Mb as $field) {
    echo "<td>".$row5b[$field]." </td>";
  }
}

echo "<br>Movie Genre:";
$fields_Mc = array("mid", "genre");
while($row5c = mysqli_fetch_array($result5c)){
  foreach($fields_Mc as $field) {
    echo "<td>".$row5c[$field]." </td>";
  }
}

echo "<br><h2>Actors and their roles in the movie: </h2>";
$query6 = "SELECT MovieActor.aid, Actor.last, Actor.first, MovieActor.role FROM Actor, MovieActor WHERE MovieActor.aid= Actor.id AND mid=". $mid . " ORDER BY Actor.last";
//echo $query6. "<br>";
$result6 = mysqli_query($db, $query6);
echo "<table class='table'>";
echo "<tr> <th>Actor ID</th> <th>Actor LastName</th> <th>Actor FirstName</th> <th>Role</th></tr>";
$fields_MA= array("aid", "last", "first", "role");
while($row6 = mysqli_fetch_array($result6)) {
  echo "<tr>";
  foreach ($fields_MA as $field) {
   echo "<td>" .'<a href="ActorInformation.php?rowid='.$row6[$fields_MA[0]].'">'.$row6[$field].'</a>' ."</td>"; 
  }
  echo "</tr>";
}
echo "</table>";

echo "<br><h2>User review: </h2>";
$query7a = "SELECT AVG(rating), COUNT(rating) FROM Review WHERE mid=". $mid;
//echo $query7a. "<br>";
$result7a = mysqli_query($db, $query7a);
if (mysqli_num_rows($result7a)==0) {   //have to use mysqli_num_rows(), not mysql_num_rows()
  echo "There is no review on this movie yet. Be the first one to give a review. <br>";
} else {
  while($row7a = mysqli_fetch_array($result7a)){
    $avg = $row7a[0];
    $num = $row7a[1];
  }
  echo "The average rating on this movie is ".$avg." out of 5 based on ".$num. " people's review. <br>";
  echo "<h2>Detailed reviews shown below: </h2>";
  $query7b = "SELECT name, time, rating, comment FROM Review WHERE mid=". $mid;
  $result7b = mysqli_query($db, $query7b);
  while($row7b = mysqli_fetch_array($result7b)){
    $name = $row7b[0];
    $time = $row7b[1];
    $rating = $row7b[2];
    $comment = $row7b[3];
    echo $name. " rated this movie with score ".$rating. " and left a review at ".$time. " comment with: ".$comment."<br>";
  }
}

mysqli_close($db); 
?>

<br>
<form role="form" action="AddReview.php" method="get">
    <input type="hidden" name="mid" value="<?php echo $mid; ?>" >
    <button type="submit" style="height:30px;width:100px">Add Comment</button>
</form>

</body>
</html>