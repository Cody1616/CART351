<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<?php
echo "My session id: ".session_id()."<br>";
// Set session variables
$_SESSION["hometown"] = "zurich";
$_SESSION["motherlang"] = "german";
echo "Session variables are set.";
?>
</body>
</html>
