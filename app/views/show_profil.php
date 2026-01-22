<?php 
if($_SERVER['REQUEST_METHOD']=='POST'){
    require_once "app/models/post.php";
    add_post();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="navigation">
        <h3>PostaFun</h3>
        <nav class="navbar">

            <?php
            require "app/utils/tools.php";
            if (is_authenticated() && $_GET['u']) {
                $user = $_SESSION["user_info"];
                $first_name = $user["first_name"];
                $last_name = $user["last_name"];
                $avatar = $user["avatar"];
                $born_date = $user["born_date"];
                $username = $user["username"];
            }else{
                header("location:/");
            }
            ?>
            <ul>
                <li>
                    <a href="/">Accueil</a>
                </li>
                <li>
                    <a href="/logout">Deconnexion</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="profil-user">
        <div class="profil">
            <div class="profil-avatar">
                <div class="avatar-content">
                    <img src="<?= $avatar ?>" alt="">
                </div>
            </div>
            <div class="profil-details">
                <p class="profil-username">@<?= $username ?></p>
                <ul>
                    <li><span class="detail-name">Nom : </span><?= $first_name ?></li>
                    <li><span class="detail-name">Prénom : </span><?= $last_name ?></li>
                    <li><span class="detail-name">Date de naissance : </span><?= $born_date ?></li>
                </ul>
            </div>
        </div>
        <div class="post-creation">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="field">
                    <input type="text" name="title" placeholder="Titre du post">
                    <textarea name="content" id="content" placeholder="Contenu du post"></textarea>
                </div>
                <div class="validation">
                    <label for="banner">Ajouter une image</label>
                    <input type="file" name="banner" id="banner" accept="image/*">
                    <input type="submit" value="Poster">
                </div>
            </form>
        </div>
    </div>
    <div class="user-post">
        <?php
            require_once "app/models/post.php";
            $posts = fetch_user_post();
        ?>
        <div class="posts">
            <?php foreach($posts as $post):?>
                <div class="post-item">
                    <div class="post-header">
                        <div class="post-user-avatar">
                            <img src="<?= $avatar ?>" alt="">
                        </div>
                        <div class="post-user">
                            <h5><?= $username ?></h5>
                            <span><?= $post['created_at'] ?></span>
                        </div>
                    </div>
                    <h4><?= $post['title'] ?></h2>
                    <p><?= $post['content'] ?></p>
                    <?php if($post['banner']):?>
                        <img src="<?= $post['banner'] ?>" class="post-banner" alt="">
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</body>
</html>