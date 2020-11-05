<?php
//require 'includes/config.php';
require 'includes/header.php';
var_dump($_SESSION);

if (isset($_POST['submit_signup']) && !empty($_POST['email_signup']) && !empty($_POST['password1_signup'])) {
    $email = htmlspecialchars($_POST['email_signup']);
    $username = htmlspecialchars($_POST['username_signup']);
    $password1 = htmlspecialchars($_POST['password1_signup']);
    $password2 = htmlspecialchars($_POST['password2_signup']);

    if (inscription($email, $username, $password1, $password2)) {
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
                    <label class="label">Fullname</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input " type="username" placeholder="Choose a username" value=""
                            name="username_signup">
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
