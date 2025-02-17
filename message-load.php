<?php
include 'connection.php';
session_start();
$name = $_SESSION["uName"];
$id=$_POST["id"];
$code=$_POST["code"];
$limit=intval($_POST["limit"]);
$sqlMessages="SELECT users.uName as username,messages.message as msg FROM messages,users WHERE users.id=messages.id and messages.conversation_id='$code' ORDER BY messages.time DESC LIMIT $limit;";
$result = mysqli_query($link, $sqlMessages);
$sqlSeen="UPDATE conversations SET seen=1 WHERE id='$id' AND conversation_id='$code';";
mysqli_query($link,$sqlSeen);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    if ($row["username"]==$name){
      echo "<div class=\"messageBlockRight\">
        <div class=\"uName\">".$row["username"]."</div>
        <div class=\"message\">".$row["msg"]."</div>
      </div>";
    }
    else {
      echo "<div class=\"messageBlockLeft\">
        <div class=\"uName\">".$row["username"]."</div>
        <div class=\"message\">".$row["msg"]."</div>
      </div>";
    }


  }
} else {
}
?>
