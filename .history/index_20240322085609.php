<?php require_once("entities/product.class.php"); ?>
<?php include_once("header.php"); ?>
<link rel="stylesheet" type="text/css" href="site.css">

<div class="header-container">
    <button onclick="window.location.href='add_product.php'" class='add-btn'>Thêm sản phẩm</button>
    <button onclick="window.location.href='index.php'" class='back-btn'>Quay lại</button>
</div>

<div class="product-container">
    <?php
        $prods = Employee::list_employee();
        foreach ($prods as $index => $item) {
            echo "<div class='product'>";
            echo "<img src='".$item["Ma_Nv"]."' alt='Product Image'>";
            // echo "<h3>".$item["ProductName"]."</h3>";
            // echo "<p>Giá sản phẩm: ".$item["Price"]."</p>";
            // echo "<p>Số lượng sản phẩm: ".$item["Quantity"]."</p>";
            // echo "<p>Mô tả sản phẩm: ".$item["Description"]."</p>";
            echo "<button class='action-btn'>Chỉnh sửa</button>";
            echo "<button class='action-btn'>Xóa</button>";
            echo "</div>";
            if (($index + 1) % 3 === 0) {
                echo "<div class='clear'></div>";
            }
        }
    ?>
</div>

<?php include_once("footer.php"); ?>
