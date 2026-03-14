<?php
require_once 'db.php';

$zoek = "";

try {

    if(isset($_GET['zoek']) && $_GET['zoek'] != ""){

        $zoek = "%" . $_GET['zoek'] . "%";

        $sql = "SELECT * FROM boeken
                WHERE titel LIKE :zoek
                OR auteur LIKE :zoek";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['zoek' => $zoek]);

    } else {

        $sql = "SELECT * FROM boeken";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    $boeken = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Fout: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Bibliotheek</title>
</head>
<body>

<h2>Zoek boeken</h2>

<form method="GET">
<input type="text" name="zoek">
<button type="submit">Zoeken</button>
</form>

<h1>Alle boeken</h1>

<p><a href="add_book.php">Boek toevoegen</a></p>

<table border="1">
<tr>
    <th>ID</th>
    <th>Titel</th>
    <th>Auteur</th>
    <th>Genre</th>
    <th>Publicatiejaar</th>
</tr>

<?php
if(!empty($boeken)){

    foreach($boeken as $boek){

        echo "<tr>";
        echo "<td>".$boek['id']."</td>";
        echo "<td>".$boek['titel']."</td>";
        echo "<td>".$boek['auteur']."</td>";
        echo "<td>".$boek['genre']."</td>";
        echo "<td>".$boek['publicatiejaar']."</td>";
        echo "</tr>";
    }

}else{
    echo "<tr><td colspan='5'>Geen boeken gevonden</td></tr>";
}
?>

</table>

</body>
</html>