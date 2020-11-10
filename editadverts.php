<?php

$title = 'Editing Adverts - Stuliday';
require 'includes/header.php';

$id = $_GET['id'];
$sql1 = "SELECT * FROM adverts WHERE ads_id = {$id}";
$res1 = $conn->query($sql1);
$place = $res1->fetch(PDO::FETCH_ASSOC);
?>
<div class="container" style="margin:3% 0%">
    <div class="columns is-centered">
        <div class="column is-half">
            <form action="process.php" method="POST" enctype="multipart/form-data">

                <div class="field">
                    <label for="InputName">Place name</label>
                    <div class="control">
                        <input type="text" class="input" id="InputName"
                            value="<?php echo $place['ads_title']; ?>"
                            name="ads_title" required>
                    </div>
                </div>

                <div class="field">
                    <label for="InputDescription">Advert content</label>
                    <div class="control">
                        <textarea class="textarea" style="resize:none" id="InputDescription" rows="3" name="ads_content"
                            required><?php echo $place['ads_content']; ?></textarea>
                    </div>
                </div>

                <div class="field">
                    <label for="InputPrice">Price</label>
                    <div class="control">
                        <input type="number" max="999999" class="input" id="InputPrice"
                            value="<?php echo $place['price']; ?>"
                            name="price" required>
                    </div>
                </div>

                <div class="field">
                    <label for="InputAddress">Address</label>
                    <div class="control">
                        <input type="text" class="input" id="InputAddress"
                            value="<?php echo $place['address']; ?>"
                            name="address" required>
                    </div>
                </div>

                <div class="field">
                    <label for="InputCity">City</label>
                    <div class="control">
                        <input type="text" class="input" id="InputCity"
                            value="<?php echo $place['city']; ?>"
                            name="city" required>
                    </div>
                </div>


                <!-- <input class="file-input" type="text" name="advert_image"
                        value="<?php// echo $place['images']; ?>"> -->


                <div class="file has-name field">
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
                            <span class="file-name">

                                <?php
                                //afficher le nom de l'image (mais pas encore d'image dans la bdd donc compliqué)

                                // global $conn;
                                // $sth = $conn->prepare("SELECT * FROM adverts WHERE ads_id={$id}");
                                // $sth->execute();
                                // $advert = $sth->fetch(PDO::FETCH_ASSOC);
                                // var_dump($advert);
                                // echo $advert['images']['name'];?>
                            </span>
                        </span>

                    </label>
                </div>

                <input type="hidden" name="ads_id"
                    value="<?php echo $place['ads_id']; ?>" />
                <button type="submit" class="button is-primary" name="advert_edit">Edit advert</button>
            </form>
        </div>
    </div>
</div>

<?php
require 'includes/footer.php';
