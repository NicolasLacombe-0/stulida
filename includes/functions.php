<?php

require 'includes/config.php';

function inscription($email, $username, $password1, $password2)
{
    global $conn;

    try {
        $sql1 = "SELECT * FROM users WHERE email = '{$email}'";
        $sql2 = "SELECT * FROM users WHERE username = '{$username}'";
        $res1 = $conn->query($sql1);
        $count_email = $res1->fetchColumn();
        if (!$count_email) {
            $res2 = $conn->query($sql2);
            $count_user = $res2->fetchColumn();
            if (!$count_user) {
                if ($password1 === $password2) {
                    $password1 = password_hash($password1, PASSWORD_DEFAULT);
                    $sth = $conn->prepare('INSERT INTO users (email,username, password) VALUES (:email,:username,:password)');
                    $sth->bindValue(':email', $email);
                    $sth->bindValue(':username', $username);
                    $sth->bindValue(':password', $password1);
                    $sth->execute();
                    echo "<div class='alert alert-success mt-2'> L'utilisateur a bien été enregistré, vous pouvez désormais vous connecter</div>";
                } else {
                    echo 'Les mots de passe ne concordent pas !';
                    unset($_POST);
                }
            } elseif ($count_user > 0) {
                echo "Ce nom d'utilisateur est déja pris !";
                unset($_POST);
            }
        } elseif ($count_email > 0) {
            echo 'Cette adresse mail existe déja !';
            unset($_POST);
        }
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }
}

function login($email_login, $password_login)
{
    global $conn;

    try {
        $sql = "SELECT * FROM users WHERE email = '{$email_login}'";
        $res = $conn->query($sql);
        $user = $res->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $db_password = $user['password'];
            if (password_verify($password_login, $db_password)) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                //echo 'Bienvenue, '.$_SESSION['username'].' !';
                header('Location: index.php');
            } else {
                echo '<div>Mot de passe incorrecte</div>';
                unset($_POST);
            }
        } else {
            echo 'Email incorrecte';
            unset($_POST);
        }
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }
}

function editProfile($username, $id)
{
    global $conn;

    try {
        $sth = $conn->prepare('UPDATE users SET username=:username WHERE id=:id');
        $sth->bindValue(':username', $username);
        $sth->bindValue(':id', $id);

        if ($sth->execute()) {
            header('Location: profile.php?p');
            echo '<div class="has-text-success"> Successfully changed your username </div>';
        }
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }
}

//affichage des annonces dans Places to Stay
function affichagePlaces()
{
    global $conn;
    $sth = $conn->prepare('SELECT * FROM adverts');
    $sth->execute();

    $adverts = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($adverts as $advert) {?>

<div class="column is-one-quarter is-offset-1" style='margin-top:6%; margin-left:0%'>
    <div class="box">
        <div class="box"
            style="background-image: url(<?php echo './images/'.$advert['images']; ?>); background-size:cover; height:25vh">
        </div>
        <h4 class="title is-5 is-spaced">
            <?php echo $advert['ads_title']; ?>
        </h4>
        <p>
            <?php echo $advert['ads_content']; ?>
        </p>
        <p>
            <?php echo $advert['city']; ?>
        </p>
        <a class="button is-outlined is-danger" style="margin:5%"
            href="advert.php?id=<?php echo $advert['ads_id']; ?>">View
            place</a>
    </div>
</div>
<?php
    }
}

//affichage des annonces dans la page de profil
function affichagePlacesByUser($id)
{
    global $conn;
    $sth = $conn->prepare("SELECT * FROM adverts INNER JOIN users ON users.id = adverts.user_id WHERE user_id = {$id}");
    $sth->execute();
    $ads = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ads as $place) {
        ?>
<tr>
    <th scope="row"><?php echo $place['ads_id']; ?>
    </th>
    <td><?php echo $place['ads_title']; ?>
    </td>
    <td><?php echo $place['ads_content']; ?>
    </td>
    <td><?php echo $place['address']; ?>
    </td>
    <td><?php echo $place['city']; ?>
    </td>
    <td><?php echo $place['price']; ?>€
    </td>
    <td> <a href="advert.php?id=<?php echo $place['ads_id']; ?>"
            class="button is-success is-outlined">Display</a>
    </td>
    <td> <a href="editadverts.php?id=<?php echo $place['ads_id']; ?>"
            class="button is-warning is-outlined">Edit</a>
    </td>
    <td>
        <form action="process.php" method="post">
            <input type="hidden" name="ads_id"
                value="<?php echo $place['ads_id']; ?>">
            <input type="submit" name="place_delete" class="button is-danger is-outlined" value="Delete" />
        </form>
    </td>
</tr>
<?php
    }
}

// display de chaque annonce indépendamment
function affichagePlace($id)
{
    global $conn;
    $sth = $conn->prepare("SELECT * FROM adverts WHERE ads_id={$id}");
    $sth->execute();

    $advert = $sth->fetch(PDO::FETCH_ASSOC); ?>

<h1 class="title is-4 is-spaced has-text-centered" style="margin-top:3%">
    <?php echo $advert['ads_title']; ?>
</h1>
<div class="columns">
    <div class="column is-one-third offset-1"></div>
    <div class="column is-one-third">
        <p>
            <?php echo "<img src='./images/".$advert['images']."'; alt='advert image'>"; ?>
        </p>
    </div>
</div>
<div class="columns">
    <!-- <div class="column is-one-fifth"></div> -->
    <div class="column is-one-fifth offset-1"></div>

    <div class="column is-one-third has-text-centered ">
        <p>
            <?php echo $advert['ads_content']; ?>
        </p>

    </div>
    <div class="column is-one-fifth has-text-left ">
        <div class="box">
            <?php echo $advert['address']; ?>
            </p>
            <p style="margin:5% 0%">
                <?php echo $advert['city']; ?>
            </p>
            <p class="button is-danger"><?php echo $advert['price'].' €'; ?>
            </p>
        </div>
        <p>
    </div>
</div>


<?php
}

