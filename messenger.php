<?php
include 'connection.php';
session_start();

if (ISSET($_POST["userName"]) and ISSET($_POST["password"])){
  $checkUsername=$_POST["userName"];
  $checkPassword=$_POST["password"];
$sqlIdCheck="SELECT uName FROM Users where uName='$checkUsername' AND password='$checkPassword'";
if (mysqli_query($link, $sqlIdCheck)) {
  // echo "\nChecking if the username exists already\n";
  if (mysqli_num_rows(mysqli_query($link, $sqlIdCheck))==0){
    // echo "\nAlready name exists";
    header("Location:index.php?error=incorrect");//Si l'utilisateur existe déjà, nous envoyons une erreur à la page d'index
    exit();
  }
  else{

$_SESSION["uName"]="$checkUsername";
$name=strval($_SESSION["uName"]);
    }
  }
}
if (ISSET($_POST["uName"]) and ISSET($_POST["pwd"])){
//S'il n'y a pas de session et qu'il y a une action de publication,
//on ajoute le nouvel utilisateur sinon nous le redirigeons vers index.php
$name=strval($_POST["uName"]);
$password=$_POST["pwd"];
$sqlUsername = "INSERT INTO Users (uName,password) VALUES ('$name','$password')";
$sqlCheck="SELECT uName FROM Users where uName='$name'";

if (mysqli_query($link, $sqlCheck)) {
// echo "\nChecking if the username exists already\n";
  if (mysqli_num_rows(mysqli_query($link, $sqlCheck))>0){
    // echo "\nAlready name exists";
header("Location:index.php?error=userNameExist");//Si l'utilisateur existe déjà, nous envoyons une erreur à la page d'index
    exit();
  }
  else{
    if (mysqli_query($link, $sqlUsername)) {

      $_SESSION["uName"] = $name;
      echo "\nNouvel utilisateur ajouté\n";
    } else {
      echo "\nError: " . $sql . "<br>" . mysqli_error($link);
    }
    }
} else {
  echo "\nError: " . $sql . "<br>" . mysqli_error($link);
}

}

if (!ISSET($_SESSION['uName'])) {
  header("Location: index.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Contacts</title>
        <link href="style.css" type="text/css" rel="stylesheet">
        <script src="jquery-3.6.0.js"></script>
    </head>
    <body>
      <?php
      $name=$_SESSION["uName"];
      ?>
      <form action="logout.php" method="POST">
    <input type="submit" class="logout" value="Log Out" />
  </form>
      <div class="split">
      <wrapper><h2 class="break">Start a conversation</h2>
<input class="userName" style="width:95%" id="search" type="text" autocomplete="off" placeholder="Search" name="uName">
<div class="table">
        <ul id="table">

</ul></div>
</wrapper></div>
<div class="split">
<wrapper><h2 class="break">Conversations</h2><div id="convos"></div>

</wrapper></div>
<script>
function doAjax() {
$(document).ready(function(){
  $("#convos").load("convos-load.php");
  setTimeout(doAjax, 1000);
});
}
setTimeout(doAjax, 10);


$(document).ready(function(){
  $('#search').keyup(function(){
    var txt=$(this).val();
    $("#table").load("user-search.php",{
      username:txt,
      user:<?php
      echo "\"".$name."\"";
      ?>
    });
});
});
$(document).ready(function(){
  $('#search').ready(function(){
    var txt=$(this).val();
    $("#table").load("user-search.php",{
      username:txt,
      user:<?php
      echo "\"".$name."\"";
      ?>
    });
});
});
</script>

    </body>
</html>
<?php
mysqli_close($link);
?>
