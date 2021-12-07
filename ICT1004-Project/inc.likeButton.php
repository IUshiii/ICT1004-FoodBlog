<div id="demowrap">
      <div id="demo"></div>
</div>

<?php
require "2-reactions.php";
$id = $postID; // POST/PRODUCT/WHATEVER ID
$uid = $username; // USER ID, USE $_SESSION IN YOUR PROJECT
$reacts = $_REACT->get($id, $uid);
?>