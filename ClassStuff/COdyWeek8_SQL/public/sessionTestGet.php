<?php
session_start();
?>
<?php
//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
// need to process
 $_SESSION['a_name'] = $_POST['a_name'];
 $_SESSION['a_title'] = $_POST['a_title'];
 $_SESSION['a_geo_loc'] = $_POST['a_geo_loc'];
 $_SESSION['a_descript'] = $_POST['a_descript'];
 $_SESSION['a_date'] =$_POST['a_date'];
if($_FILES)
  {
    //echo "file name: ".$_FILES['filename']['name'] . "<br />";
  //  echo "path to file uploaded: ".$_FILES['filename']['tmp_name']. "<br />";
    $fname = $_FILES['filename']['name'];
    move_uploaded_file($_FILES['filename']['tmp_name'], "images/".$fname);
    $_SESSION['a_image'] = $fname;
    //REDIRECT
    header("Location:insertFormWithSession.php");
    //RETURN ...
    return;
  }
}
?>
<?php
if(isset($_SESSION['a_image'])&&$_SESSION['a_title']&&$_SESSION['a_geo_loc']&&
$_SESSION['a_descript']&&$_SESSION['a_date']&&$_SESSION['a_image']){

  $artist =   $_SESSION['a_name'];
  $title = $_SESSION['a_title'];
  $loc = $_SESSION['a_geo_loc'];
  $description = $_SESSION['a_descript'];
  $creationDate = $_SESSION['a_date'];
  $fname = $_SESSION['a_image'];

  echo "<br \>Stored in: " . "images/" .$fname."<br \>";
  echo "<div class = 'outer'>";
  echo "<h3> Results from user </h3>";
  echo "<div class ='content'>";
  echo "<p> Artist:: ".$artist."</p>";
  echo "<p> Title:: ".$title."</p>";
  echo "<p> Location:: ".$loc."</p>";
  echo "<p> Description:: ".$description."</p>";
  echo "<p> Creation Date:: ".$creationDate."</p>";
  echo "<img src ='images/".$fname."'\>";
  echo "</div>";
  echo "</div>";
  // remove all session variables
  session_unset();
  //destroy a session
  session_destroy();

}
?>
