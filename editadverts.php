<?php

$title = 'Modification - Le Chouette Coin';
require 'includes/header.php';

$id = $_GET['id'];
$sql1 = "SELECT * FROM adverts WHERE ads_id = {$id}";
$res1 = $conn->query($sql1);
$place = $res1->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
    <div class="col-12">
        <form action="process.php" method="POST">
            <div class="form-group">
                <label for="InputName">Place name</label>
                <input type="text" class="form-control" id="InputName"
                    value="<?php echo $place['ads_title']; ?>"
                    name="ads_title" required>
            </div>
            <div class="form-group">
                <label for="InputDescription">Advert content</label>
                <textarea class="form-control" id="InputDescription" rows="3" name="ads_content"
                    required><?php echo $place['ads_content']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="InputPrice">Price</label>
                <input type="number" max="999999" class="form-control" id="InputPrice"
                    value="<?php echo $place['price']; ?>"
                    name="price" required>
            </div>
            <div class="form-group">
                <label for="InputAddress">Address</label>
                <input type="text" class="form-control" id="InputAddress"
                    value="<?php echo $place['address']; ?>"
                    name="address" required>
            </div>

            <div class="form-group">
                <label for="InputCity">City</label>
                <input type="text" class="form-control" id="InputCity"
                    value="<?php echo $place['city']; ?>"
                    name="city" required>
            </div>


            <!-- <input class="file-input" type="text" name="advert_image"
                        value="<?php// echo $place['images']; ?>"> -->


            <div class="file has-name form-group">
                <label class="file-label">
                    <input class="file-input" type="file" name="advert_image"
                        value="<?php echo $place['images']; ?>">
                    <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Change your image…
                        </span>
                    </span>

                </label>
            </div>

            <input type="hidden" name="ads_id"
                value="<?php echo $place['ads_id']; ?>" />
            <button type="submit" class="btn btn-success" name="advert_edit">Edit advert</button>
        </form>
    </div>
</div>


<?php
require 'includes/footer.php';
