<?php

$title = 'Adverts - Stuliday';
require 'includes/header.php';
?>

<div id="places" class="container">
    <h3 class="title is-4 is-spaced has-text-centered" style="margin-top:5%">Where do you want to stay?</h3>

    <div class="columns is-multiline">

        <?php
                affichagePlaces();
            ?>

    </div>
</div>

<?php
require 'includes/footer.php';
