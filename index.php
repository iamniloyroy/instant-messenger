<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Instant Message</title>

		<?php
    session_start();
		if (ISSET($_SESSION["uName"])){
header("Location: messenger.php");
exit();//redirige vers le fichier messenger.php s'il y a deja une session
    }
		?>
        <link href="style.css" type="text/css" rel="stylesheet">
        <script src="jquery-3.6.0.js"></script>
    </head>
    <body>
      <wrapper>
        <h2 class="break">Instant Messenger!</h2>
        <img
  src="assets/loader.gif" class="img"
/>
        <form action="messenger.php" method="post" id="signup" style="display:<?php //affiche l'erreur
if (isset($_GET['error'])){
if ($_GET['error']=='userNameExist'){
echo "block";
}else{
echo "none";
}
}
else{
echo "none";
}
  ?>">

    <div class="error" style="display: <?php //affiche l'erreur
if (isset($_GET['error'])){
  if ($_GET['error']=='userNameExist'){
  echo "block";
}else{
  echo "none";
}
}
else{
  echo "none";
}
    ?>">Username already exists</div>
            <label>Sign Up</label>
            <input class="userName" type="text" placeholder="Username" name="uName">
            <input class="userName" type="password" placeholder="Password" name="pwd">
            <input type="Submit" class="enter" Value="Enter">
            <div class="footer" id="btnSignIn">Sign In</div>
        </form>
        <form action="messenger.php" method="post" id="signin" style="display:<?php //affiche l'erreur
if (isset($_GET['error'])){
if ($_GET['error']=='userNameExist'){
echo "none";
}else{
echo "block";
}
}
else{
echo "block";
}
  ?>">
          <img
    src="assets/loader.gif" class="img"
  />
          <label>Sign In</label>
          <div class="error" style="display: <?php //affiche l'erreur
if (isset($_GET['error'])){
  if ($_GET['error']=='incorrect'){
  echo "block";
}else{
  echo "none";
}
}
else{
  echo "none";
}
    ?>">Username or password is incorrect</div>
            <input class="userName" type="text" placeholder="Username" name="userName">
            <input class="userName" type="password" placeholder="Password" name="password">
            <input type="Submit" class="enter" Value="Enter">
            <div class="footer" id="btnSignUp">Create an account</div>
        </form>
      </wrapper>
      <script>
      $(document).ready(function(){
        $("#btnSignUp").on("click",function(){
          $("#signin").hide();
          $(".img").show();
          window.setTimeout(function(){
          $(".img").hide();
          $("#signup").show();
          }, 1000);
        });
      $("#btnSignIn").on("click",function(){
          $("#signup").hide();
          $(".img").show();
          window.setTimeout(function(){
          $(".img").hide();
          $("#signin").show();
          }, 1000);
      });
    });
      </script>


    </body>
</html>
