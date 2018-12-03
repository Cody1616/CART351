<?php
class MyDB extends SQLite3
  {
    function __construct()
    {
      // open this database
       $this->open('../db/flowers.db');
    }
  }

try
{
  $db = new MyDB();
  //echo ("opened/created flower database");
}

catch(Exception $e){
  die($e);
}

//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
// need to process
 $color = $_POST['color'];
 $shape = $_POST['shape'];
 $user= $_POST['uName'];
 $query = "INSERT INTO flowers (color, shape, user) VALUES ('$color', '$shape', '$uName')";
 $ok1 = $db->exec($query);
if (!$ok1)
{
    die($db->lastErrorMsg());
}
echo "success";

}//POST

?>