function ajoutProduits($name, $ads_content, $price, $address, $city, $images, $user_id)
{
    global $conn;
    // Vérification du prix (doit être un entier, et inférieur à 1 million d'euros)
    if (is_int($price) && $price > 0 && $price < 1000000) {
        // Utilisation du try/catch pour capturer les erreurs PDO/SQL
        try {
            // Création de la requête avec tous les champs du formulaire
            $sth = $conn->prepare('INSERT INTO adverts (ads_title,ads_content,address,city,price,images,user_id) VALUES (:ads_title, :ads_content, :address, :city, :price, :images, :user_id)');
            $sth->bindValue(':ads_title', $name, PDO::PARAM_STR);
            $sth->bindValue(':ads_content', $ads_content, PDO::PARAM_STR);
            $sth->bindValue(':price', $price, PDO::PARAM_INT);
            $sth->bindValue(':address', $address, PDO::PARAM_STR);
            $sth->bindValue(':city', $city, PDO::PARAM_STR);
            $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            //echo 'on est dans le try  ';
            // Affichage conditionnel du message de réussite

            //upload image
            if (!empty($images)) {
                if ($images['size'] <= 1000000) {
                    $valid_ext = ['jpg', 'jpeg', 'gif', 'png'];
                    $check_ext = strtolower(substr(strrchr($images['name'], '.'), 1));
                    if (in_array($check_ext, $valid_ext)) {
                        $dbname = uniqid().'_'.$images['name'];
                        $upload_dir = 'images/';
                        $upload_name = $upload_dir.$dbname;
                        $move_result = move_uploaded_file($images['tmp_name'], $upload_name);
                        $images = $dbname;
                        echo '<div class="alert alert-success mt-2" role="alert" > You have Successfully Uploaded your Image !</div>';
                    } else {
                        // TEMP SPEECH FIND BETTER !!!
                        $images = '';
                        echo '<div class="alert alert-success mt-2" role="alert" > Image Upload Failed, please check the extension / size !</div>';
                    }
                }
            }

            $sth->bindValue(':images', $images, PDO::PARAM_STR);

            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Your advert was successfully added to the database </div>";
                header('Location: advert.php?id='.$conn->lastInsertId());
            }
        } catch (PDOException $e) {
            echo 'on est dans le catch   ';
            echo 'Error: '.$e->getMessage();
        }
    }
}

function modifPlaces($name, $ads_content, $price, $address, $city, $images, $id, $user_id)
{
    global $conn;
    if (is_int($price) && $price > 0 && $price < 1000000) {
        try {
            $sth = $conn->prepare('UPDATE adverts SET ads_title=:ads_title, ads_content=:ads_content, price=:price,address=:address,city=:city,images=:images WHERE ads_id=:ads_id AND user_id=:user_id');
            $sth->bindValue(':ads_title', $name);
            $sth->bindValue(':ads_content', $ads_content);
            $sth->bindValue(':price', $price);
            $sth->bindValue(':address', $address);
            $sth->bindValue(':city', $city);
            $sth->bindValue(':ads_id', $id);
            $sth->bindValue(':user_id', $user_id);

            if (!empty($images)) {
                if ($images['size'] <= 1000000) {
                    $valid_ext = ['jpg', 'jpeg', 'gif', 'png'];
                    $check_ext = strtolower(substr(strrchr($images['name'], '.'), 1));
                    if (in_array($check_ext, $valid_ext)) {
                        $dbname = uniqid().'_'.$images['name'];
                        $upload_dir = 'images/';
                        $upload_name = $upload_dir.$dbname;
                        $move_result = move_uploaded_file($images['tmp_name'], $upload_name);
                        $images = $dbname;
                        echo '<div class="alert alert-success mt-2" role="alert" > You have Successfully Uploaded your Image !</div>';
                    } else {
                        // TEMP SPEECH FIND BETTER !!!
                        $images = '';
                        echo '<div class="alert alert-success mt-2" role="alert" > Image Upload Failed, please check the extension / size !</div>';
                    }
                }
            }

            $sth->bindValue(':images', $images, PDO::PARAM_STR);

            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Successfully modified </div>";
                header("Location: advert.php?id={$id}");
            }
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
        }
    }
}

function suppPlaces($user_id, $place_id)
{
    // Récupération de la connexion à la BDD à partir de l'espace global.
    global $conn;

    // Tentative de la requête de suppression.
    try {
        $sth = $conn->prepare('DELETE FROM adverts WHERE ads_id = :ads_id AND user_id =:user_id');
        $sth->bindValue(':ads_id', $place_id);
        $sth->bindValue(':user_id', $user_id);
        if ($sth->execute()) {
            header('Location: profile.php?s');
        }
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }
}

function affichageReservationByUser($book_id, $user_id)
{
    global $conn;
    $book_name = 'reservation n°'.random_int(1, 1000000);

    try {
        $sth = $conn->prepare('INSERT INTO reservations (bookname,book_client,book_advert_fk) VALUES (:bookname,:book_client,:book_advert_fk)');
        $sth->bindValue(':bookname', $book_name);
        $sth->bindValue(':book_client', $user_id);
        $sth->bindValue(':book_advert_fk', $book_id);
        if ($sth->execute()) {
            header('Location: reservations.php');
        }
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }
}
