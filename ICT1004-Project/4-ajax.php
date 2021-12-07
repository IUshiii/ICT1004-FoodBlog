<?php
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}

$username = $_SESSION['login'];
// (A) INIT
require "2-reactions.php";

// (B) SAVE/UPDATE REACTION
if (!$_REACT->save($_POST["id"], $username, $_POST["react"])) {
  exit(json_encode(["error" => $_REACT->error]));
}

// (C) GET UPDATED REACTIONS
$result = $_REACT->get($_POST["id"]);
echo json_encode($result["react"]);

// POSSIBLE RESPONSES
// ["ERROR" => ERROR MESSAGE]
// [LIKES, DISLIKES]
