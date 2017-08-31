<?php
  session_start();
  require_once('dbconnection.php');
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $home = "users.php";
    $group = "groups.php";
    $me = '<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Me <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="profile.php">Update Profile</a></li>
                <li><a href="post.php">Post Recipes</a></li>
                <li class="disabled"><a>Create Groups</a></li>
                <li class="divider"></li>
                <li><a href="login.php">Logout</a></li>
              </ul>
            </li>';
  } else {
    $home = "login.php";
    $group = "login.php";
    $me = '<li>
              <a href="login.php">Login</a>
          </li>';
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="./css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="./css/custom.min.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="./js/html5shiv.js"></script>
      <script src="./js/respond.min.js"></script>
    <![endif]-->
    <script>
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
    </script>
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">Cookzilla</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li>
              <a href=<?php echo $home?>>Home</a>
            </li>

            <li>
              <a href="recipes.php">Recipes</a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Categories <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="recipes.php?tid=1">Chinese</a></li>
                <li><a href="recipes.php?tid=2">Italian</a></li>
                <li><a href="recipes.php?tid=3">Mexican</a></li>
                <li class="divider"></li>
                <li><a href="recipes.php?tid=10">Cake</a></li>
                <li><a href="recipes.php?tid=11">Fish</a></li>
                <li><a href="recipes.php?tid=12">Pork</a></li>
              </ul>
            </li>
            <li>
              <a href="groups.php">Groups</a>
            </li>
            <form method="POST" class="navbar-form navbar-left" role="search">
                      <div class="form-group">
                        <input id="tag_search" type="text" class="form-control" placeholder="Search Recipes" name="input_search" size="20">
                      </div>
                      <button type="submit" class="btn btn-default" name = "search">Submit</button>
            </form>

          </ul>

          <ul class="nav navbar-nav navbar-right">
            <?php echo $me ?>
          </ul>

        </div>
      </div>
    </div>


    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/custom.js"></script>
  </body>
</html>
<?php
if(isset($_POST['search']) && !empty($_POST['input_search'])){
  $keyword = $_POST['input_search'];
  echo '<script type="text/javascript">       
    window.location.href="recipes.php?keyword='.$keyword.'";
    </script>';
}
?>