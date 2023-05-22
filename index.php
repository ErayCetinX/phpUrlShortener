<?php
    session_start();
    $mysql = new mysqli("localhost", "root");
    if($mysql -> connect_errno) {
        echo "has error";
        exit();
    } 
    define("Connected", true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Url Shortener</title>
</head>
<body style="background-color: #1c294e; user-select: none;">
    <header class="flex justify-between p-3">
      <div class="flex items-center">
        <a href="index.php">
            <div class="text-white font-bold text-xl mr-3">
                Shortener
            </div>
        </a>
       <?php
        if(isset($_SESSION["username"])) {
            echo '<a href="links.php">
                <div class="font-medium text-white font-bold text-lg ml-3">My links</div>
            </a>';
        }
       ?>
      </div>
      
    <?php
        if(isset($_SESSION["username"])) {
                echo 
                    '<div class="flex items-center">
                        <a>
                            <div class="p-3 rounded-lg text-white font-bold" type="button">'
                                .$_SESSION["username"].
                            '</div>
                        </a>
                        <form style="margin: 0;" method="POST">
                            <button class="mx-3 font-bold" style="color: #c6303e" type="submit" name="logout">Logout</button>
                        </form>
                        </div>
                    ';
        } else {
            echo '
            <div class="flex items-center">
            <a href="login.php" class="text-white font-bold mr-2">
                <div class="p-3 rounded-lg border-x border-y border-solid border-white" type="button">
                    Login
                </div>
            </a>
            <a href="register.php" class="text-white font-bold ml-2">
                <div class="p-3 rounded-lg border-x border-y border-solid border-white" type="button">
                    Register
                </div>
            </a>
            </div>';
        }
    ?>
    <?php 
        if(array_key_exists('logout', $_POST)) {
            session_destroy();
            header("Location: index.php");
            exit;
        }
      ?>
    </header>
    <div class="h-72 flex items-center justify-center">
        <h1 class="font-bold text-4xl text-white text-center">
            Shorter, more useful links 
        </h1>
    </div>
    <?php  
        $is_Passed = false;
        if(count($_POST) > 0) {
            if(str_word_count($_POST["url"]) > 0) {
                if(!filter_var($_POST['url'],FILTER_VALIDATE_URL)) {
                    $is_Passed = false;
                    echo '<div class="w-52 px-3 py-4 rounded-xl m-auto bg-red-700 ">
                            <p class="w-full text-center font-semibold text-white"> URL not valid</p></div>';
                } else {
                    $is_Passed = true;
                }
            }
        }
    ?>
    <div class="mt-6 flex justify-center items-center bg-00f">
        <form class="w-full flex justify-center" method="POST" enctype="multipart/form">
            <input name="url" placeholder="Enter URL" class="rounded-xl px-2 py-3 w-2/4 text-xl outline-none text-sky-500" />
            <div class="flex justify-center ml-3 bg-blue-800 p-2 rounded-xl text-white font-bold">
                <?php if(isset($_SESSION["username"])) {echo '<input name="submit" type="submit" class="cursor-pointer" value="Kaydet" />';}else {
            echo '<input name="submit" type="submit" class="cursor-pointer" value="Oluştur" />';
        }?>
            </div>
        </form>
    </div>
    <?php
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        if(count($_POST) > 0) {
                if(str_word_count($_POST["url"])>0) {
                    $size = strlen( $chars );
                    $str = substr( str_shuffle( $chars ), 0, 4 );

                    for( $i = 0; $i < 4; $i++ ) {
                        $str .= $chars[ rand( 0, $size - 1 ) ];
                    }

                    if(isset($_POST['submit'])) {
                        $arr = array($str => $_POST["url"]);
                    }
                }
        }
    ?>
    <div>
        <span><?php 
                if (count($_POST) > 0) {
                    if($is_Passed === true) {
                        if(str_word_count($_POST["url"]) > 0) {
                            echo '<div class="flex justify-center items-center mt-3"><span class="flex"><p class="text-white font-xl">Your link is ready</p> <a class="text-sky-500 font-bold" href="'.$_POST['url'].'">https://localhost/'.$str.'</a></span></div>';
                            if(isset($_SESSION["username"])) {
                                $mysql = new mysqli("localhost","root","","urlshortener");
                                mysqli_query($mysql, "insert into links (link, shortedLink, username) values ('".$_POST["url"]."','http://localhost/".$str."','".$_SESSION["username"]."')");
                         header("Location: links.php");       
                         exit;
                            }
                        }
                    }
                }
        ?></span>
    </div>
</body>
</html>
