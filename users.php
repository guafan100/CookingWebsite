<?php
  require_once('header.php');
  //require_once('/Library/WebServer/Documents/cz/dbconnection.php');
  $name;
  //you
  if(!isset($_GET['uname'])) {
    $loginname = $_SESSION['loginname'];
    $query1 = $db->query("SELECT User.uname FROM User where loginname = '$loginname' ");
    $row_name = $query1->fetch_array(MYSQLI_ASSOC);
    $name = $row_name['uname'];
    $_SESSION['user_name'] = $name;
  } else {
    $name = $_GET['uname'];
  }

  $query= $db->query("SELECT User.uinfo FROM User where uname = '$name' ");
  $row_info = $query->fetch_array(MYSQLI_ASSOC);
  $uinfo = $row_info['uinfo'];


  $sql10 = "SELECT r.recid, r.rectitle, v.vtime from visit v, recipe r where v.uname = '$name' and v.recid = r.recid order by v.vtime desc";
  $response10 = mysqli_query($db, $sql10);

  $sql = "SELECT rectitle, recid from Recipe where uname='$name' order by recid desc";
  $recipe = mysqli_query($db, $sql);

  $sql1 = "SELECT gname, gid from groups natural join joins where uname = '$name'";
  $group = mysqli_query($db, $sql1);

  $sql2 = "SELECT mtid, mtitle from rsvp natural join meeting where uname = '$name'";
  $meet = mysqli_query($db, $sql2);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  </head>

<body>
	<div class="section-preview">

    <div class="container">

      <div class="col-lg-8 col-lg-offset-2">
        <div class="preview" >
          <div class="image" >
          <?php
            echo "<h3 align='middle'><a href=?uname=$name>$name</a>'s kitchen</h3>";
          ?>
          </div>
          <div class="options" >
          <?php
          echo '
            <h4>'.$uinfo.'</h4>
            ';
          ?>
          </div>
        </div>
      </div>


      <div class="col-md-8">
        <ul class="nav nav-tabs">
          <li class=""><a href="#recipe" data-toggle="tab" aria-expanded="false">Recipes</a></li>
          <li class=""><a href="#group" data-toggle="tab" aria-expanded="true">Groups</a></li>
          <li class=""><a href="#meeting" data-toggle="tab" aria-expanded="false">Meetings</a></li>
          <li class="active"><a href="#recent" data-toggle="tab" aria-expanded="false">Recently visited recipes</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">

          <div class="tab-pane fade" id="recipe">
            <div class="list-group">
      <?php
          while ($row1 = mysqli_fetch_array($recipe)){
            $rectitle = $row1['rectitle'];
            $recid = $row1['recid'];
            echo '<a href="recipes.php?recid='.$recid.'" class="list-group-item">'.$rectitle.'</a>
          ';
          }
      ?>
            </div>
          </div>

          <div class="tab-pane fade" id="group">
            <div class="list-group">
      <?php
          while ($row_grp = mysqli_fetch_array($group)){
            $gname = $row_grp['gname'];
            $gid = $row_grp['gid'];
            echo '<a href="groups.php?gid='.$gid.'" class="list-group-item">'.$gname.'</a>
          ';
          }
      ?>
            </div>
          </div>

          <div class="tab-pane fade" id="meeting">
            <div class="list-group">
      <?php
          while ($row_meet = mysqli_fetch_array($meet)){
            $mtitle = $row_meet['mtitle'];
            $mtid = $row_meet['mtid'];  
            echo '<a href="meetings.php?mtid='.$mtid.'" class="list-group-item">'.$mtitle.'</a>
          ';
          }
      ?>
            </div>
          </div>



          <div class="tab-pane fade active in" id="recent">
            <div class="list-group">
      <?php
            while ($row10 = mysqli_fetch_array($response10)){
              $recid = $row10['recid'];
              $rectitle = $row10['rectitle']; 
              $vtime = $row10['vtime'];
              echo '<a href="recipes.php?recid='.$recid.'"  class="list-group-item">
                <span class="badge">'.$vtime.'</span>
                '.$rectitle.'
              </a>';            
              }


      ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>