<?php

require 'includes/header.php';
require 'includes/navbar.php';

$title = 'Processing -Le Chouette coin';

if ('POST' != $_SERVER['REQUEST_METHOD']) {
    echo "<div class='alert alert-danger'>ERROR La page à laquelle vous tentez d'accéder n'existe pas</div>";
} elseif (isset($_POST['advert_submit'])) {
    if (!empty($_POST['advert_title']) && !empty($_POST['advert_content']) && !empty($_POST['advert_price']) && !empty($_POST['advert_city']) && !empty($_POST['advert_address']) && !empty($_POST['advert_category'])) {

        $title = strip_tags($_POST['advert_title']);
        $content = strip_tags($_POST['advert_content']);
        $price = intval(strip_tags($_POST['advert_price']));
        $address = strip_tags($_POST['advert_address']);
        $city = strip_tags($_POST['advert_city']);
        $category = strip_tags($_POST['advert_category']);
        $user_id = $_SESSION['id'];
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
        ajoutAdvert($title, $content, $price, $address ,$city, $category, $user_id);
    }
}

require 'includes/footer.php';