<?php
$conn = mysqli_connect("localhost","root","","myproject");

$result = mysqli_query($conn,"SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Orders</title>

<style>
    

body{
font-family:Arial;
background:#f1f8e9;
padding:20px;
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

th,td{
padding:10px;
border:1px solid #ccc;
text-align:center;
}

th{
background:#2c7da0;
color:white;
}
</style>
</head>

<body>
    

<h2>📦 Orders List</h2>

<table>
<tr>
<th>ID</th>
<th>Product</th>
<th>Customer</th>
<th>Address</th>
<th>Payment</th>
<th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['product_name']; ?></td>
<td><?php echo $row['customer_name']; ?></td>
<td>
<?php echo $row['door'].", ".$row['street'].", ".$row['district']; ?>
</td>
<td><?php echo $row['payment']; ?></td>
<td><?php echo $row['order_date']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>