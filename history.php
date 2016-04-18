<?php
require("../includes/config.php");

$rows = CS50::query("SELECT * FROM history WHERE user_id = ?", $_SESSION["id"]);
if(count($rows)!=0)
{
 render("history.php", ["title" => "History", "values"=>$rows]);
}
else {

   apologize("This user does not have any history.");
}

?>