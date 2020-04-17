<?php 
//Validation
$error_fields=array();
//Open the connection
 
  $mysqli = new mysqli("localhost", "root", "", "blog");
  if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}
//Select the user
//edit.php?id=1 => $_GET['id']

$id=filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

$select="SELECT * FROM users WHERE id='".$id."' LIMIT 1";
$result=mysqli_query( $mysqli,$select);
$row=mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD'] =='POST'){

  if(!(isset($_POST['name']) && !empty($_POST['name']))){
    $error_fields[]="name";
  }
  if(!(isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){
    $error_fields[]="email";
  }
  if(!(isset($_POST['password']) && strlen($_POST['password'])>5)){
    $error_fields[]="password";
  }

  if(empty($error_fields)){


//Escape any special characters to avoid SQL Injection
//   $id=filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);
  echo "ghada";
  echo $id ;
  echo "<br/>";
  $name=mysqli_escape_string($mysqli,$_POST['name']);
  $email=mysqli_escape_string($mysqli,$_POST['email']);
  $password=(!empty($_POST['password']))? sha1($_POST['password']): $row['password'];
  $admin=(isset($_POST['admin']))? 1:0;
//insert the data
$query="UPDATE users SET name='".$name."',email='".$email."',password='".$password."',admin='".$admin."' WHERE id='".$id."' ";


if ($mysqli->query($query) === TRUE) {
    header("Location:list.php");
    exit;
}else{
    //echo $query;
    echo $mysqli->error;
}

    //Close the connection
  
//}
  }else{
    echo "errors";
  }
}
?>

<html>
<head>
   
    <title>Edit User</title>
</head>
<body>
    <form method="post">
    <label for="name">Name</label>

    <input type="hidden" name="id" id="id"  value="<?php (isset($row['id']))? $row['id']:''; ?>" />

    


    <input type="text" name="name" id="name" value="<?=(isset($row['name'])) ?$row['name']: '' ?>" />
    <?php if(in_array("name",$error_fields)) echo "* Please enter your name" ?>
    <br/>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?=(isset($row['email'])) ?$row['email']: '' ?>" /><?php if(in_array("email",$error_fields)) echo "* Please enter your email" ?>
    <br/>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" value="<?=(isset($row['password'])) ?$row['password']: '' ?>" /><?php if(in_array("password",$error_fields)) echo "* Please enter your a password not less than 6 characters"; ?>
    <br/>
    <input type="checkbox" name="admin" <?= (isset($row['admin'])) ? 'checked':'' ?>/>Admin
    <br/>
    <input type="submit" name="submit" value="Edit User"/>
    </form>
</body>
</html>