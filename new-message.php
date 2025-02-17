<?php
include "connection.php";

if (ISSET($_POST["message"])) {
  $message=strval($_POST["message"]);
  $id = $_POST["id"];
  $code = $_POST["code"];
  $sqlNewMessage="INSERT INTO messages (conversation_id,message,id,time) VALUES ('$code','$message','$id',now());";
  $sqlSeen1=" UPDATE conversations SET seen=0 WHERE NOT id='$id' AND conversation_id='$code';";
  $sqlSeen2="UPDATE conversations SET seen=1 WHERE id='$id' AND conversation_id='$code';";
  if (mysqli_query($link,$sqlNewMessage)){
  echo "Donnneeeeeee 1";
}if (mysqli_query($link,$sqlSeen1)){
echo "Donnneeeeeee 2";
}
if (mysqli_query($link,$sqlSeen2)){
echo "Donnneeeeeee 3";
}
}
?>
