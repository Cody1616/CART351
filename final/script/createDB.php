<?php
//public void SQLite3::open (filename, flags, encryption_key)


//function to create db
class MyDB extends SQLite3
   {
      function __construct()
      {
        // open this database
         $this->open('../db/flowers.db');
      }
   }

// create db
try
{
  // make new db
   $db = new MyDB();
   // tell user
   echo ("Opened or created graffiti gallery data base successfully<br \>");

   //sql statement
   $theQuery = 'CREATE TABLE flowers (flowerID INTEGER PRIMARY KEY NOT NULL, color INTEGER, shape INTEGER, rowPos INTEGER, yPos INTEGER, creationDate TEXT, user TEXT)';

// exec - execute (manipulate db directly)
// returns bool - true if successfull, false otherwise
  $ok = $db ->exec($theQuery);
   	// make sure the query executed
	  if (!$ok) // if false, dies
  	die($db->lastErrorMsg());
	// if everything executed error less we will arrive at this statement
	echo "Table flowers created successfully<br \>";

}
// if it doesnt work
catch(Exception $e)
{
  // die. script dies.
   die($e);
}
?>
