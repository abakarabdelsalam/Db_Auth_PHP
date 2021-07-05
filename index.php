<pre>
<?php
$dsn = "mysql:host=localhost;dbname=test1";
$user = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);


    echo "connexion Ok";
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

// inserssion à la base de

// $setval = $dbh->prepare(
//     "INSERT INTO users VALUES 
//   (DEFAULT, 'siloo', 'smith', 'siloo@smith.fr', '123')"
// );
// $setval->execute();


// récuperation de données

$setval = $dbh->prepare("SELECT * FROM users");
$setval->execute();
$results = $setval->fetchAll();

print_r($results);

?>
    <h1><script src="https://gist.github.com/abakarabdelsalam/1b76b18bbc7856b1a1e964dc0a3f2501.js"></script></h1>