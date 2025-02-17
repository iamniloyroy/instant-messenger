<?php
include "connection.php";
session_start();

$code=strval($_POST["code"]);
$idNew= $_POST["idNew"];
$sqlIdCheck="SELECT id FROM conversations where id='$idNew' AND conversation_id='$code'";

if (mysqli_query($link, $sqlIdCheck)) {

  if (mysqli_num_rows(mysqli_query($link, $sqlIdCheck))==0){
    $newConversation= "INSERT INTO conversations (conversation_id,id,seen) VALUES ('$code','$idNew',0)";
    mysqli_query($link, $newConversation);
  }

}
?>
