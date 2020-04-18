<?php 
//Validation
$error_fields=array();
if($_SERVER['REQUEST_METHOD'] =='POST'){

  if(!(isset($_POST['name']) && !empty($_POST['name'])  )){
    $error_fields[]="name";
  }
  if(!(isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){
    $error_fields[]="email";
  }
  if(!(isset($_POST['password']) && strlen($_POST['password'])>5)){
    $error_fields[]="password";
  }

  if(empty($error_fields)){

//Open the connection
  //$conn=mysqli_connect("localhost","root","","blog");
  $mysqli = new mysqli("localhost", "root", "", "blog");
  if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

//Escape any special characters to avoid SQL Injection
  $name=$_POST['name'];
  $email=$_POST['email'];
  $password=sha1($_POST['password']);
  $admin=(isset($_POST['admin']))? 1:0;
  $uploads_dir=$_SERVER['DOCUMENT_ROOT'].'/project_PHP/uploads';
  
$avatar='';
if($_FILES["avatar"]['error']==UPLOAD_ERR_OK){
  $tmp_name=$_FILES["avatar"]["tmp_name"];
  $avatar=basename($_FILES["avatar"]["name"]);
  move_uploaded_file($tmp_name,"$uploads_dir/$name.$avatar");
 
}
else{
  echo "File can't be uploaded";
  exit;
}
//insert the data
$query="INSERT INTO users (name,email,password,admin,avatar) VALUES ('".$name."','".$email."','".$password."','".$admin."','".$avatar."')";
  
//²$query="INSERT INTO `users` ( `name`, `password`, `email`, `admin`)  VALUES ( 'dssssd', 'dd','benkhalifaghada@gmail.com', '1');";
    

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
   
    <title>Add User</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
    <label for="name">Name</label>
    <input type="text" name="name" value="<?=(isset($_POST['name'])) ?$_POST['name']: '' ?>" /><?php if(in_array("name",$error_fields)) echo "* Please enter your name" ?>
    <br/>

    <label for="email">Email</label>
    <input type="email" name="email" value="<?=(isset($_POST['email'])) ?$_POST['email']: '' ?>" /><?php if(in_array("email",$error_fields)) echo "* Please enter your email" ?>
    <br/>

    <label for="password">Password</label>
    <input type="password" name="password" value="<?=(isset($_POST['password'])) ?$_POST['password']: '' ?>" /><?php if(in_array("password",$error_fields)) echo "* Please enter your a password not less than 6 characters"; ?>
    <br/>
    <input type="checkbox" name="admin" <?= (isset($_POST['admin'])) ? 'checked':'' ?>/>Admin
    <br/>

    <label for="avatar">Avatar</label>
    <input type="file" id="avatar" name="avatar" />
    <br/>
    <input type="submit" name="submit" value="Add User"/>
    </form>
</body>
</html>