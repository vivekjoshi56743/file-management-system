<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

?>
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>user</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style2.css">
      
</head>

<body>
   <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #333;">
      <div class="container-fluid">
         <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="ongc" width="60" height="60">
         </a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="user_wr.php">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" target="_blank" href="https://www.ongcindia.com/">About</a>
               </li>
            </ul>
            <span class="navbar-text">
               <a class="btn btn-danger" href="logout.php" role="button">Switch user</a>
               <a class="btn btn-danger" href="logout.php" role="button">Logout</a>
             </span>
         </div>
      </div>
   </nav>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"></script>
</body>

</html>
<?php
$filesInFolder = array();
$baseDir       = "data";
$currentDir    = !empty($_GET['dir']) ? $_GET['dir'] : $baseDir;
$currentDir    = rtrim($currentDir, '/');

if (isset($_GET['download'])) {
    //you could provide another logic to present requested file
    readfile($_GET['download']);
    exit;
}

$iterator = new FilesystemIterator($currentDir);
echo "<h3 id='location'>" . $iterator->getPath() . "</h3>";

echo"</br></br>FOLDERS:</br>";
foreach ($iterator as $entry) {
    $name = $entry->getBasename();

    if (is_dir($currentDir . '/' . $name)) {
        echo "<div class='upperfolder' > <a class='directory' id='$name' href='?dir=" . $currentDir . "/" . $name . "'>" . $name . "</a></div>";
    } 
}
echo"</br></br></br>FILES:</br>";
foreach ($iterator as $entry){
    $name=$entry->getBasename();
    if (is_file($currentDir . '/' . $name)) {
        echo "<div class='lowerfile' > <a class='file' id='$name' href=' ".$currentDir . "/" . $name . "' > " . $name . " </a></div>";
    }
}

?>