<?php
function fetch_post(){
    require_once "app/models/base.php";
    $db = db_chain();
    $query = $db -> prepare("SELECT * FROM post");
    $query->execute();
    $posts = $query -> fetch();

    return $posts;
}

function add_post(){
    require_once "app/models/user.php";
    session_start();
    $username = $_SESSION["user_info"]["username"];
    $user=fetch_user($username);
    $user_id=$user['id'];
    $filePath="";
    require_once "app/models/base.php";
    $db = db_chain();
    if(isset($_FILES['banner'])){          
        $file=$_FILES['banner'];
        if($file['error']===UPLOAD_ERR_OK){
            $targetDir="stockage/post/";
            $RetargetDir=__DIR__."../../../stockage/post/";
            $RefilePath=$RetargetDir . basename($file['name']);
            $filePath=$targetDir . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $RefilePath);
        }
    }
    if(isset($_POST['content']) && isset($_POST['title'])){
        $slug = create_slug($_POST['title']);
        try{
            if($filePath){
                $query=$db->prepare("INSERT INTO post (title, content, banner, author, slug) VALUES (?,?,?,?,?)");
                $add=$query->execute([$_POST['title'], $_POST['content'], $filePath,9, $slug]);
                
            }else{
                $query=$db->prepare("INSERT INTO post (title,content,author, slug) VALUES (?,?,?,?)");
                $add=$query->execute([$_POST['title'],$_POST['content'],$user_id,$slug]);
                
            }
        }catch(Exception $e){
            echo "Erreur lors de la creation de post".$e." ";
        }
    }
}

function create_slug($title){
    $slug=str_replace(" ", "-", $title);
    return $slug;
}

function fetch_user_post(){
    require_once "app/models/base.php";
    $db = db_chain();
    require_once "app/models/user.php";
    session_start();
    $username = $_SESSION["user_info"]["username"];
    $user=fetch_user($username);
    $user_id=$user['id'];

    $query = $db -> prepare("SELECT * FROM post WHERE author = ?");
    $query->execute(array($user_id));
    $posts = $query->fetchAll();

    return $posts;
}
?>