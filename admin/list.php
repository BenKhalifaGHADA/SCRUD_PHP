<?php 

session_start();
if(isset($_SESSION['id'])){
   echo '<p>Welcome '.$_SESSION['email']. '<a href="../logout.php"> Logout</a></p>';
}
else{
   header("Location: ../login.php");
   exit;
}
//Open the connection
$conn=mysqli_connect("localhost","root","","blog");
if(!$conn){
	echo mysqli_connect_error();
	exit;
}
//Do the operation 
$query="SELECT * FROM users";


//Search by the name or the email
if(isset($_GET['search'])){
   $search=mysqli_escape_string($conn,$_GET['search']);
   $query.=" WHERE (`name` LIKE '%".$search."%') OR (`email` LIKE '%".$search."%')";
   // die($query);

   // SELECT * FROM users WHERE name='jake' AND password LIKE '%w%'
   // SELECT * FROM usersWHERE (`name` LIKE '%ghada%') OR (`email` LIKE '%ghada%')
    
			// WHERE (`name` LIKE '%".$search."%') OR (`email` LIKE '%".$search."%')") or die(mysql_error());
}
$result=mysqli_query($conn,$query);  
        
?>
<html>
<head>
<title>Admin: List users</title>
</head>
<body>
<h1>List Users</h1>
<form method="GET"> 
  <input type="text" name="search" placeholder="Enter {Name} or {Email} to search" />
  <input type="submit" value="search">

</form>
<!--Display a table containg all users-->
<table>
<thead>
<tr>
   <th>Id</th>
   <th>Name</th>
   <th>Email</th>
   <th>Admin</th>
   <th>Avatar</th>
   <th>Actions</th>
</tr>
</thead>
<tbody>
<?php
while($row=mysqli_fetch_assoc($result)){
   
?>
<tr>
<td><?=$row['id']?></td>
<td><?= $row['name'] ?></td>
<td><?=$row['email'] ?></td>
<td><?= ($row['admin'])? 'Yes':'No' ?></td>
<td><?php if($row['avatar']) { ?>
<img src="
../uploads/<?=$row['name'].'.'.$row['avatar'] ;?>" style="width: 100px; height: 100px" /><?php } else {
   ?>
   <img src="../uploads/noimage.png" style="width: 100px; height: 100px" />
<?php } ?>
</td>
<td><a href="edit.php?id=<?=$row['id'] ?>">Edit</a></td>
<td><a href="delete.php?id=<?=$row['id'] ?>">Delete</a></td>
</tr>
<?php 
}
?>
</tbody>
<tfoot>
 <tr>
 <td colspan="2" style="text-align: center"><?= mysqli_num_rows($result)?> Users</td>
 <td colspan="3" style="text-align: center"><a href="add.php">Add User</a>


 </td>
 </tr>
</tfoot>
</table>
</body>
</html>
<?php 
//close the connection
mysqli_free_result($result);
mysqli_close($conn);
?>