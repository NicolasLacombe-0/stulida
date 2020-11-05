<?php

$title = 'Modification - Le Chouette Coin';
require 'includes/header.php';

$id = $_GET['id'];
$sql1 = "SELECT p.* FROM products AS p WHERE p.products_id = {$id}";
$res1 = $conn->query($sql1);
$product = $res1->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
    <div class="col-12">
        <form action="process.php" method="POST">
            <div class="form-group">
                <label for="InputName">Advert name</label>
                <input type="text" class="form-control" id="InputName"
                    value="<?php echo $product['ads_title']; ?>"
                    name="product_name" required>
            </div>
            <div class="form-group">
                <label for="InputDescription">Advert content</label>
                <textarea class="form-control" id="InputDescription" rows="3" name="product_description"
                    required><?php echo $product['ads_content']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="InputPrice">Prix de l'article</label>
                <input type="number" max="999999" class="form-control" id="InputPrice"
                    value="<?php echo $product['price']; ?>"
                    name="product_price" required>
            </div>
            <div class="form-group">
                <label for="InputPrice">Ville où l'article est situé</label>
                <input type="text" class="form-control" id="InputPrice"
                    value="<?php echo $product['city']; ?>"
                    name="product_city" required>
            </div>

            <input type="hidden" name="product_id"
                value="<?php echo $product['products_id']; ?>" />
            <button type="submit" class="btn btn-success" name="product_edit">Modifier l'article</button>
        </form>
    </div>
</div>


<?php
require 'includes/footer.php';
