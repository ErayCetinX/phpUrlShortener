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
                <input name="submit" type="submit" class="cursor-pointer" />
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
                        }
                    }
                }
        ?></span>
    </div>
</body>
</html>