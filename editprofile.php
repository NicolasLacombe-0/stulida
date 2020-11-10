<?php
$title = 'Editing Profile - Stuliday';
require 'includes/header.php';
?>

<div class="container">
    <div class="columns" style="margin: 5% 0%">
        <div class="column">
        </div>
        <div class="column is-one-half">
            <form action="process.php" method="post">

                <div class="field ">
                    <label class="label">Change username :</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input"
                            value="<?php echo $_SESSION['username']; ?>"
                            type="username" placeholder="Choose a username" value="" name="username">
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
                        <input type="submit" value="Confirm changes" name="user_edit" class="button is-primary">
                    </div>
                </div>
            </form>
        </div>
        <div class="column">
        </div>
    </div>
    <?php
require 'includes/footer.php';
