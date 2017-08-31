<?php
 require_once('header.php');
  $reviewurl = isset($_SESSION['loggedin'])? "addreview.php": "login.php";

  if(isset($_GET['recid'])){
  	  date_default_timezone_set('America/New_York');
	  $id = $_GET['recid'];
	  $_SESSION['recid'] = $id;
	  
	  $un = $_SESSION['user_name'];
	  $date = date('Y-m-d H:i:s'); 
	  
	  $query1 = "select r.rectitle as rectitle, r.servings as ser, r.recid as recid, r.uname as uname, r.rdescription as rdesc, rp.pid as pid, rp.path as path
			from recipe r left outer join (select * 
					from RecPic rp NATURAL JOIN Picture p ) rp  on r.recid = rp.recid
			where r.recid = '$id'
			group by r.recid
            order by rp.pid desc
			";
	  $response1 = @mysqli_query($db, $query1);
	
	
	  $queryt = "select * from visit where uname='$un' and recid='$id'";
	  $responset = @mysqli_query($db, $queryt);
	  if($rowt = mysqli_fetch_array($responset)){
		  $query9 = "UPDATE visit SET vtime = '$date' where recid='$id' and uname = '$un'";
		  $response9 = @mysqli_query($db, $query9);	
	  }else{
		  $query10 = "INSERT INTO visit VALUES('$un', '$id', '$date')";
		  $response10 = @mysqli_query($db, $query10);		  
	  }
	  

	  
	  //recently add for visit
	  //insert

	  
	  //check count = 6
	  $query11 = "select count(*) as co 
					  from VISIT 
					  where uname = '$un'";
	  $response11 = @mysqli_query($db, $query11);
	  if($row11 = mysqli_fetch_array($response11)){
		  $count = $row11['co'];
		  while($count>=6){
			  //delete
			  $querydelete = "delete from VISIT where uname = '$un' order by vtime LIMIT 1  ";
			  $responsedelete = @mysqli_query($db, $querydelete);
			  $count--;
		  }
	  }else{
		  echo "No such uname in VISIT table?";
	  }
	  
  }else if(isset($_GET['tid'])){
		  $tagid = $_GET['tid'];
	  $queryx = "select r.rectitle as rectitle, r.recid as recid, r.uname as uname, r.rdescription as rdesc, rp.pid as pid, rp.path as path
				from ( select * from recipe natural join recipetag where recipetag.tid='$tagid') as r          
				left outer join (select * 
						from RecPic rp NATURAL JOIN Picture p ) rp  on r.recid = rp.recid
				group by r.recid
				order by rp.pid desc
				";
	  $responsex = @mysqli_query($db, $queryx);			
	  $querytag = "select tagname from tag where tid='$tagid'";
	  $responsetag = @mysqli_query($db, $querytag);
	  //$tagname;
	  if($rowtag = mysqli_fetch_array($responsetag)){
		  $tagname  = $rowtag['tagname'];
	  }	  
  }else if(isset($_GET['keyword'])){
	  $keyword = $_GET['keyword'];
	  $queryk = "select r.rectitle as rectitle, r.recid as recid, r.uname as uname, r.rdescription as rdesc, rp.pid as pid, rp.path as path
				from ( select * from recipe where rectitle like '%$keyword%') as r          
				left outer join (select * 
						from RecPic rp NATURAL JOIN Picture p ) rp  on r.recid = rp.recid
				group by r.recid
				order by rp.pid desc
				";	  
	  $responsekey = @mysqli_query($db, $queryk);  
  }
  else{
  $query = "select r.rectitle as rectitle, r.recid as recid, r.uname as uname, r.rdescription as rdesc, rp.pid as pid, rp.path as path
			from recipe r left outer join (select * 
					from RecPic rp NATURAL JOIN Picture p ) rp  on r.recid = rp.recid
			group by r.recid
            order by rp.pid desc
			";
  $response = @mysqli_query($db, $query);

if (!$response) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}

  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!--     <link rel="stylesheet" href="./css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="./css/custom.min.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css"> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="./bower_components/html5shiv/dist/html5shiv.js"></script>
      <script src="./bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
