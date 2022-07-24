<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}


?><!doctype html>
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

echo '<form action="" method="POST" enctype="multipart/form-data" id="form1">
<input type="file" name="file">
<button  class="btn btn-danger" type="submit" name="submit_1" >UPLOAD</button>
</form>';

echo '<form action="" method="POST" enctype="multipart/form-data" id = "form2"> 
Enter Folder Name:<input type="text" name="foldername" />
Select Folder to Upload: <input type="file" name="files[]" id="files" multiple directory="" webkitdirectory="" moxdirectory="" />
<button class="btn btn-danger" type="submit" name="submit_2" >UPLOAD</button>
</form>';

// echo '<form action="" method="POST" id ="form1">
// enter file name:<input type="text" name="filename">
// <button type="submit" name="submit_3" >Delete</button>
// </form>';
$filesandDirectories=array();
$id=0;
echo"</br></br>FOLDERS:</br>";
foreach ($iterator as $entry) {
    $id=$id+1;
    $name = $entry->getBasename();
    array_push($filesandDirectories,$name);
    if (is_dir($currentDir . '/' . $name)) {
        echo "<div class='upperfolder' > <a class='directory' id='$name' href='?dir=" . $currentDir . "/" . $name . "'>" . $name . "</a> 
        <form  style='display:inline;' action='' method='POST'  id =''onsubmit='return confirm(`Are you shure you want to delete folder $name`);'>
        <input type='hidden' value='$name' name='filename'>
        <button type='submit' class='copy-icon'  name='submit_3' >Delete</button>
    </form>
    </div>";
    }
}
echo"</br></br></br>FILES:</br>";
foreach ($iterator as $entry) {
    $id=$id+1;
    $name = $entry->getBasename();
    array_push($filesandDirectories,$name);
   if (is_file($currentDir . '/' . $name)) {
        echo "<div class='lowerfile' > <a class='file' id='$name' href=' ".$currentDir . "/" . $name . "' > " . $name . " </a>
        <form  style='display:inline;' action='' method='POST' id ='' onsubmit='return confirm(`Are you shure you want to delete file $name`);'>
        <input type='hidden' value='$name' name='filename'>
        <button type='submit' class='copy-icon'  name='submit_3' >Delete</button>
    </form>
    </div>";
    }
}

if(isset($_POST['submit_1']))
{
    if(in_array( $_FILES['file']['name'],$filesandDirectories)){
        echo '<script>alert("File uploaded")</script>';
    }
    else{
    $file=$_FILES['file'];  // superglobal _FILES gets information from files
    
    $fileName=$file['name'];
    $fileTmpName=$file['tmp_name'];
    $fileSizeinBytes=$file['size'];
    $fileError=$file['error'];
    $fileType=$file['type'];
    
    $fileExt=explode('.',$fileName);
    $fileActualExt= strtolower(end($fileExt));
    if($fileError===0){
        move_uploaded_file($fileTmpName,$iterator->getPath()."/".$fileName);
    //    header("Refresh:1");
    echo"<script>
    window.onload = function() {
       
            window.location.reload(true);
    }
    </script>";
    }
    else{
        echo "<script>alert('There was a error uploading your file!')</script>";
    }
}
}


if(isset($_POST['submit_2'])){
    
    if(in_array( $_POST['foldername'],$filesandDirectories)){
        echo '<script>alert("Folder uploaded")</script>';
    }
    else if($_POST['foldername'] != "")
  	{
  		$foldername=$_POST['foldername'];
        
  		if(!is_dir($iterator->getPath()."/".$foldername)) mkdir($iterator->getPath()."/".$foldername);
  		foreach($_FILES['files']['name'] as $i => $name)
		{
  		    if(strlen($_FILES['files']['name'][$i]) > 1)
  		    {  move_uploaded_file($_FILES['files']['tmp_name'][$i],$iterator->getPath()."/".$foldername."/".$name);
  		    }
  		}
  		// header("Refresh:1");
          echo"<script>
          window.onload = function() {
             
                  window.location.reload(true);
          }
          </script>";

         
  	}
  	else{
      echo '<script>alert("Folder name is empty.File not uploaded!")</script>';
    }
  }

   
  

  if(isset($_POST['submit_3'])){
    if($_POST['filename']===""){
        echo '<script> alert("Item deleted!")</script>';
    }
    else if(!in_array( $_POST['filename'],$filesandDirectories)){
        echo '<script>alert("Item deleted!")</script>';
    }
    else
    {
        $filename=$_POST['filename'];
        if(is_file($iterator->getpath()."/".$filename)){
        unlink($iterator->getPath()."/".$filename);
        }
        else if(is_dir($iterator->getPath()."/".$filename)){
            $dir=$iterator->getPath()."/".$filename;
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }
        // header("Refresh:1");
        echo"<script>
        window.onload = function() {
           
                window.location.reload(true);
        }
        </script>";
    }

  }
?>