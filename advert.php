<?php

$title = 'Advert - Stuliday';
require 'includes/header.php';

affichagePlace($_GET['id']);
?>
<form action="process.php" method="post">
    <input type="hidden" name='book_id'
        value='<?php $_GET['id']; ?>'>
    <button type="submit" class="button is-success" name="book_submit" href="reservations.php">Book this place</button>
</form>

<?php

require 'includes/footer.php';
