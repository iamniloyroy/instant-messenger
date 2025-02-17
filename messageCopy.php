<?php
include 'connection.php';
session_start();

function generateRandomString($length = 6) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Instant Message</title>
        <?php


        if (!ISSET($_SESSION["uName"])){
        header("Location: index.php");
        exit();//redirige vers le fichier messenger.php s'il y a deja une session
      }else{
        if (ISSET($_GET["id"]) AND !ISSET($_GET["code"])){
          $currentUserName=$_SESSION["uName"];
          $sqlId="SELECT id FROM Users where uName='$currentUserName'";
          $idSQL=mysqli_query($link, $sqlId);
          while ($row=mysqli_fetch_assoc($idSQL)){
            $id=$row["id"];
          }
          $conversationCode= generateRandomString();
          header("Location: message.php?id=".$_GET["id"]."&code=".$conversationCode);
          exit();
          }
          elseif (ISSET($_GET["id"]) and ISSET($_GET["code"])) {
            $currentUserName=$_SESSION["uName"];
            $sqlId="SELECT id FROM Users where uName='$currentUserName'";
            $idSQL=mysqli_query($link, $sqlId);
            while ($row=mysqli_fetch_assoc($idSQL)){
              $id=$row["id"];
            }
            $code=strval($_GET["code"]);
            $otherId=$_GET["id"];
            $newConversation= "INSERT INTO conversations (conversation_id,id,seen) VALUES ('$code','$id',1)";
            $newConversationID= "INSERT INTO conversations (conversation_id,id,seen) VALUES ('$code','$otherId',0)";
            mysqli_query($link, $newConversation);
            mysqli_query($link,$newConversationID);
            header("Location: message.php?code=".$code);
            exit();
          }
          elseif (!ISSET($_GET["id"]) and ISSET($_GET["code"])){
            $currentUserName=$_SESSION["uName"];
            $sqlId="SELECT id FROM Users where uName='$currentUserName'";
            $idSQL=mysqli_query($link, $sqlId);
            while ($row=mysqli_fetch_assoc($idSQL)){
              $id=$row["id"];
            }
            $code=strval($_GET["code"]);
            $sqlIdCheck="SELECT id FROM conversations where id='$id' AND conversation_id='$code'";

            if (mysqli_query($link, $sqlIdCheck)) {

              if (mysqli_num_rows(mysqli_query($link, $sqlIdCheck))==0){
                $newConversation= "INSERT INTO conversations (conversation_id,id,seen) VALUES ('$code','$id',1)";
                mysqli_query($link, $newConversation);
              }

            }

          }



        }

        ?>

        <link href="style.css" type="text/css" rel="stylesheet">
        <script src="jquery-3.6.0.js"></script>
    </head>
    <body><form action="logout.php" method="POST">
  <input type="submit" class="logout" value="Log Out" />
</form>
      <wrapper class="messageBox">
        <p class="chatUsername" id="users"></p>
        <a href="messenger.php" class="exit">Exit</a>
        <p class="addFriends exit" id="myBtn">+</p>
        <div class="chat" id="chat">

        </div>



        <form>
          <input class="messageText" type="text" name="message" id="msg" autocomplete="off" autofocus>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="code" value="<?php echo $code; ?>">
          <input type="submit" class="sendMessage" id="sendMessage" value="Send">
        </form>
      </wrapper>

      <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="break">Add someone to the conversation</h2>
            <input class="userName" style="width:98%" id="search" type="text" autocomplete="off" placeholder="Search" name="uName">
            <div class="table">
                    <ul id="table">

            </ul></div>
          </div>
      <!-- Modal content -->
      <!-- <wrapper style="height:500px;">
      <span class="close">&times;</span>
        <input class="userName" style="width:95%" id="search" type="text" autocomplete="off" placeholder="Search" name="uName">

      </wrapper> -->

    </div>

      <script>
<?php
$name=$_SESSION["uName"]
?>