<!--     <script>

     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();

    </script> -->
  </head>
  <body id="home">


    <div class="section-preview">

      <div class="container">

          <?php 
          	if(isset($_GET['recid'])){

				while($row = mysqli_fetch_array($response1)){					
					$picpath= $row['path'];
					$pic = $picpath;
					if($picpath==null){
						$picpath="img/nopicture.png";
					}
					$title = $row['rectitle'];
					$des = $row['rdesc'];
					$recid = $row['recid'];
					$uname = $row['uname'];
					$query2 = "select tagname
					from recipe r natural join recipetag rt natural join tag t
					where r.recid = '$id'
					order by tagname desc";
					$query3 = "select iname, quantity, unit
					from recipe r natural join ingredient i
					where r.recid = '$id'";
					$query4 ="select path
					from recipe r natural join recpic rp natural join picture p
					where r.recid = '$id'";
					$query5 = "select revid, uname, revtime, revtitle, rating, revtext, suggestion
					from review r 
					where r.recid = '$id'
					order by revtime desc";
					$query21 = "select r2.recid as recid, r2.rectitle as rectitle from recipe r1, recipelink rl, recipe r2 where r1.recid= '$id' and rl.recid = r1.recid and rl.relateTo=r2.recid";
					$query22 = "select r2.recid as recid, r2.rectitle as rectitle from recipe r1, recipelink rl, recipe r2 where r1.recid= '$id' and rl.recid = r1.recid and rl.relateTo=r2.recid";
					$response2 = @mysqli_query($db, $query2);
					$response3 = @mysqli_query($db, $query3);
					$response4 = @mysqli_query($db, $query4);
					$response5 = @mysqli_query($db, $query5);
					$response21 = @mysqli_query($db, $query21);
					$response22 = @mysqli_query($db, $query22);


		echo '<br>
		<div class="row">
        	<div class="col-md-4 col-sm-4">
	            <div class="preview" >
	              <div class="image" >
	                <a href="#"><img class="img-responsive" style="height: 250px"  width="400" src=' .$picpath. ' alt="No Pictures"></a>
	              </div>
	              <div class="options" style="height: 180px">
	                <h3>' . $title . '</h3><h4 style="color:#999999;">by <a href="users.php?uname=' .$uname. '">' . $uname . '</a></h4>

	              </div>
	 
	            </div>
            </div>
            <div class="col-md-6 col-sm-4">
            <br>';
	            	while($row2 = mysqli_fetch_array($response2)){
	            		echo ($row2['tagname'] === "Mexican" || $row2['tagname'] === "Chinese" || $row2['tagname'] === "Italian")?
	            		 '<a class="btn btn-primary btn-sm" href="#" >'.$row2['tagname'].'</a>
	            		 ': 
	            		 '<a href="#" class="btn btn-success btn-sm">'.$row2['tagname'].'</a>
	            		 ';			
					}
	              

	        echo '  
            </div>                       

            <div class="col-md-6 col-sm-4">
	            <div class="preview" style="height: 360px">
	              <h4 style="font-size: 1.40em;">' .$des. '</h4>
	 
	            </div>
            </div>

            <div class="col-md-2 col-sm-4">
            <br>
	              <ul class="list-group">';

					while($row3 = mysqli_fetch_array($response3)){
						if(strcmp($row3['unit'], "gram") == 0) {
							$in_unit = "g";
						}else if(strcmp($row3['unit'], "milliliter") == 0) {
							$in_unit = "ml";
						}else if(strcmp($row3['unit'], "ml") != 0 && strcmp($row3['unit'], "g") != 0){
							$in_unit = ($row3['quantity'] == 1)? $row3['unit']: $row3['unit']."s";
						}
					  //$in_unit = ($row3['unit'] === "gram")? "g": ($row3['unit'] === 'milliliter')? "ml" : $row3['unit'];
					  echo '<li class="list-group-item">
					    <span class="badge">'.$row3['quantity'].' '.$in_unit.'</span>
					    '.$row3['iname'].'
					  </li>	';					
					}
			echo'</ul>
	 
	            
            </div>

        </div>


        
        <h1 class="my-4">Pictures</h1>
      	<hr>

		<div class="row">';

			while($row4 = mysqli_fetch_array($response4)){
			echo'			<div class="col-lg-4 col-sm-4">
            <div class = "preview">
              <div class="image" >
                <img class="img-responsive" style="height: 250px"  width="400" src=' .$row4['path']. ' alt="Failed to load">
              </div>
            </div>
            </div>';
			}
							

	    echo'</div>



      	<h1 class="my-4">Reviews<a href = '.$reviewurl.' style="color: #999999;"><small > Add reviews</small></a>

        </h1>
      	<hr>



		<div class="row">';

			while($row5 = mysqli_fetch_array($response5)){
				$rowname = $row5['uname'];
				$star = "";
				for($x = 0; $x < $row5['rating']; $x++) {
					$star .= "★";
				}
				$star .=" ";
				$rev_suggestion = ($row5['suggestion'] == null)? null: "Suggestion: ".$row5['suggestion'];
				echo '			
			<div class="col-md-8 col-sm-4">
	            <div class="preview" >

	            <div class = "image">
	            <h3><small style="color: #FFD700; font-size: 0.8em;">'.$star.'</small>'.$row5['revtitle'].'</h3><h4>by <a href="users.php?uname=' .$rowname. '">' . $rowname . '</a>  on <small style="font-size:1.0em;">'.$row5['revtime'].'</small></h4>
	            </div>

	            	<h4 style="color: black; font-size:1.2em;">'.$row5['revtext'].'</h4>

	            	<h4 style="color: black; font-size:1.2em;">'.$rev_suggestion.'</h4>
	            	

	            </div>


	        </div>';

			}			

		echo'	        		
		</div>';

				}
          	} else if(isset($_GET['tid'])){

          		echo '<h1 class="my-4">Recipes
        			<small>'.$tagname.'</small>
      				</h1><hr>
      				<div class="row">' ;          		

				while($rowy = mysqli_fetch_array($responsex)){
					$picpath= $rowy['path'];
					if($picpath==null){
						$picpath="img/nopicture.png";
					}
					$title = $rowy['rectitle'];
					$des = shorten($rowy['rdesc']);
					$recid = $rowy['recid'];
					$uname = $rowy['uname'];
					echo'
			          <div class="col-lg-4 col-sm-4">
			            <div class="preview" >
			              <div class="image" >
			                <a href=?recid='.$recid.'><img class="img-responsive" style="height: 250px"  width="400" src='.$picpath.' alt="No Pictures"></a>
			              </div>
			              <div class="options" style="height: 250px">
			                <h3>' . $title . '</h3><h4 style="color:#999999;">by <a href="users.php?uname=' .$uname. '">' . $uname . '</a></h4>
			                <p>' .$des. '</p>
			                <div>
			                  <a class="btn btn-primary" target="_blank" href=?recid='.$recid.'>Preview</a>
			                </div>
			              </div>
			            </div>
			          </div>';
				}

          	} else if(isset($_GET['keyword'])){
          		$keyword = $_GET['keyword'];
          		echo '<h1 class="my-4">Recipes
        			<small>'.$keyword.'</small>
      				</h1><hr>
      				<div class="row">' ;  
				while($rowkey = mysqli_fetch_array($responsekey)){
					$picpath= $rowkey['path'];
					if($picpath==null){
						$picpath="img/nopicture.png";
					}
					$title = $rowkey['rectitle'];
					$des = shorten($row['rdesc']);
					$recid = $rowkey['recid'];
					$uname = $rowkey['uname'];
					echo'
			          <div class="col-lg-4 col-sm-4">
			            <div class="preview" >
			              <div class="image" >
			                <a href=?recid='.$recid.'><img class="img-responsive" style="height: 250px"  width="400" src='.$picpath.' alt="No Pictures"></a>
			              </div>
			              <div class="options" style="height: 250px">
			                <h3>' . $title . '</h3><h4 style="color:#999999;">by <a href="users.php?uname=' .$uname. '">' . $uname . '</a></h4>
			                <p>' .$des. '</p>
			                <div>
			                  <a class="btn btn-primary" href=?recid='.$recid.'>Preview</a>
			                </div>
			              </div>
			            </div>
			          </div>';
				}
          	} else {

          		echo '<h1 class="my-4">Recipes
        			<small>all</small>
      				</h1>
      				<hr>
      				<div class="row">' ;

	          	while($row = mysqli_fetch_array($response)){
					$picpath= $row['path'];
					if($picpath==null){
						$picpath="img/nopicture.png";
					}
					$title = $row['rectitle'];
					$des = shorten($row['rdesc']);
					$recid = $row['recid'];
					$uname = $row['uname'];
					echo'
			          <div class="col-lg-4 col-sm-4">
			            <div class="preview" >
			              <div class="image" >
			                <a href=?recid='.$recid.'><img class="img-responsive" style="height: 250px"  width="400" src='.$picpath.' alt="No Pictures"></a>
			              </div>
			              <div class="options" style="height: 250px">
			                <h3>' . $title . '</h3><h4 style="color:#999999;">by <a href="users.php?uname=' .$uname. '">' . $uname . '</a></h4>
			                <p>' .$des. '</p>
			                <div>
			                  <a class="btn btn-primary" href=?recid='.$recid.'>Preview</a>
			                </div>
			              </div>
			            </div>
			          </div>';
				}
			}
		  ?>


        </div>


      </div>
    </div>
    <?php

    function shorten($str) {
		if(strlen($str)>40){
			$tmp = substr($str, 0, 40);
			$str = $tmp."...";
		}
		return $str;
    }
	?>
<!--     <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/custom.js"></script> -->

    <!-- <script>
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
    </script>
  <script>/* <![CDATA[ */(function(d,s,a,i,j,r,l,m,t){try{l=d.getElementsByTagName('a');t=d.createElement('textarea');for(i=0;l.length-i;i++){try{a=l[i].href;s=a.indexOf('/cdn-cgi/l/email-protection');m=a.length;if(a&&s>-1&&m>28){j=28+s;s='';if(j<m){r='0x'+a.substr(j,2)|0;for(j+=2;j<m&&a.charAt(j)!='X';j+=2)s+='%'+('0'+('0x'+a.substr(j,2)^r).toString(16)).slice(-2);j++;s=decodeURIComponent(s)+a.substr(j,m-j)}t.innerHTML=s.replace(/</g,'&lt;').replace(/\>/g,'&gt;');l[i].href='mailto:'+t.value}}catch(e){}}}catch(e){}})(document);/* ]]> */</script> -->
    </body>
</html>
