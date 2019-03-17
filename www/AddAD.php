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
      <a class="active" href="AddAD.php">Add new actor/director</a>
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
      <a href="MovieInformation.php">Browse movie information</a>
    </div>
  </div>

</div>

<h2>Add new actor/director here: </h2>
<form role="form" action="AddAD.php" method="get">
  <div class="form-group">
    <label for="choice">I want to add a(n):*  </label>
    <input type="radio" name="choice"  <?php if (isset($choice) && $choice == "actor") echo "checked"; ?> value="actor"> Actor 
    <input type="radio" name="choice"  <?php if (isset($choice) && $choice == "director") echo "checked"; ?> value="director"> Director 
  </div>  
  <br>
  <div class="form-group">
    <label for="first">First Name:* </label>
    <input type="text" name="first" value="<?php echo htmlspecialchars($first);?>" placeholder="Text Input"> <span class="form-control"><?php echo $firstErr;?></span>
  </div>
  <br>
  <div class="form-group">
    <label for="last">Last Name:* </label>
    <input type="text" name="last" value="<?php echo htmlspecialchars($last);?>" placeholder="Text Input"> <span class="form-control"><?php echo $lastErr;?></span>
  </div>
  <br>
  <div class="form-group">
    <label for="sex">Sex:*  </label>
    <input type="radio" name="sex" <?php if (isset($sex) && $sex == "Female") echo "checked"; ?> value="Female"> Female 
    <input type="radio" name="sex" <?php if (isset($sex) && $sex == "Male") echo "checked"; ?> value="Male"> Male 
  </div>
  <br>
  <div class="form-group">
    <label for="dob">Date of Birth:* </label>
    <input type="text" name="dob" value="<?php echo htmlspecialchars($dob);?>" placeholder="ie: 1960-03-21"> <span class="form-control"><?php echo $dobErr; ?></span>
  </div>
  <br>
  <div class="form-group">
    <label for="dod">Date of Death (leave blank if still alive): </label>
    <input type="text" name="dod" value="<?php echo htmlspecialchars($dod);?>" class="form-control" placeholder="ie: 1999-04-21">
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

$querySMP = "SELECT id FROM MaxPersonID";
$resultSMP = mysqli_query($db, $querySMP);
while($rowSMP = mysqli_fetch_array($resultSMP)){
  $MP = $rowSMP['id'];
}

/* use below if statement to detect whether script has been submitted
if (isset($_GET["submit"])) {
    // process the form contents...
}
*/
if (isset($_GET["submit"])) {
  if (empty($_GET["choice"])) {
    $choiceErr = "You must select what to add!";
    echo $choiceErr."<br>";
  } else {
    $choice = $_GET["choice"];
  }

  if (empty($_GET["first"])) {
    $firstErr = "Missing first name!";
    echo $firstErr."<br>";
  } else {
    $first = $_GET["first"];
  }

  if (empty($_GET["last"])) {
    $lastErr = "Missing last name!";
    echo $lastErr."<br>";
  } else {
    $last = $_GET["last"];
  }

  if (empty($_GET["sex"])) {
    $sexErr = "You must select a sex!";
    echo $sexErr."<br>";
  } else {
    $sex = $_GET["sex"];
  }

  if (empty($_GET["dob"])) {
    $dobErr = "Missing date of birth!";
    echo $dobErr."<br>";
  } else {
    $dob = $_GET["dob"];
  }

  if (empty($_GET["dod"])) {
    $dod = 'NULL';
  } else {
    $dod = $_GET["dod"];
  }  

  if (!empty($choice) && !empty($last) && !empty($first) && !empty($sex) && !empty($dob) ) {
      if ($_GET['choice'] =="actor") {
        $MP_new = $MP +1;
        $queryIAD=  "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES ('".$MP_new."','".$last."','".$first."','".$sex."','" .$dob."','".$dod."')";
        //echo $queryIAD. "<br>";
        $resultIAD = mysqli_query($db,$queryIAD);
        echo "A new actor is added.";
      } elseif ($_GET['choice'] =="director") {
        $MP_new = $MP +1;
        $queryIAD=  "INSERT INTO Director (id, last, first, dob, dod) VALUES ('".$MP_new."','".$last."','".$first."','".$dob."','".$dod."')";
        //echo $queryIAD. "<br>";
        $resultIAD = mysqli_query($db,$queryIAD);
        echo "A new Director is added.";
      }
  }
}

//echo $MP_new. "<br>";
$queryUMP = "UPDATE MaxPersonID SET id=" .$MP_new;
$resultUMP = mysqli_query($db, $queryUMP);

mysqli_close($db); 
?>

</body>
</html>
