<?php
	require_once('header.php');
$display = "";
  if(isset($_POST['mtitle'])){

      $query = "select MAX(mtid) as mtid
          from meeting";
      $response = @mysqli_query($db, $query);
        $currID = 1;
        while($row = mysqli_fetch_array($response)){
      $currID = $row['mtid'] +1;
        } 
      $mtitle = $_POST['mtitle'];
      $mdesc = $_POST['mdesc'];
      $gid = $_GET['gid'];
      $query12 = "INSERT INTO meeting VALUES('$currID', '$mtitle', '$mdesc', '$gid')";
      $response12 = @mysqli_query($db, $query12);   
    
      $query13 = "INSERT INTO RSVP VALUES('$currID', '$un')";
      $response13 = @mysqli_query($db, $query13); 
      $display = '<div class="alert alert-dismissible alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Well done!</strong> You successfully created new meeting.</a>.
    </div>';
  }





  if(isset($_GET['gid'])){
    $gid = $_GET['gid'];
    $un = $_SESSION['user_name'];
    
    $quer = "  select gname 
               from groups
         where gid = '$gid'";
    $respons = @mysqli_query($db, $quer);
    
    $query1 = "select gid 
               from joins
         where uname = '$un' AND gid = '$gid'";
    $response1 = @mysqli_query($db, $query1);
    
    $query2 = "select uname
               from joins
         where gid = '$gid'";
    $response2 = @mysqli_query($db, $query2); 

    $query3 = "select mtid, mtitle, mdescription as mdesc
               from meeting
         where gid = '$gid' order by mtid desc";
    $response3 = @mysqli_query($db, $query3);  


    $meetingurl = isset($_SESSION['loggedin'])? "createmeeting.php?gid=$gid": "login.php";   
    //echo $meetingurl;
  }
  else{
    $query = "select gid, gname from groups order by gid desc";
    $response = @mysqli_query($db, $query);
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


<?php

if(!isset($_GET['gid'])){
  echo'
      <div class="col-lg-8">
        <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>#</th>
              <th>Column heading</th>
            </tr>
          </thead>
          <tbody> ';
        $no = 0;
      while($row = mysqli_fetch_array($response)){
        $no ++;
        $gname = $row['gname'];
        $gid = $row['gid'];            
        echo'<tr class="info">
            <td>'.$no.'</td>
            <td><a href= "?gid=' .$gid. '">'.$gname.'</a></td>
        </tr>';
      }

         echo' </tbody>
        </table>
      </div>';
} else {
        echo $display;
        while($ro = mysqli_fetch_array($respons)){
          $gnam = $ro['gname'];
          echo'<div class="col-lg-8">
        <h1 class="my-4">' .$gnam. '</h1>
        <hr>
        </div>';
        }

        

echo'
      <div class="col-md-8">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#meeting" data-toggle="tab" aria-expanded="true">Meetings</a></li>
          <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Members</a></li>
          <li class=""><a href="#create" data-toggle="tab" aria-expanded="false">Create new meetings</a></li>
        </ul>

        <div id="myTabContent" class="tab-content">
          <div class="tab-pane fade active in" id="meeting">

            <div class="list-group">';
            while($row3 = mysqli_fetch_array($response3)){
              $mtid = $row3['mtid'];
              $mtitle = $row3['mtitle'];
              $mdesc = $row3['mdesc'];
              if(strlen($mdesc)>50){
                $tmp = substr($mdesc, 0, 50);
                $mdesc = $tmp."...";
              }
              echo '<a href="meetings.php?mtid=' .$mtid.'" class="list-group-item">
                '.$mtitle.'
              </a>';
        }

 echo'       </div>

          </div>


          <div class="tab-pane fade" id="profile">

            <div class="list-group">';
            while($row2 = mysqli_fetch_array($response2)){
              $uname = $row2['uname'];
              echo'<a href="users.php?uname=' .$uname.'" class="list-group-item">
                '.$uname.'
              </a>';
            }

 echo'       </div>

          </div>


          <div class="tab-pane fade" id="create">';

if(!isset($_SESSION['user_name'])) {
    echo '<div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Oh snap!</strong> You need to <a href="login.php" class="alert-link">Login first</a>.
    </div>';
} else if($row1 = mysqli_fetch_array($response1)) {
echo'
            <div class="well bs-component">

            <form class="form-horizontal" role="form" action = "groups.php?gid='.$gid.'" method="POST" enctype="multipart/form-data">
              <fieldset>
                <legend>Please Enter Your Details</legend>
                <div class="form-group">
                  <label for="title" class="col-lg-2 control-label">Meeting Title</label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" id="title" name="mtitle" placeholder="Title" maxlength = 40 required>
                  </div>
                </div>


                <div class="form-group">
                  <label for="des" class="col-lg-2 control-label">Description</label>
                  <div class="col-lg-10">
                    <textarea class="form-control" rid="mdesc" name="rdesc"  rows = "5" maxlength = 500></textarea>
                    <span class="help-block">Enter meeting details</span>
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

} else {
    echo '
  <div class="alert alert-dismissible alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Heads up!</strong> You need to <a href="joingroup.php?gid='.$gid.'" class="alert-link" id="join" name="join">join the group</a> first.
  </div>';


}

echo'          </div>



        </div>
      </div>';
}
?>



      </div>

    </div>

</body>
</html>