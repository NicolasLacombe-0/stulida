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

function affichageProduits()
{
    global $conn;
    $sth = $conn->prepare('SELECT p.*,u.username FROM adverts AS p LEFT JOIN users AS u ON p.user_id = u.id');
    $sth->execute();

    $ads = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ads as $product) {
        ?>
<tr>
    <th scope="row"><?php echo $product['ads_id']; ?>
    </th>
    <td><?php echo $product['ads_title']; ?>
    </td>
    <td><?php echo $product['ads_content']; ?>
    </td>
    <td><?php echo $product['address']; ?>
    </td>
    <td><?php echo $product['city']; ?>
    </td>
    <td><?php echo $product['price']; ?> €
    </td>
    <td><?php echo $product['username']; ?>
    </td>
    <td> <a
            href="product.php?id=<?php echo $product['ads_id']; ?>">Afficher
            article</a>
    </td>
</tr>
<?php
    }
}

function affichageProduitsByUser($user_id)
{
    global $conn;
    $sth = $conn->prepare("SELECT p.* FROM adverts AS p WHERE p.user_id = {$user_id}");
    $sth->execute();

    $ads = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ads as $product) {
        ?>
<tr>
    <th scope="row"><?php echo $product['ads_id']; ?>
    </th>
    <td><?php echo $product['ads_title']; ?>
    </td>
    <td><?php echo $product['ads_content']; ?>
    </td>
    <td><?php echo $product['address']; ?> €
    </td>
    <td><?php echo $product['city']; ?>
    </td>
    <td><?php echo $product['price']; ?> €
    </td>
    <td> <a href="product.php?id=<?php echo $product['ads_id']; ?>"
            class="button is-success">Display</a>
    </td>
    <td> <a href="editads.php?id=<?php echo $product['ads_id']; ?>"
            class="button is-warning">Edit</a>
    </td>
    <td>
        <form action="process.php" method="post">
            <input type="hidden" name="product_id"
                value="<?php echo $product['ads_id']; ?>">
            <input type="submit" name="product_delete" class="button is-danger" value="Delete" />
        </form>
    </td>
</tr>
<?php
    }
}

function affichageProduit($id)
{
    global $conn;
    $sth = $conn->prepare("SELECT p.*,u.username FROM adverts AS p LEFT JOIN users AS u ON p.user_id = u.id WHERE p.ads_id = {$id}");
    $sth->execute();

    $product = $sth->fetch(PDO::FETCH_ASSOC); ?>
<div class="row">
    <div class="col-12">
        <h1><?php echo $product['ads_title']; ?>
        </h1>
        <p><?php echo $product['ads_content']; ?>
        </p>
        <p><?php echo $product['address']; ?>
        </p>
        <p><?php echo $product['city']; ?>
        </p>
        <button class="btn btn-danger"><?php echo $product['price']; ?> € </button>
    </div>
</div>
<?php
}

function ajoutProduits($name, $ads_content, $price, $address, $city, $user_id)
{
    global $conn;
    // Vérification du prix (doit être un entier, et inférieur à 1 million d'euros)
    if (is_int($price) && $price > 0 && $price < 1000000) {
        // Utilisation du try/catch pour capturer les erreurs PDO/SQL
        try {
            // Création de la requête avec tous les champs du formulaire
            $sth = $conn->prepare('INSERT INTO adverts (ads_title,ads_content,price,address,city,user_id) VALUES (:ads_title, :ads_content, :price, :address, :city, :user_id)');
            $sth->bindValue(':ads_title', $name, PDO::PARAM_STR);
            $sth->bindValue(':ads_content', $ads_content, PDO::PARAM_STR);
            $sth->bindValue(':price', $price, PDO::PARAM_INT);
            $sth->bindValue(':address', $address, PDO::PARAM_STR);
            $sth->bindValue(':city', $city, PDO::PARAM_STR);
            $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            // Affichage conditionnel du message de réussite
            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Your advert was successfully added to the database </div>";
                header('Location: product.php?id='.$conn->lastInsertId());
            }
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
        }
    }
}

function modifProduits($name, $ads_content, $price, $address, $city, $id, $user_id)
{
    global $conn;
    if (is_int($price) && $price > 0 && $price < 1000000) {
        try {
            $sth = $conn->prepare('UPDATE adverts SET ads_title=:ads_title, ads_content=:ads_content, price=:price,address=:address,city=:city WHERE ads_id=:ads_id AND user_id=:user_id');
            $sth->bindValue(':ads_title', $name);
            $sth->bindValue(':ads_content', $ads_content);
            $sth->bindValue(':price', $price);
            $sth->bindValue(':address', $address);
            $sth->bindValue(':city', $city);
            $sth->bindValue(':ads_id', $id);
            $sth->bindValue(':user_id', $user_id);
            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Successfully modified </div>";
                header("Location: product.php?id={$id}");
            }
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
        }
    }
}
