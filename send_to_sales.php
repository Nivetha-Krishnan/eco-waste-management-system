<?php
$conn = mysqli_connect("localhost","root","","myproject");

if(!$conn){
    die("Database Connection Failed");
}

if(isset($_POST['id']) && isset($_POST['product']) && isset($_POST['image']))
{
    $id = $_POST['id'];
    $product = trim($_POST['product']);
    $image = $_POST['image'];

    // GET RATE
    $get = mysqli_query($conn,"SELECT rate FROM recycling_products WHERE id='$id'");

    if(mysqli_num_rows($get) > 0)
    {
        $row = mysqli_fetch_assoc($get);
        $rate = $row['rate'];

        // CHECK product exists
        $check = mysqli_query($conn,"SELECT * FROM sales_products WHERE product_id='$id'");

        if(mysqli_num_rows($check) > 0)
        {
            // UPDATE quantity
            $update = mysqli_query($conn,"
            UPDATE sales_products 
            SET quantity = quantity + 1 
            WHERE product_id='$id'
            ");

            if($update){
                $message = "Quantity Updated Successfully 👍";
            } else {
                $message = "Error updating quantity ❌";
            }
        }
        else
        {
            // INSERT new product
            $insert = mysqli_query($conn,"
            INSERT INTO sales_products(product_id,product_name,rate,quantity,product_image)
            VALUES('$id','$product','$rate','1','$image')
            ");

            if($insert){
                $message = "Product Sent to Sales Successfully ✅";
            } else {
                $message = "Error inserting product ❌";
            }
        }
    }
    else
    {
        $message = "Product not found ❌";
    }
}
else
{
    $message = "Invalid Request ❌";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Send to Sales</title>

<style>
body{
    text-align:center;
    padding-top:100px;
    font-family:Arial;
    background:#f4f6f7;
}

.box{
    background:white;
    display:inline-block;
    padding:40px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
}

.message{
    font-size:22px;
    margin-bottom:30px;
    color:#2c7da0;
}

.btn{
    padding:12px 25px;
    background:#28b463;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}

.btn:hover{
    background:#239b56;
}
</style>

</head>

<body>

<div class="box">

<div class="message">
<?php echo $message; ?>
</div>

<button class="btn" onclick="window.location.href='recycledashboard.php'">
⬅ Back to Dashboard
</button>

</div>

</body>
</html>