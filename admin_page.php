<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>hi, <span>admin</span></h3>
      <h1>welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
      
   </div>

   <div class="content">
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>
<?php


if(isset($_POST['submit'])){

   $permission=$_POST['permission'];
   $result_explode = explode('|', $permission);

   $sql="UPDATE user_form SET permission='$result_explode[0]' WHERE id=$result_explode[1] ";
   $result=mysqli_query($conn,$sql);
}

if(isset($_POST['submit_2'])){
   $drop=$_POST['submit_2'];
   
   $sql="DELETE FROM user_form WHERE id='$drop' ";
   $result2=mysqli_query($conn,$sql);
   
}

$query = "select id,name,email,user_type,service_number,permission from user_form where user_type='user';";
$queryResult =mysqli_query($conn,$query);
echo "<table border='10'>
<tr>
<th>ID</th>
<th>NAME</th>
<th>Email</th>
<th>User Type</th>
<th>EPF number</th>
<th>Permission</th>
<th>
<th>
</tr>
";
while ($queryRow = $queryResult->fetch_row()) {
    echo "<tr>";
    for($i = 0; $i < $queryResult->field_count; $i++){
        echo "<td>$queryRow[$i]</td>";
    }
    echo "<td>
    <form action='admin_page.php' method='post'>
      <select name='permission' id='permission'>
         <option  value='read|$queryRow[0]'>read</option>
         <option value='read/write|$queryRow[0]'>read/write</option>
      </select>
      
      <input type='submit' name='submit' id='submit2' value='set permission' >
    </form>
    </td>";
    echo "<td>
    <form action='admin_page.php' method='post' onsubmit='return confirm(`Are you shure you want to delete user $queryRow[1]`);'>
    <button type='submit' name='submit_2' value='$queryRow[0]'>Delete User</button>
    </form>
    </td>";
    echo "</tr>";
}
echo "</table>";


?>