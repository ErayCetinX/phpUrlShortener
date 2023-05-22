<?php
    session_start();
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Links</title>
    </head>
<body style="background-color: #1c294c; user-select: none;">
<header class="flex justify-between p-3 items-center">
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
    <div class="ml-5">
        <span class="text-white font-bold text-xl">
            <?php echo $_SESSION["username"]."'s links"; ?>
        </span>
        <table class="table-auto mt-5">
            <thead>
                <tr class="flex justify-between items-center">
                <th class="text-White font-bold text-xl">Links</th>
                <th class="text-White font-bold text-xl">Shorted Link</th>
                </tr>
            </thead>
            <tbody>
                     <?php 
                $mysql = new mysqli("localhost","root","","urlshortener");
                $result = mysqli_query($mysql,"select * from links where username='".$_SESSION["username"]."'");
                while($row = mysqli_fetch_array($result))
                    {

                        echo "<tr class='flex justify-between items-center'><td class='text-white text-lg font-medium mr-3'>".$row['link']."</td><td><a href='".$row["link"]."' target='_blank' style='color:#0d6efd' class='font-medium text-lg'>".$row['shortedLink']."</a></td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div> 
</body>
</html>
