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
      <a class="active" href="AddMovie.php">Add new movie information</a>
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
      <a href="MovieInformation.php">Browse movie information</a>
    </div>
  </div>

</div>

<h2>Add new movie here: </h2>
<form role="form" action="AddMovie.php" method="get">
  <div class="form-group">
    <label for="title">Title:* </label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($title);?>" placeholder="Text Input"> <span class="form-control"><?php echo $titleErr;?></span>
  </div>
  <br>
  <div class="form-group">
    <label for="company">Company:* </label>
    <input type="text" name="company" value="<?php echo htmlspecialchars($company);?>" placeholder="Text Input"> <span class="form-control"><?php echo $companyErr;?></span>
  </div>
  <br>
  <div class="form-group">
    <label for="year">Year:* </label>
    <input type="text" name="year" value="<?php echo htmlspecialchars($year);?>" placeholder="Text Input"> <span class="form-control"><?php echo $yearErr;?></span>
  </div>
  <br>
  <div class="form-group">
    <label for="rating">MPAA Rating:*  </label>
    <select name="rating">
      <option value="G"> G </option>
      <option value="NC17"> NC-17 </option>
      <option value="PG"> PG </option>
      <option value="PG13"> PG-13 </option>
      <option value="R"> R </option>
      <option value="surrendere"> surrendere </option>
    </select>
  </div>
  <br>
  <div class="form-group">
    <label for="genre">Genre: </label>
    <input type="checkbox" name="genre[]" value= "Action"> Action 
    <input type="checkbox" name="genre[]" value= "Adult"> Adult
    <input type="checkbox" name="genre[]" value= "Adventure"> Adventure 
    <input type="checkbox" name="genre[]" value= "Animation"> Animation 
    <input type="checkbox" name="genre[]" value= "Comedy"> Comedy 
    <input type="checkbox" name="genre[]" value= "Crime"> Crime 
    <input type="checkbox" name="genre[]" value= "Documentary"> Documentary 
    <input type="checkbox" name="genre[]" value= "Drama"> Drama 
    <input type="checkbox" name="genre[]" value= "Family"> Family 
    <input type="checkbox" name="genre[]" value= "Fantasy"> Fantasy 
    <input type="checkbox" name="genre[]" value= "Horror"> Horror 
    <input type="checkbox" name="genre[]" value= "Musical"> Musical 
    <input type="checkbox" name="genre[]" value= "Mystery"> Mystery 
    <input type="checkbox" name="genre[]" value= "Romance"> Romance 
    <input type="checkbox" name="genre[]" value= "Sci-Fi"> Sci-Fi 
    <input type="checkbox" name="genre[]" value= "Thriller"> Thriller 
    <input type="checkbox" name="genre[]" value= "War"> War 
    <input type="checkbox" name="genre[]" value= "Western"> Western 
  </div>
  <br>
  <button type="submit" name="submit" class="btn btn-default">Submit</button>
</form>
<br>

<?php
$db = new mysqli('localhost', 'cs143', '', 'CS143');
if($db->connect_errno > 0){
  die('Unable to connect to database [' . $db->connect_error . ']');
}

$querySMM = "SELECT id FROM MaxMovieID";
$resultSMM = mysqli_query($db, $querySMM);
while($rowSMM = mysqli_fetch_array($resultSMM)){
  $MM = $rowSMM['id'];
}

/* use below if statement to detect whether script has been submitted
if (isset($_GET["submit"])) {
    // process the form contents...
}
*/
if (isset($_GET["submit"])) {
  if (empty($_GET["title"])) {
    $titleErr = "Missing title!";
    echo $titleErr."<br>";
  } else {
    $title = $_GET["title"];
  }

  if (empty($_GET["company"])) {
    $companyErr = "Missing company!";
    echo $companyErr."<br>";
  } else {
    $company = $_GET["company"];
  }

  if (empty($_GET["year"])) {
    $yearErr1 = "Missing year!";
    echo $yearErr1."<br>";
  } elseif (!(filter_var($_GET["year"], FILTER_VALIDATE_INT))) {
    $yearErr2 = "Year is not a integer!";
    echo $yearErr2."<br>";
  } elseif (filter_var($_GET["year"], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1300, "max_range"=>2100))) === false) {
    $yearErr3 = "Year has invalid range!";
    echo $yearErr3."<br>";
  } else {
    $year = $_GET["year"];
  }

  if (empty($_GET["rating"])) {
    $ratingErr = "You must select a rating!";
    echo $ratingErr."<br>";
  } else {
    $rating = $_GET["rating"];
  }

  if (!empty($title) && !empty($company) && !empty($year) && !empty($rating) ) {
    $MM_new = $MM +1;
    $queryIM=  "INSERT INTO Movie (id, title, year, rating, company) VALUES ('".$MM_new."','".$title."','".$year."','".$rating."','" .$company."')";
    //echo $queryIM. "<br>";
    //echo $MM_new. "<br>";
    $resultIM = mysqli_query($db,$queryIM);

    if (!empty($_GET["genre"])) {
      $genres = $_GET["genre"];
      foreach($genres as $genre) {
        $queryIMG=  "INSERT INTO MovieGenre (mid, genre) VALUES ('".$MM_new."','".$genre."')";
        //echo $queryIMG. "<br>";
        $resultIMG = mysqli_query($db,$queryIMG);
      }
    }
    echo "A new movie is added.";
  }
}

//echo $MP_new. "<br>";
$queryUMM = "UPDATE MaxMovieID SET id=" .$MM_new;
$resultUMM = mysqli_query($db, $queryUMM);

mysqli_close($db); 
?>

</body>
</html>
