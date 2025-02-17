<?php
include 'connection.php';
session_start();
$name = $_SESSION["uName"];
$id=$_POST["id"];
$code=$_POST["code"];

$sqlUserNames="SELECT DISTINCT users.uName as userName FROM conversations,users WHERE conversations.id=users.id and conversations.conversation_id='$code' and NOT users.id='$id'";
$result = mysqli_query($link, $sqlUserNames);
  // output data of each row
  $forAnd=0;
  if (mysqli_num_rows($result)>1){
  while($row = mysqli_fetch_assoc($result)) {
    if ($forAnd==(mysqli_num_rows($result))-1){
      echo " & ";
    }
    elseif ($forAnd!=0) {
      echo ",";
    }
    echo strval($row["userName"]);
    $forAnd+=1;

  }
}
else{
  while($row = mysqli_fetch_assoc($result)) {

    echo strval($row["userName"]);

  }
}
?>
