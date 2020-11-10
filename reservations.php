<?php

$title = 'My reservations - Stuliday';
require 'includes/header.php';
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = '{$user_id}'";
$res = $conn->query($sql);
$user = $res->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="columns is-centered">
        <div class="column is-half">
            <h3 class="title is-5 is-spaced">Your reservations :</h3>
            <table class="table table-warning">
                <thead>
                    <tr>
                        <th scope="col">Place</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php //affichageReservationByUser($user_id);?>
                </tbody>
            </table>
        </div>
    </div>
</div>