<?php
$conn=mysqli_connect("localhost","root","","myproject");

$id=$_POST['id'];

mysqli_query($conn,"
UPDATE recycle_requests
SET recycled=1
WHERE id='$id'
");
?>
