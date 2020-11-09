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

function affichagePlaces()
{
    global $conn;
    $sth = $conn->prepare('SELECT * FROM adverts');
    $sth->execute();

    $adverts = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($adverts as $advert) {?>

<div class="column is-one-quarter is-offset-1" style='margin-top:6%; margin-left:0%'>
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
<?php
    }
}

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
    <td><?php echo $place['address']; ?> €
    </td>
    <td><?php echo $place['city']; ?>
    </td>
    <td><?php echo $place['price']; ?> €
    </td>
    <td> <a href="advert.php?id=<?php echo $place['ads_id']; ?>"
            class="btn btn-success">Display</a>
    </td>
    <td> <a href="editadverts.php?id=<?php echo $place['ads_id']; ?>"
            class="btn btn-warning">Edit</a>
    </td>
    <td>
        <form action="process.php" method="post">
            <input type="hidden" name="ads_id"
                value="<?php echo $place['ads_id']; ?>">
            <input type="submit" name="place_delete" class="btn btn-danger" value="Delete" />
        </form>
    </td>
</tr>
<?php
    }
}

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
    <!-- <div class="column is-one-fifth"></div> -->
    <div class="column is-one-third has-text-centered">
        <p>
            <?php echo $advert['ads_content']; ?>
        </p>

    </div>
    <div class="column is-one-fifth has-text-right">
        <p>
            <?php echo $advert['address']; ?>
        </p>
        <p>
            <?php echo $advert['city']; ?>
        </p>
        <p class="btn btn-danger"><?php echo $advert['price'].' €'; ?>
        </p>
        <p>
            <?php echo "<img src='./images/".$advert['images']."'; alt='advert image'>"; ?>
        </p>
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
            $sth->bindValue(':images', $images, PDO::PARAM_STR);
            $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            echo 'on est dans le try  ';
            // Affichage conditionnel du message de réussite

            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Your advert was successfully added to the database </div>";
                header('Location: advert.php?id='.$conn->lastInsertId());
            }

            if (isset($_FILES['advert_images'])) {
                $file = $_FILES['advert_images'];
                if ($file['size'] <= 1000000) {
                    $valid_ext = ['jpg', 'jpeg', 'gif', 'png'];
                    $check_ext = strtolower(substr(strrchr($file['name'], '.'), 1));
                    if (in_array($check_ext, $valid_ext)) {
                        $dbname = uniqid().'_'.$file['name'];
                        $upload_dir = 'imgupload/';
                        $upload_name = $upload_dir.$dbname;
                        $move_result = move_uploaded_file($file['tmp_name'], $upload_name);
                        $img = $dbname;
                        echo '<div class="alert alert-success mt-2" role="alert" > You have Succesfully Upload your Image !</div>';
                    } else {
                        // TEMP SPEECH FIND BETTER !!!
                        $img = '';
                        echo '<div class="alert alert-success mt-2" role="alert" > Upload Image Fail, please check the extension / size !</div>';
                    }
                }
            }
            $sth->bindValue(':images', $img, PDO::PARAM_STR);

            //ajout d'image au fichier images
            if (!empty($_POST['advert_image'])) {
                $target_dir = 'images/';
                $target_file = $target_dir.basename($_FILES['advert_image']['name']);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image

                if (isset($_POST['advert_submit'])) {
                    $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
                    if (false !== $check) {
                        echo 'File is an image - '.$check['mime'].'.';
                        $uploadOk = 1;
                    } else {
                        echo 'File is not an image.';
                        $uploadOk = 0;
                    }
                }
            }
            if (isset($_FILES['advert_image'])) {
                var_dump($_FILES['advert_image']);
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
            $sth->bindValue(':images', $images);
            $sth->bindValue(':ads_id', $id);
            $sth->bindValue(':user_id', $user_id);
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
