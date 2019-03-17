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
  <a class="active" href="index.php"><i class="fas fa-home"></i> Movie Database</a> 

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
      <a href="MovieInformation.php">Browse movie information</a>
    </div>
  </div>

</div>


<p>This website can add, search, and display data from movie database.</p>

</body>
</html>
