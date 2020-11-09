<?php

$title = 'Profile page - Stuliday';
require 'includes/header.php';

$user_id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = '{$user_id}'";
$res = $conn->query($sql);
$user = $res->fetch(PDO::FETCH_ASSOC);
//var_dump($user['id']);
?>

<div class="container">
    <div class="columns is-centered">
        <div class="column is-half">
            <h3 class="title is-3 is-spaced" style="margin-top:5%">Welcome <?php echo $user['username']; ?>
            </h3>
        </div>
    </div>
    <div class="columns is-centered">
        <div class="column is-half">
            <h3 class="title is-5 is-spaced">Manage your Adverts :</h3>
            <table class="table table-warning">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">City</th>
                        <th scope="col" colspan=3>Fonctions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        affichagePlacesByUser($user_id);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<?php
require 'includes/footer.php';
