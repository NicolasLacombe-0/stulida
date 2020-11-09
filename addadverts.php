<?php
$title = 'Adding adverts - Stuliday';
require 'includes/header.php';

?>


<div class="container">
    <div class="columns is-centered">
        <div class="column is-half">
            <form action="process.php" method="POST" enctype="multipart/form-data">

                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="advert_image">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choose a file…
                            </span>
                        </span>
                        <span class="file-name">
                            Screen Shot 2017-07-29 at 15.54.25.png
                        </span>
                    </label>
                </div>

                <div class="field">
                    <label class="label">Place name</label>
                    <div class="control">
                        <input class="input" type="text" name="advert_title" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Description</label>
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

                <div class="control">
                    <button class="button is-primary" name="advert_submit">Submit advert</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
require 'includes/footer.php';