function addNew(idNe){
  modal.style.display = "none";

  $.ajax({
    type: 'POST',
    url: 'addNewParticipant.php',
    data: {
      idNew:idNe,
      code:<?php echo "\"".$code."\""; ?>
    },
    success: function () {

    }
  });


}


      $(document).ready(function(){
        $('#search').keyup(function(){
          var txt=$(this).val();
          $("#table").load("addNew.php",{
            username:txt,
            user:<?php
            echo "\"".$name."\"";
            ?>
          });
      });
      });


      // Get the modal
      var modal = document.getElementById("myModal");

      // Get the button that opens the modal
      var btn = document.getElementById("myBtn");

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];

      // When the user clicks the button, open the modal
      btn.onclick = function() {
        modal.style.display = "block";
      }

      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
        modal.style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }





      function truncateText(selector, maxLength) {
    var element = document.querySelector(selector),
        truncated = element.innerText;

    if (truncated.length > maxLength) {
        truncated = truncated.substr(0,maxLength) + '...';
    }
    return truncated;
}
document.getElementById('users').innerText = truncateText('p', 25);



      var lim=15;
      var interval = 100;
      $(document).ready(function(){
        $("#chat").scroll(function(){
          var height = document.getElementById('chat').scrollHeight-document.getElementById('chat').offsetHeight;
          if($("#chat").scrollTop()<-(height)) {
             // ajax call get data from server and append to the div
// $("#chat").append("<div class='msgloaddiv'><img class='msgload' src='assets/ellipsis.gif' /></div>");
//              window.setTimeout(function(){
//
//              $("div.msgloaddiv").remove();
             lim=lim+10;
//              }, 1000);

         }
        });
      });

      // if (Math.round($("#chat").scrollTop())==-height){
      //   alert ("sdfsdf");
      // }

      function doAjaxName() {
      $(document).ready(function(){
        $("#users").load("usernames.php",{
          id:<?php echo $id; ?>,
          code:<?php echo "\"".$code."\""; ?>
        });
        setTimeout(doAjaxName, 3000);
      });
    }
    setTimeout(doAjaxName, 100);

      function doAjax() {
      $(document).ready(function(){
        $.ajax({
          type: 'POST',
          url: 'message-load.php',
          data: {
            id:<?php echo $id; ?>,
            limit:lim,
            code:<?php echo "\"".$code."\""; ?>
          },
           beforeSend: function() {
              // $("#chat").append("<div class='msgloaddiv'><img class='msgload' src='assets/ellipsis.gif' /></div>");
          },
          success: function (data) {
            $("div.msgloaddiv").remove();
            $('#chat').html(data);

          //   $("#chat").load("message-load.php",{
          //     id:<?php echo $id; ?>,
          //     limit:lim,
          //     code:<?php echo "\"".$code."\""; ?>
          //   }
          // );


          }
        });




        setTimeout(doAjax, interval);
      });
    }
    setTimeout(doAjax, interval);


      $(function () {
              $('#sendMessage').bind('click', function (event) {
              // using this page stop being refreshing
              event.preventDefault();
              if($("#msg").val().length !=0){
                $.ajax({
                  type: 'POST',
                  url: 'new-message.php',
                  data: $('form').serialize(),
                  success: function () {
                    document.getElementById('msg').value = '';
                    $(document).ready(function(){
                      $("#chat").load("message-load.php",{
                        id:<?php echo $id; ?>,
                        limit:lim,
                        code:<?php echo "\"".$code."\""; ?>
                      });
                    });
                  }
                });
              }
              });
            });



            // $("#chat").scroll(function() {
            //   var height = document.getElementById('chat').offsetHeight;
            //   if($("#chat").scrollTop())==-height) {
            //      // ajax call get data from server and append to the div
            //      console.log("vxcvxcv");
            //    }
      // });
// var height = document.getElementById('chat').offsetHeight;
// console.log($("#chat").scrollTop(-height));
      </script>

    </body>
</html>
