<?php
$title = 'Adding adverts - Stuliday';
require 'includes/header.php';
require 'includes/navbar.php';

$sql = 'SELECT * FROM categories';
$res = $conn->query($sql);
$categories = $res->fetchAll();
?>

<div class="container">
    <div class="columns">
        <div class="column">
            <form action="advert.php" method="PSOT">

                <div class="file">
                    <label class="file-label">
                        <input class="file-input" type="file" name="advert_image">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choose a file for the image…
                            </span>
                        </span>
                    </label>
                </div>

                <div class="field">
                    <label class="label">Advert name</label>
                    <div class="control">
                        <input class="input" type="text" name="advert_title" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Content</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="Advert content" name="advert_content"
                            required></textarea>
                    </div>
                </div>

                <div class="field-body">
                    <div class="field">
                        <label class="label">Address</label>
                        <div class="control">
                            <input class="input" type="text" name="advert_address" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">City</label>
                        <div class="control">
                            <input class="input" type="text" name="advert_city" required>
                        </div>
                    </div>
                </div>

                <div class="field ">
                    <label class="label">Price</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="Price in €" name="advert_price" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Category</label>
                    <div class="control">
                        <span class="select">
                            <select name="advert_category" required>
                                <?php foreach ($categories as $category) { ?>
                                <option
                                    value="<?php echo $category['categories_id']; ?>">
                                    <?php echo $category['categories_name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </span>
                    </div>
                </div>



                <div class="control">
                    <button class="button is-primary" name="advert_submit">Submit advert</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
require 'includes/footer.php';
