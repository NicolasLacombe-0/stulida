<?php

$title = 'Profile page - Stuliday';
require 'includes/header.php';

$user_id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = '{$user_id}'";
$res = $conn->query($sql);
$user = $res->fetch(PDO::FETCH_ASSOC);

?>
<div class="row">
    <div class="col-8">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Advert name</th>
                    <th scope="col">Content</th>
                    <th scope="col">Price</th>
                    <th scope="col">City</th>
                    <th scope="col" colspan=3>Functions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    affichageProduitsByUser($user_id);
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require 'includes/footer.php';
