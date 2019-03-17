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
      <a class="active" href="AddReview.php">Add new review</a>
    </div>
  </div>

  <a href="search.php"><i class="fas fa-search"></i> Search</a>

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
$db = new mysqli('localhost', 'cs143', '', 'CS143');
if($db->connect_errno > 0){
  die('Unable to connect to database [' . $db->connect_error . ']');
}

$queryM = "SELECT * FROM Movie ORDER BY id desc";
$resultM = mysqli_query($db, $queryM);
$movieInfo = array();
while($rowM = mysqli_fetch_array($resultM)) {
  $movieInfo[] = $rowM;
}

?>

<h2>Add new review here: </h2>
<form role="form" action="AddReview.php" method="get">
  <div class="form-group">
    <label for="">Choose a movie:* </label>
    <select name="movie">
      <?php
      foreach($movieInfo as $movie) {
        echo '<option value="'. $movie['id'].'">'. $movie['title']. '('. $movie['year'].') </option>';
      }
      ?>
    </select>
  </div>
  <br>
  <div class="form-group">
    <label for="name">Your Name: </label>
    <input name="name" value="Guest" type="text" class="form-control">
  </div>
  <br>
  <div class="form-group">
    <label for="rating">Rating: </label>
    <select name="rating">
      <option value=1> 1 </option>
      <option value=2> 2 </option>
      <option value=3> 3 </option>
      <option value=4> 4 </option>
      <option value=5> 5 </option>
    </select>
  </div>
  <div class="form-group">
    <label for="comment"><br>Comment: <br></label>
    <textarea name="comment" rows="10" cols="30">Put your comment here. </textarea>
  </div>
  <br>
  <button type="submit" name="submit" class="btn btn-default">Submit</button>
</form>
<br>

<?php
if (isset($_GET["submit"])) {
  $queryIR=  "INSERT INTO Review (name, time, mid, rating, comment) VALUES ('".$_GET["name"]."', NOW(), '".$_GET["movie"]."','".$_GET["rating"]."','".$_GET["comment"]."')";
  //echo $queryIR. "<br>";
  $resultIR = mysqli_query($db,$queryIR);
  echo "Your review was submitted.<br>";
}
mysqli_close($db); 
?>

</body>
</html>
