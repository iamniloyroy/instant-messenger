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
    </head>
    <body>
      <div class="split">
      <wrapper>
        <form action="messenger.php" method="post">
		<h2 class="break">Instant Messenger!</h2>
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
        </form>
      </wrapper></div>
      <div class="split">
      <wrapper>
        <form action="messenger.php" method="post">
		<h2 class="break">Sign in</h2><div class="error" style="display: <?php //affiche l'erreur
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
        </form>
      </wrapper></div>


    </body>
</html>
