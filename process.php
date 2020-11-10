<?php

require 'includes/header.php';

$title = 'Processing - Stuliday';

if ('POST' != $_SERVER['REQUEST_METHOD']) {
    echo "<div class='alert alert-danger'>ERROR The page doesn't exist !</div>";
} elseif (isset($_POST['advert_submit'])) {
    //echo 'submit marche!   ';
    if (!empty($_POST['advert_title']) && !empty($_POST['advert_content']) && !empty($_POST['advert_price']) && !empty($_POST['advert_city']) && !empty($_POST['advert_address'])) {
        $title = strip_tags($_POST['advert_title']);
        $content = strip_tags($_POST['advert_content']);
        $price = intval(strip_tags($_POST['advert_price']));
        $address = strip_tags($_POST['advert_address']);
        $city = strip_tags($_POST['advert_city']);
        $user_id = $_SESSION['id'];
        $image = $_FILES['advert_image'];
        //var_dump($image);
        // if (is_int($price) && $price > 0 && $price < 1000000) {
        //     try {
        //         $sth = $conn->prepare('INSERT INTO products (products_name,description,price,city,category_id,user_id) VALUES (:products_name, :description, :price, :city, :category_id, :user_id)');
        //         $sth->bindValue(':products_name', $name, PDO::PARAM_STR);
        //         $sth->bindValue(':description', $description, PDO::PARAM_STR);
        //         $sth->bindValue(':price', $price, PDO::PARAM_INT);
        //         $sth->bindValue(':city', $city, PDO::PARAM_STR);
        //         $sth->bindValue(':category_id', $category, PDO::PARAM_INT);
        //         $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        //         if ($sth->execute()) {
        //             echo "<div class='alert alert-success'>Votre article a été ajouté à la base de données</div>";
        //             header('Location: products.php');
        //         }
        //     } catch (PDOException $e) {
        //         echo 'Error'.$e->getMessage();
        //     }
        // }
        //echo 'ca va faire tourner la fonction!   ';
        ajoutProduits($title, $content, $price, $address, $city, $image, $user_id);
    }
} elseif (isset($_POST['advert_edit'])) {
    //echo 'ca va jusqua edit';
    // Vérification back-end du formulaire d'édition
    if (!empty($_POST['ads_title']) && !empty($_POST['ads_content']) && !empty($_POST['price']) && !empty($_POST['city']) && !empty($_POST['address'])) {
        // Définition des variables
        $name = strip_tags($_POST['ads_title']);
        $description = strip_tags($_POST['ads_content']);
        $price = intval(strip_tags($_POST['price']));
        $address = strip_tags($_POST['address']);
        $city = strip_tags($_POST['city']);
        // Assigne la variable user_id à partir du token de session
        $user_id = $_SESSION['id'];
        $id = strip_tags($_POST['ads_id']);
        $image = $_FILES['advert_image'];
        //echo 'ca va jusqua modif';
        modifPlaces($name, $description, $price, $address, $city, $image, $id, $user_id);
    }
} elseif (isset($_POST['place_delete'])) {
    $place = $_POST['ads_id'];
    $user_id = $_SESSION['id'];

    suppPlaces($user_id, $place);
} elseif (isset($_POST['user_edit'])) {
    $username = $_POST['username'];
    editProfile($username, $_SESSION['id']);
} elseif (isset($_POST['book_submit'])) {
    $user_id = $_SESSION['id'];
    $book_id = $_POST['book_id'];
    affichageReservationByUser($book_id, $user_id);
} else {
    echo 'Cannot add the advert';
}

require 'includes/footer.php';
