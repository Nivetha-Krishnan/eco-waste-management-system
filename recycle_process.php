<?php
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){ die("DB Connection Failed"); }

// Fetch only Received waste
$q = mysqli_query($conn,"
    SELECT id, waste_details, recycled
    FROM recycle_requests
    WHERE status='Received'
    ORDER BY id ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Recycle Process</title>
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#d4fc79,#96e6a1);padding:30px;}
h1{text-align:center;color:#145a32;margin-bottom:25px;}
.header{display:flex;background:#145a32;color:white;padding:15px;border-radius:15px;font-weight:bold;margin-bottom:20px;}
.header div{flex:1;text-align:center;}
.row{display:flex;align-items:center;background:white;border-radius:18px;padding:18px;margin-bottom:20px;box-shadow:0 10px 25px rgba(0,0,0,0.25);}
.block{flex:1;text-align:center;}
.block img{width:120px;height:120px;object-fit:contain;margin-bottom:6px;}
.arrow{font-size:28px;color:#1e8449;}
select,button{width:80%;padding:8px;margin-top:8px;border-radius:8px;font-size:14px;}
select{border:2px solid #1e8449;}
button{background:#28b463;color:white;border:none;cursor:pointer;}
button:hover{background:#1d8348;}
button.lock-btn{background:#95a5a6;cursor:not-allowed;}
.loader{width:60px;height:60px;border:8px solid #d5f5e3;border-top:8px solid #1e8449;border-radius:50%;animation:spin 1s linear infinite;margin:10px auto;display:none;}
@keyframes spin{100%{transform:rotate(360deg);}}
.product{display:none;}
.success{font-weight:bold;color:#196f3d;}
.back-btn{padding:10px 15px;margin-bottom:20px;background:#28b463;color:white;border:none;cursor:pointer;}
</style>
</head>
<body>

<button class="back-btn" onclick="location.href='recycledashboard.php'">⬅ Back</button>
<h1>♻️ Recycling Process</h1>

<div class="header">
    <div>Category</div>
    <div>Waste Type</div>
    <div>Process</div>
    <div>Product</div>
</div>

<?php 
while($r = mysqli_fetch_assoc($q)) {
    $reqId = $r['id'];
    $waste_details = strtolower($r['waste_details']);
    $isRecycled = $r['recycled'] == 1;

    $waste_items = explode(',', $waste_details);

    foreach($waste_items as $item){
        $item = trim($item);
        $parts = explode('-', $item);
        $waste_name = trim($parts[0]);
        $category = '';

        if(strpos($waste_name,'plastic') !== false) $category="Plastic Waste";
        elseif(strpos($waste_name,'fabric') !== false) $category="Fabric Waste";
        elseif(strpos($waste_name,'paper') !== false) $category="Paper Waste";
        elseif(strpos($waste_name,'metal') !== false) $category="Metal Waste";
        elseif(strpos($waste_name,'glass') !== false) $category="Glass Waste";
        elseif(strpos($waste_name,'wood') !== false) $category="Wood Waste";
        elseif(strpos($waste_name,'kitchen') !== false) $category="Kitchen Waste";
        elseif(strpos($waste_name,'garden') !== false) $category="Garden Waste";
        elseif(strpos($waste_name,'battery') !== false || strpos($waste_name,'ewaste') !== false) $category="E-Waste";
        else continue;

        $catImg = "images/category/".str_replace(' ','',$category).".png";

        // Fetch all waste type details into an array
        $typesArr = [];
        $typesRes = mysqli_query($conn,"SELECT wastetype, process, product FROM recycling_products WHERE category='$category'");
        while($t=mysqli_fetch_assoc($typesRes)){
            $typesArr[] = $t;
        }

        // For recycled items, pick first type to display (you can enhance this logic)
        $recycledProcess = $isRecycled ? $typesArr[0]['process'] : '';
        $recycledProduct = $isRecycled ? $typesArr[0]['product'] : '';
        $recycledWasteImg = $isRecycled ? "images/wastetype/".str_replace(' ','',$typesArr[0]['wastetype']).".png" : '';
        $recycledProdImg = $isRecycled ? "images/product/".str_replace(' ','',$recycledProduct).".png" : '';
?>

<div class="row" id="row<?php echo $reqId.$waste_name;?>">
<div class="block">
    <img src="<?php echo $catImg; ?>">
    <b><?php echo $category;?></b>
</div>
<div class="arrow">➡</div>

<div class="block">
    <img id="wasteImg<?php echo $reqId.$waste_name;?>" style="display:<?php echo $isRecycled ? 'block' : 'none';?>" src="<?php echo $recycledWasteImg;?>">
    <select id="select<?php echo $reqId.$waste_name;?>" <?php echo $isRecycled ? 'disabled' : ''; ?>>
        <option value="">Select Waste Type</option>
        <?php foreach($typesArr as $t){
            $wImg = "images/wastetype/".str_replace(' ','',$t['wastetype']).".png";
            $pImg = "images/product/".str_replace(' ','',$t['product']).".png";
        ?>
        <option data-process="<?php echo htmlspecialchars($t['process']);?>"
                data-product="<?php echo htmlspecialchars($t['product']);?>"
                data-wasteimg="<?php echo $wImg;?>"
                data-prodimg="<?php echo $pImg;?>">
            <?php echo htmlspecialchars($t['wastetype']);?>
        </option>
        <?php } ?>
    </select>
</div>
<div class="arrow">➡</div>

<div class="block">
    <div id="process<?php echo $reqId.$waste_name;?>"><?php echo $recycledProcess ?: '—';?></div>
    <button id="btn<?php echo $reqId.$waste_name;?>" onclick="recycle('<?php echo $reqId.$waste_name;?>')" <?php echo $isRecycled ? 'disabled class="lock-btn"' : '';?>>Recycle</button>
    <div class="loader" id="loader<?php echo $reqId.$waste_name;?>"></div>
</div>
<div class="arrow">➡</div>

<div class="block">
    <img id="prodImg<?php echo $reqId.$waste_name;?>" style="display:<?php echo $isRecycled ? 'block' : 'none';?>" src="<?php echo $recycledProdImg;?>">
    <div class="product" id="product<?php echo $reqId.$waste_name;?>">
        <div class="success" id="prodText<?php echo $reqId.$waste_name;?>"><?php echo $recycledProduct;?></div>
    </div>
</div>
</div>

<?php } } ?>

<script>
function recycle(id){
    let selectEl = document.getElementById("select"+id);
    if(selectEl.selectedIndex < 1){ alert("Select a waste type!"); return; }

    let opt = selectEl.options[selectEl.selectedIndex];
    let loader = document.getElementById("loader"+id);
    let productDiv = document.getElementById("product"+id);
    let btn = document.getElementById("btn"+id);
    let processDiv = document.getElementById("process"+id);
    let wasteImg = document.getElementById("wasteImg"+id);
    let prodImg = document.getElementById("prodImg"+id);

    processDiv.dataset.process = opt.dataset.process;
    processDiv.dataset.product = opt.dataset.product;
    processDiv.dataset.wasteimg = opt.dataset.wasteimg;
    processDiv.dataset.prodimg = opt.dataset.prodimg;

    loader.style.display="block";
    productDiv.style.display="none";

    setTimeout(()=>{
        loader.style.display="none";
        productDiv.style.display="block";

        processDiv.innerText = processDiv.dataset.process;
        wasteImg.src = processDiv.dataset.wasteimg;
        wasteImg.style.display="block";
        prodImg.src = processDiv.dataset.prodimg;
        prodImg.style.display="block";

        btn.disabled=true;
        btn.classList.add('lock-btn');
        selectEl.disabled=true;

        let xhr = new XMLHttpRequest();
        xhr.open("POST","mark_recycled.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send("id="+id);
    },2000);
}
</script>
</body>
</html>