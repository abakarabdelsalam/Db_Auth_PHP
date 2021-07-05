<?php
$pdo = require_once './database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = filter_input_array(INPUT_POST, [
        'email' => FILTER_SANITIZE_EMAIL,
    ]);
    $password = $_POST['password'] ?? '';
    $email = $input['email'] ?? '';
    if (!$password || !$email) {
        $error = 'ERROR';
    } else {
        $statementUser = $pdo->prepare('SELECT * FROM user WHERE email = ?');
        $statementUser->execute([$email]);
        $user = $statementUser->fetch();
        if (password_verify($password, $user['password'])) {
            $statementSession = $pdo->prepare('INSERT INTO session VALUES(DEFAULT, :userid)');
            $statementSession->bindValue(':userid', $user['id']);
            $statementSession->execute();
            $sessionId = $pdo->lastInsertId();
            setcookie('session', $sessionId, time() + 60 * 60 * 24 * 14, "", "", false, true);
            header('Location: profile.php');
        } else {
            $error = 'Identifiants invalides';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <title>Auth_PHP</title>
</head>

<body>
    <div class="text-center">
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
            <div class="container-fluid">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                        <li class="nav-item text-">
                            <a class="nav-link active " aria-current="page" href="login.php">Login</a>
                        </li>

                    </ul>

                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                        <li class="nav-item">
                            <a class="nav-link active " aria-current="page" href="logout.php">logout</a>
                        </li>

                    </ul>

                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                        <li class="nav-item">
                            <a class="nav-link active " aria-current="page" href="profile.php">profile</a>
                        </li>

                    </ul>

                </div>
                <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                        <li class="nav-item">
                            <a class="nav-link active " aria-current="page" href="register.php">register</a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav><br><br><br>
        <h1>Connexion</h1>

        <form action="./login.php" method="post">
            <input type="text" name="email" placeholder="email"><br><br>
            <input type="text" name="password" placeholder="password"><br><br>
            <?php if ($error) : ?>
            <h1 style="color:red;"><?= $error ?></h1>
            <?php endif; ?>
            <button type="submit">Connexion</button>
        </form>
    </div>

</body>

</html>