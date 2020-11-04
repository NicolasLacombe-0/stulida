<?php
//require 'includes/config.php';
require 'includes/header.php';
require 'includes/navbar.php';
var_dump($_SESSION);
// if (!empty($_POST['submit_signup']) && !empty($_POST['email_signup']) && !empty($_POST['password_signup'])) {
//     $email_su = htmlspecialchars($_POST['email_signup']);
//     $pass_su = htmlspecialchars($_POST['password_signup']);
//     $repass_su = htmlspecialchars($_POST['password1_signup']);
//     $sql = "SELECT * FROM users WHERE email = '{$email_su}'";
//     $res = $conn->query($sql);
//     if (!($count = $res->fetchColumn())) {
//         if ($pass_su === $repass_su) {
//             try {
//                 $pass_su = password_hash($pass_su, PASSWORD_DEFAULT);
//                 $sth = $conn->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
//                 $sth->bindValue('email', $email_su);
//                 $sth->bindValue('password', $pass_su);
//                 $sth->execute();
//                 echo '<div class="notification is-primary">Utilisateur bien enregistré !</div>';
//             } catch (PDOException $e) {
//                 echo 'Error'.$e->getMessage();
//             }
//         } else {
//             echo 'Not the same password';
//         }
//     } elseif ($count > 0) {
//         //var_dump($count);
//         echo '<div class="notification is-primary">email already used</div>';
//     }
// }
// //else {
// //     echo'<div class="notification is-primary">Merci de remplir tous les champs</div>';
// // }
// if (isset($_POST['submit_login']) && !empty($_POST['email_login']) && !empty($_POST['password_login'])) {
//     $email_login = htmlspecialchars($_POST['email_login']);
//     $pass_login = htmlspecialchars($_POST['password_login']);

//     $sql = "SELECT * FROM users WHERE email = '{$email_login}'";
//     $res = $conn->query($sql);
//     $user = $res->fetch(PDO::FETCH_ASSOC);
//     if ($user) {
//         $db_pass = $user['password'];
//         if (password_verify($pass_login, $db_pass)) {
//             $_SESSION['email'] = $user['email'];
//             $_SESSION['id'] = $user['id'];
//             header('Location:index.php');
//         } else {
//             echo '<div class="notification delete">Invalid Password</div>';
//         }
//     } else {
//         echo 'User does not exist';
//     }
// }

//======================================================================

if (isset($_POST['submit_signup']) && !empty($_POST['email_signup']) && !empty($_POST['password1_signup'])) {
    $email = htmlspecialchars($_POST['email_signup']);
    $password1 = htmlspecialchars($_POST['password1_signup']);
    $password2 = htmlspecialchars($_POST['password2_signup']);

    if (inscription($email, $password1, $password2)) {
        echo 'Votre compte a bien été créé !';
    }
} elseif (isset($_POST['submit_login']) && !empty($_POST['email_login']) && !empty($_POST['password_login'])) {
    $email_login = strip_tags($_POST['email_login']);
    $password_login = strip_tags($_POST['password_login']);

    login($email_login, $password_login);
} elseif (isset($_POST)) {
    unset($_POST);
}
?>





<div class="container">
    <div class="columns">
        <div class="column">

            <form action="signin.php" method="post">
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="email" placeholder="Email input" value="" name="email_signup">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input " type="password" placeholder="Choose a password" value=""
                            name="password1_signup">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Password Verification</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="password" placeholder="Re-enter your password" value=""
                            name="password2_signup">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox">
                            I agree to the <a href="#">terms and conditions</a>
                        </label>
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <input type="submit" value="Sign up !" name="submit_signup" class="button is-primary">
                    </div>
                </div>
            </form>
        </div>





        <div class="column">
            <form action="signin.php" method="post">
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="email" placeholder="Email input" value="" name="email_login">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input " type="password" placeholder="Choose a password" value=""
                            name="password_login">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <input type="submit" value="Login" name="submit_login" class="button is-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require 'includes/footer.php';
