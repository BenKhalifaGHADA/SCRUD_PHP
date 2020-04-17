<?php 
//Connect to DB
$mysqli = new mysqli("localhost", "root", "", "blog");
  if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

//Select the user
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$query="DELETE FROM users WHERE id=".$id." LIMIT 1";
if(mysqli_query($mysqli,$query)){
    header("Location: list.php");
    exit;
}
else{
    //echo $query;
    echo mysqli_error($mysqli);
}

//Close the connection
mysqli_close($mysqli);
?>