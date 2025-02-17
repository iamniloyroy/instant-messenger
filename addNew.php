<?php
include 'connection.php';
$name=$_POST["user"];
$username=$_POST["username"];
$sql = "SELECT id, uName FROM Users WHERE uName!='$name' AND uName LIKE '$username%'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "<li onclick=\"addNew(".$row['id'].")\" style=\"padding:7px; cursor:pointer\">".$row['uName']."</li>";//Affiche un tableu des utilisateurs
  }
} else {
  echo "<li style=\"padding:7px;\">No other user found</li>";
}

?>
