<?php
//We will use it for storing the signed in user data
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Connect to DB
    $mysqli = new mysqli("localhost", "root", "", "blog");
  if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

//Escape any special characters to avoid SQL Injection
$email=mysqli_escape_string($mysqli,$_POST['email']);
$password=sha1($_POST['password']);

//select
$query="SELECT * FROM users WHERE email='".$email."' and password='".$password."' LIMIT 1";
$result=mysqli_query($mysqli,$query);
if($row= mysqli_fetch_assoc($result)){
    $_SESSION['id']=$row['id'];
    $_SESSION['email']=$row['email'];
    header("Location: admin/list.php");
    exit;

}
else{
    $error='Invalid email or password';
}

//close the connection
mysqli_free_result($result);
mysqli_close($mysqli);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php if(isset($error)) echo $error; ?>
    <form method="post">
     <label for="email">Email</label>
     <input type="email" name="email" id="email" value="<?= (isset($_POST['email']))? $_POST['email']:'' ?>" /> <br/>

     <label for="password">Password: </label>
     <input type="paswword" name="password" id="password"/> </br>

     <input type="submit" name="submit" value="Login" />
    </form> 
</body>
</html>