<?php
 require_once('header.php');
 $querytag = "SELECT * FROM tag";
 $responsetag = @mysqli_query($db, $querytag);

$display="";
 function add($db) {
 	  $query = "select MAX(recid) as recid
			from recipe";
	  $response = @mysqli_query($db, $query);
	  $currID = 1;
	  while($row = mysqli_fetch_array($response)){
		  $currID = $row['recid'] +1;
	  }
	  //recipe
	   //echo "Your user name is: ".$_SESSION['user_name']."<br>";
	   if( isset($_POST['title']) && isset($_POST['servings'])){
		  $title = $_POST['title'];
		  $ser = $_POST['servings'];
		  $rdesc = $_POST['rdesc'];
		  $un = $_SESSION['user_name'];
		  $query5 = "INSERT INTO recipe VALUES('$currID', '$title', '$ser', '$rdesc', '$un')";
		  $response5 = @mysqli_query($db, $query5);	  
	  }
	  //ingredient
	  if( isset($_POST['quantity']) && isset($_POST['unit']) && isset($_POST['iname']) ){
		  $quan = $_POST['quantity'];
		  $unit = $_POST['unit'];
		  $iname = $_POST['iname'];
		  $len1 = count($quan);
		  $j = 0;
		  while($j < $len1){
			$query1 = "INSERT INTO ingredient VALUES('$currID', '$iname[$j]', '$quan[$j]', '$unit[$j]' )";
			$response1 = @mysqli_query($db, $query1);		
			$j++;
		  }
	  } 
	  if(isset($_POST['tag_list'])){
		  $tag = $_POST['tag_list'];
		  $k = 0;
		  if($tag==null){
			//  echo "No tag";
		  }else{
			$lent = count($tag);
		//	echo "You add ".$lent. " tags";
		//	echo "<br>";
			while($k < $lent){
				$quer = "INSERT INTO recipetag VALUES('$currID','$tag[$k]')";
				$respons = @mysqli_query($db, $quer);
				$k++;
			}
		  }
	  }else{
		  //echo "No tags";
	  }
 }

  //recpic
   if(isset($_FILES['image'])){	 
	 $array = $_FILES['image'];
	 $len = count($array['name']);
	// echo "You add ".$len. " pictures";
	 if($array['name'][0]==null){
		 add($db);
		 $display = '<div class="alert alert-dismissible alert-success">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Well done!</strong> You successfully posted the recipe. Want to post another recipe?</a>.
		</div>';
	 }else{
		 $i = 0;		 
		 while($i< $len){
				  $errors= array();
				  $file_name =$array['name'][$i];
				  $file_size =$array['size'][$i];
				  $file_tmp =$array['tmp_name'][$i];
				  $file_type=$array['type'][$i];
				  $file_ext=strtolower(end(explode('.',$array['name'][$i])));
				  
				  $expensions= array("jpeg","jpg","png");
				  
				  if(in_array($file_ext, $expensions)=== false){
					 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
				  }
				  
				  if($file_size > 2097152){
					 $errors[]='File size must be excately smaller than 2 MB.';
				  }
				  
				  if(empty($errors)==true){
					 move_uploaded_file($file_tmp,"img/".$file_name);
					 $path = "img/".$file_name;
					 //echo "<img src=" . $path . ">";
					 $queryfind ="SELECT * from picture where path = '$path'";
					 $responsefind = @mysqli_query($db, $queryfind);
					 $rowfind = mysqli_fetch_array($responsefind);
					 $currPID = 1;
					 if($rowfind==null){
						 $q = "select MAX(pid) as pid
									from picture";
						 $resp = @mysqli_query($db, $q);						 
						 while($r = mysqli_fetch_array($resp)){
							$currPID = $r['pid'] +1;
						 }
						 $query2 = "INSERT INTO picture VALUES('$currPID', '$path')";
						 $response2 = @mysqli_query($db, $query2);						 
					 }else{
						 $currPID = $rowfind['pid'];
						 $w = $i+1;
						// echo "<br>The " .$w. "th picture already exists";
					 }
					 $query3 = "INSERT INTO recpic VALUES('$currID', '$currPID')";
					 $response3 = @mysqli_query($db, $query3);
					 $display = '<div class="alert alert-dismissible alert-success">
								  <button type="button" class="close" data-dismiss="alert">&times;</button>
								  <strong>Well done!</strong> You successfully posted the recipe. Want to post another recipe?</a>.
								</div>';
					add($db);
				  } else{
				  	  //$display = "I am here bodyu";
					  foreach($errors as $a){
					  	//   $display .='<div class="alert alert-dismissible alert-danger">
								//   <button type="button" class="close" data-dismiss="alert">&times;</button>
								//   <strong>Oh snap!</strong>'.$a.'
								// </div>';
					  }
					  					  	  $display .='<div class="alert alert-dismissible alert-danger">
								  <button type="button" class="close" data-dismiss="alert">&times;</button>
								  <strong>Oh snap!</strong>' .$a.'
								</div>';
				  }
				  $i++;
		 }
	 }
   } else {
   }

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
   		<div class="row">
      	<div class="col-lg-8">
        <div class="well bs-component">

		<form class="form-horizontal" role="form" action = "post.php" method="POST" enctype="multipart/form-data">
		  <fieldset>
		  <?php
		  echo $display; 
		  ?>
		    <legend>Please Enter Your Details</legend>
		    <div class="form-group">
		      <label for="title" class="col-lg-2 control-label">Recipe Title</label>
		      <div class="col-lg-10">
		        <input type="text" class="form-control" id="title" name="title" placeholder="Title" maxlength = 40 required>
		      </div>
		    </div>
		    <div class="form-group">
		      <label for="serving" class="col-lg-2 control-label">Serving(s)</label>
		      <div class="col-lg-10">
					<input type="number" class="form-control" id="servings" name="servings" placeholder="Serving(s)" min = 1 max = 999 required>
		      </div>
		    </div>



			<div class="form-group">
				<label for="serving" class="col-sm-2 control-label">Ingredients</label>
				<div id="in">
					<div class="col-sm-3">
						<input type="number" class="form-control" id="quantity" name="quantity[]" placeholder="Number" min = 1 max = 999 required>
					</div>
					<div class="col-sm-2">
						<select class="form-control" name="unit[]">
							<option value="gram">gram(s)</option>
							<option value="milliliter">ml.(s)</option>
							<option value="cup">cup(s)</option>
						</select>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="iname" name="iname[]" placeholder="Ingredient" required>
					</div>
				</div>
					<div class="col-sm-2 col-sm-offset-10">
						<input type="button" style="float: right;" class="btn btn-primary"  onclick="add_fields('in', 1);" value="Add More" />
					</div>
			</div>


		    <div class="form-group">
		      <div class="col-lg-10 col-lg-offset-2">
		        <div class="checkbox">	

		        <?php
					while($rowtag = mysqli_fetch_array($responsetag)){
					echo '
			          <label>
			            <input type="checkbox" name="tag_list[]" value='.$rowtag['tid'].' > '.$rowtag['tagname'].'&emsp;&emsp;
			          </label>
					';

					}
				?>

		        </div>

		      </div>
		    </div>


		    <div class="form-group">
		      <label for="des" class="col-lg-2 control-label">Description</label>
		      <div class="col-lg-10">
		        <textarea class="form-control" id="rdesc" name="rdesc"  rows = "5" maxlength = 500></textarea>
		        <span class="help-block">Enter how to make the food item</span>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="pic" class="col-lg-2 control-label">Pictures</label>
		      <div id = "ppp">
			      <div class="col-sm-10">
					 <input type="file" name="image[]" />			  
				  </div>			
			  </div>
		      <div class="col-sm-2 col-sm-offset-10">
				<input type="button" class="btn  btn-primary"  style="float: right; id="ppp" onclick="add_fields('ppp', 2);" value="Add More" />	
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

	</div>
	</div>
	</div>


      </div>
    </div>


	<script>
	//a is id and b : 1: ingredient. 2: Pictures
	function add_fields(a, b) {
		var objTo = document.getElementById(a);
		var divtest = document.createElement("div");
		if(b == 1) {
			divtest.innerHTML = '<div class="col-sm-3 col-sm-offset-2"><input type="number" class="form-control" id="quantity" name="quantity[]" placeholder="Number" min = 1 max = 999 required></div>'
			+'<div class="col-sm-2"><select class="form-control" name="unit[]"><option value="gram">gram(s)</option><option value="milliliter">ml.(s)</option><option value="cup">cup(s)</option></select></div>'
			+'<div class="col-sm-3"><input type="text" class="form-control" id="iname" name="iname[]" placeholder="Ingredient" required></div>	';				
		}else if(b == 2) {
			divtest.innerHTML = '<div class="col-sm-10 col-sm-offset-2"><input type="file" name="image[]" /></div>';
		}
					
		objTo.appendChild(divtest)
	}

	</script>
  </body>
</html>