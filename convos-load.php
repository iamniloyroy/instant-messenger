<?php
include "connection.php";
session_start();
$name=$_SESSION["uName"];

$sqlId="SELECT id FROM Users where uName='$name'";
$idSQL=mysqli_query($link, $sqlId);
while ($row=mysqli_fetch_assoc($idSQL)){
  $id=$row["id"];
}

$sqlConversations="SELECT messages.conversation_id, MAX(messages.time) AS time
FROM messages , users,conversations WHERE messages.id=users.id
AND conversations.conversation_id=messages.conversation_id AND conversations.id='$id' GROUP BY messages.conversation_id
ORDER BY time DESC";
// SELECT messages.conversation_id, MAX(messages.time) AS time
// FROM messages , users WHERE messages.id=users.id
// AND users.uName='$name' GROUP BY messages.conversation_id
// ORDER BY time DESC
$resultConversations = mysqli_query($link, $sqlConversations);
// SELECT conversations.conversation_id as cId, users.uName as uName,
//messages.message as msg,messages.time as time,
//messages.seen as seen FROM users,conversations,messages WHERE conversations.id=users.id
//AND conversations.conversation_id=messages.conversation_id
//AND users.id=messages.id AND users.uName!="nroy"
//ORDER by messages.time DESC
if (mysqli_num_rows($resultConversations) > 0) {
// output data of each row
while($row = mysqli_fetch_assoc($resultConversations)) {
  echo "<div class=\"conversations ";

  $sqlSeen="SELECT seen FROM conversations WHERE conversation_id='$row[conversation_id]' AND id='$id'";
  $resultSeen = mysqli_query($link, $sqlSeen);
  while ($seen = mysqli_fetch_assoc($resultSeen)){
    if ($seen['seen']==0){
      echo "active";
    }
  }
  echo "\"><a href=\"message.php?code=$row[conversation_id]\">
  <div class=\"names\">";
  $sqlConversationsUsers="SELECT users.uName FROM conversations,messages,users WHERE users.id=messages.id AND messages.conversation_id='$row[conversation_id]' ORDER BY messages.time DESC limit 1";
  $resultUsernames = mysqli_query($link, $sqlConversationsUsers);
  while ($sqlName = mysqli_fetch_assoc($resultUsernames)){
      echo $sqlName['uName'];
  }
  echo "</div>
  <div class=\"message\">";
  $sqlMessage="SELECT messages.message FROM conversations,messages WHERE messages.conversation_id='$row[conversation_id]' and messages.conversation_id=conversations.conversation_id ORDER BY messages.time DESC limit 1";
  $resultMessage = mysqli_query($link, $sqlMessage);
  if (mysqli_num_rows($resultMessage) > 0){
  while ($msg = mysqli_fetch_assoc($resultMessage)){
    echo $msg['message'];
  }
}
  echo "</div>
  </a></div>
  ";//Affiche un tableu des utilisateurs
}
} else {
echo "<div class=\"conversations active\" style=\"text-align:center\">
<p>No conversations found</p>
</div>";
}
?>
