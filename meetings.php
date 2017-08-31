<?php
	require_once('header.php');
	$display = "";
  if(isset($_POST['reptext'])){
    date_default_timezone_set('America/New_York');
    $query = "select MAX(repid) as repid
          from report";
    $response = @mysqli_query($db, $query);
        $currID = 1;
        while($row = mysqli_fetch_array($response)){
            $currID = $row['repid'] +1;
        }
    $date = date('Y-m-d H:i:s');

    $reptext = $_POST['reptext'];
    $un = $_SESSION['user_name'];
    $mtid = $_GET['mtid'];
  //    echo "Your report text is: " .$reptext."<br>";
    $query1 = "INSERT INTO report VALUES('$currID', '$un', '$mtid', '$date', '$reptext')";
    $response1 = @mysqli_query($db, $query1);       
    $display = '<div class="alert alert-dismissible alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Well done!</strong> You successfully Added new report.</a>.
    </div>';
  }





  if(isset($_GET['mtid'])){
    $mtid = $_GET['mtid'];
    $un = $_SESSION['user_name'];

    $queryfind = "select gid from meeting where mtid='$mtid'";
    $responsefind = @mysqli_query($db, $queryfind);
    while($rowfind = mysqli_fetch_array($responsefind)) {
      $gid = $rowfind['gid'];
    }

    $querygroup = "SELECT * from meeting natural join joins where uname='$un' and mtid = '$mtid'";
    $responsegroup = @mysqli_query($db, $querygroup);

    $query1 = "select j.uname from meeting m, joins j
          where m.mtid = '$mtid' and j.gid = m.gid and j.uname = '$un' and j.uname not in (
            select uname 
            from meeting natural join rsvp
            where mtid = '$mtid')";
    $response1 = @mysqli_query($db, $query1);
    
    $queryadd ="select uname
                from rsvp
          where mtid = '$mtid' AND uname = '$un'";
    $responseadd = @mysqli_query($db, $queryadd);
    
    $query2 = "select uname
               from rsvp
         where mtid = '$mtid'";
    $response2 = @mysqli_query($db, $query2); 

    $query3 = "select mtid, mtitle, mdescription as mdesc
               from meeting
         where mtid = '$mtid'";
    $response3 = @mysqli_query($db, $query3); 

    $query4 = "select repid, uname, reptime, reptext
         from report
         where mtid = '$mtid'
         order by reptime desc";
    $response4 = @mysqli_query($db, $query4); 
  }
  else{
    echo "<h2>which meeting you want to visit?</h2>";
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Groups</title>
  </head>

  <body>

    <div class="section-preview">

      <div class="container">

          <div class="col-lg-8 col-lg-offset-2">
            <div class="preview" >

          <?php

                  while($row3 = mysqli_fetch_array($response3)){
                    $mtitle = $row3['mtitle'];
                    $mdesc = $row3['mdesc'];
                    echo'<div class="image">
                    <h3 align="middle"><a href=?uname=$name>'.$mtitle.'</a></h3>
                    </div>
                    <div class="options" >
                    <h4>'.$mdesc.'</h4>
                    </div>';
                  }
          ?>
            </div>
          </div>
<div class="col-lg-8">
      <?php echo $display;?>
</div>
      <div class="col-md-8">
        <ul class="nav nav-tabs">
          <li class=""><a href="#member" data-toggle="tab" aria-expanded="false">Meeting Members</a></li>
          <li class="active"><a href="#report" data-toggle="tab" aria-expanded="false">Reports</a></li>
          <li class=""><a href="#add" data-toggle="tab" aria-expanded="false">Add reports</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">

          <div class="tab-pane fade" id="member">
            <div class="list-group">
      <?php
         while($row2 = mysqli_fetch_array($response2)){
          $uname = $row2['uname'];
          echo '<a href="users.php?uname=' .$uname.'" class="list-group-item">'.$uname.'</a>
          ';
        }
      ?>
            </div>
          </div>


          <div class="tab-pane fade active in" id="report">
            <div class="list-group">
      <?php
        while($row4 = mysqli_fetch_array($response4)){
          echo '<a href="#"  class="list-group-item">
                <span class="badge">'.$row4['reptime'].'</span>
                '.$row4['reptext'].'
              </a>'; 
        }

      ?>
            </div>
          </div>


           <div class="tab-pane fade" id="add">
<?php
      if($rowgroup = mysqli_fetch_array($responsegroup)) {

              if($row1 = mysqli_fetch_array($response1)){   
               echo '
              <div class="alert alert-dismissible alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Heads up!</strong> You need to <a href="rsvp.php?mtid='.$mtid.'" class="alert-link" id="rsvp" name="rsvp">rsvp</a> first.
              </div>';                   
              } else {

echo'
            <div class="well bs-component">

            <form class="form-horizontal" role="form" action = "meetings.php?mtid='.$mtid.'" method="POST" enctype="multipart/form-data">
              <fieldset>
                <legend>Please Enter Your Details</legend>
                <div class="form-group">
                  <label for="reptext" class="col-lg-2 control-label">Report Text</label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" id="reptext" name="reptext" placeholder="Enter your report text" maxlength = 40 required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>

                  </div>
                </div>
              </fieldset>
            </form>

            </div>';

              }


      } else {
        echo '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Oh snap!</strong> You need to <a href="joingroup.php?gid='.$gid.'" class="alert-link">join the group</a> first.
          </div>';
      }

?>

           </div>


        </div>
      </div>




      </div>

    </div>

</body>
</html>