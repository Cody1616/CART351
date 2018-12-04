<?php
class MyDB extends SQLite3
{
   function __construct()
   {
      $this->open('../db/flowers.db');
   }
}
try
{
   $db = new MyDB();
}
catch(Exception $e)
{
    die($e);
}

//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

      $sql_select='SELECT * FROM flowers';
      $result = $db->query($sql_select);
      if (!$result) die("Cannot execute query.");
// get a row...
// MAKE AN ARRAY::
$res = array();
$i=0;
while($row = $result->fetchArray(SQLITE3_ASSOC))
{
  // note the result from SQL is ALREADy ASSOCIATIVE
 $res[$i] = $row;
 $i++;
}//end while
// endcode the resulting array as JSON
$myJSONObj = json_encode($res);
echo $myJSONObj;
 exit;
}//POST
?>
