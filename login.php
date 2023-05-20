<!DOCTYPE>
<html>
    <head>
        <title>Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body style="background-color: #1c294e; user-select: none; h-screen	">
        <div class="flex justify-center items-center h-full">
            <div class="w-1/4 h-2/5">
                <div class="bg-slate-400 h-full w-full rounded-xl p-3 flex items-center">
                    <div class="w-full h-full">
                        <?php
                            if(isset($_POST["submit"])) {
                                $mysql = new mysqli("localhost", "root","","urlshortener");               
                                $isExists = mysqli_query($mysql, "SELECT * FROM users WHERE username='" . $_POST['username'] . "'");

                                if(!mysqli_num_rows($isExists) > 0) {
                                    echo 'username is exists';
                                } else {
                                    $mysql = new mysqli("localhost", "root","","urlshortener");
                                    session_start();
                                    $_SESSION["username"] = $_POST["username"];
                                    $_SESSION["email"] = $_POST["email"];
                                    header("Location: index.php");
                                    exit;
                                }
                            }
                        ?>
                        <div class="text-center font-medium text-xl">
                            Shorten things in your life
                         </div>
                        <div class="mt-4">
                            <div class=" h-full w-full">
                                <form method="POST">
                                    <div class="mx-2 my-3">
                                        <input name="username" type="text" placeholder="Username" max="64" min="3" required class="w-full text-lg outline-none rounded-xl p-2" />
                                    </div>
                                    <div class="mx-2 my-3">
                                        <input name="password" type="password" placeholder="Password" required class="w-full text-lg outline-none rounded-xl p-2" />
                                    </div>
                                    <div class="mx-4 flex justify-center p-2 rounded-xl" style="background-color: #04c484">
                                        <button type="submit" name="submit" class="text-white font-bold text-lg w-full" value="1">Login</button>
                                    </div>
                                </form>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>
