<?php 
//Open the connection
$conn=mysqli_connect("localhost","root","","blog");
if(!$conn){
	echo mysqli_connect_error();
	exit;
}
//Do the operation 
$query="SELECT * FROM users";
$result=mysqli_query($conn,$query);
?>
<html>
<head>
<title>Admin: List users</title>
</head>
<body>
<h1>List Users</h1>
<table>
<thead>
<tr>
   <th>Id</th>
   <th>Name</th>
   <th>Email</th>
   <th>Admin</th>
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
<td><a href="edit.php?id=<?$row['id'] ?>">Edit</a></td>
<td><a href="delete.php?id=<?$row['id'] ?>">Delete</a></td>
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