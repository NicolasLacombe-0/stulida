<?php

require 'includes/config.php';


function inscription($email, $password1, $password2)
{
    global $conn;

    try {
        $sql1 = "SELECT * FROM users WHERE email = '{$email}'";
    
        $res1 = $conn->query($sql1);
        $count_email = $res1->fetchColumn();
        if (!$count_email) {
            if ($password1 === $password2) {
                $password = password_hash($password1, PASSWORD_DEFAULT);
                $sth = $conn->prepare('INSERT INTO users (email,password) VALUES (:email,:password)');
                $sth->bindValue(':email', $email);
                $sth->bindValue(':password', $password);
                $sth->execute();
                echo '<div class="alert alert-success mt-2">Votre compte a été enregistré, vous pouvez maintenant vous connecter !</div>';
            } else {
                echo 'Les mots de passe ne concordent pas.';
            }
            
        } elseif ($count_email > 0) {
            echo 'Cette adresse mail est déjà utilisée';
        }
    } catch (PDOException $e) {
        echo'Error'.$e->getMessage();
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


function affichageAdverts()
{
    global $conn;
    $sth = $conn->prepare('SELECT p.*,c.categories_name,u.username FROM adverts AS p LEFT JOIN categories AS c ON p.category_id = c.categories_id LEFT JOIN users AS u ON p.user_id = u.id');
    $sth->execute();

    $products = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        ?>
<tr>
    <th scope="row"><?php echo $product['products_id']; ?>
    </th>
    <td><?php echo $product['products_name']; ?>
    </td>
    <td><?php echo $product['content']; ?>
    </td>
    <td><?php echo $product['price']; ?>
    </td>
    <td><?php echo $product['city']; ?>
    </td>
    <td><?php echo $product['categories_name']; ?>
    </td>
    <td><?php echo $product['username']; ?>
    </td>
    <td> 
        <a href="product.php?id=<?php echo $product['products_id']; ?>">Afficher article</a>
    </td>
</tr>
<?php
    }
}

// FONCTION AFFICHAGE D'UN PRODUIT
function affichageAdvert($id)
{
    global $conn;
    $sth = $conn->prepare("SELECT a.*,c.categories_name,u.email FROM adverts AS a LEFT JOIN categories AS c ON a.category_id = c.categories_id LEFT JOIN users AS u ON a.author = u.id WHERE p.products_id = {$id}");
    $sth->execute();
    $advert = $sth->fetch(PDO::FETCH_ASSOC);
    ?>
<div class="row">
    <div class="col-12">
        <h1><?php echo $advert['title']; ?>
        </h1>
        <p><?php echo $advert['content']; ?>
        </p>
        <p><?php echo $advert['address']; ?>
        </p>
        <p><?php echo $advert['city']; ?>
        </p>
        <button class="btn btn-info"><?php echo $advert['price']; ?> € </button>
    </div>
</div>
<?php
}


function ajoutAdvert($title,$content,$price,$address,$city,$category,$user_id)
{
    global $conn;
    // Vérification du prix (doit être un entier, et inférieur à 1 million d'euros)
    if (is_int($price) && $price > 0 && $price < 1000000) {
        // Utilisation du try/catch pour capturer les erreurs PDO/SQL
        try {
            // Création de la requête avec tous les champs du formulaire
            $sth = $conn->prepare('INSERT INTO products (title,content,price,address,city,category_id,user_id) VALUES (:title, :content, :price, :address, :city, :category_id, :user_id)');
            $sth->bindValue(':title', $title, PDO::PARAM_STR);
            $sth->bindValue(':content', $content, PDO::PARAM_STR);
            $sth->bindValue(':price', $price, PDO::PARAM_INT);
            $sth->bindValue(':address', $address, PDO::PARAM_STR);
            $sth->bindValue(':city', $city, PDO::PARAM_STR);
            $sth->bindValue(':category_id', $category, PDO::PARAM_INT);
            $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            // Affichage conditionnel du message de réussite
            if ($sth->execute()) {
                echo "<div class='alert alert-success'> Votre article a été ajouté à la base de données </div>";
                header('Location: advert.php?id='.$conn->lastInsertId());
            }
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
        }
    }
}
