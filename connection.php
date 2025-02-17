<?php
$servername = "localhost";
$username = "root";
$password="";
$db='instant_messenger';

// Etablit la connexion
$link = mysqli_connect($servername, $username, $password);
if (!$link) {
    die('Could not connect');
}

// selectionne la base des donnee
try {
$db_selected = mysqli_select_db($link, $db);
} catch (Exception $e) {


  // s'il n'existe pas on cree tout
  $sql = 'CREATE DATABASE ' . $db;

  if (mysqli_query($link, $sql)) {
      echo "Database created successfully\n";
      $link = mysqli_connect($servername, $username, $password, $db);

      // sql pour creer un tableu
      $sql1 = "CREATE TABLE Users (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      uName VARCHAR(30) NOT NULL,
      password VARCHAR(30) NOT NULL
      );";
      $sql2 = "CREATE TABLE conversations(
      conversation_id varchar(55) NOT NULL,
      id int(6) unsigned not null AUTO_INCREMENT,
      seen tinyint(1) NOT NULL DEFAULT 0,
      CONSTRAINT ck_id_conversations FOREIGN KEY(id)
      REFERENCES users(id)
      );";
      $sql3 = "CREATE TABLE messages (
      conversation_id varchar(55) NOT NULL,
      message varchar(255) NOT NULL,
      id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT NULL,
      CONSTRAINT FK_id_messages FOREIGN KEY (id)
      REFERENCES users (id)
      );";

      if (mysqli_query($link, $sql1) && mysqli_query($link, $sql2) && mysqli_query($link, $sql3)) {
          echo "Tables created successfully\n";
      } else {
          echo "Error creating table: " . mysqli_error($link);
      }

  } else {
      echo 'Error creating database: ' . mysqli_error($link) . "\n";
  }
}
?>
