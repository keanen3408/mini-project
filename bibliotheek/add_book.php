<?php
require_once 'db.php';

$fouten = [];

if(isset($_POST['submit'])){

    $titel = trim($_POST['titel']);
    $auteur = trim($_POST['auteur']);
    $genre = trim($_POST['genre']);
    $jaar = $_POST['publicatiejaar'];

    // Validatie
    if(empty($titel)){
        $fouten[] = "Titel is verplicht.";
    }

    if(empty($auteur)){
        $fouten[] = "Auteur is verplicht.";
    }

    if(empty($genre)){
        $fouten[] = "Genre is verplicht.";
    }

    if(empty($jaar)){
        $fouten[] = "Publicatiejaar is verplicht.";
    } elseif($jaar < 1000 || $jaar > date("Y")){
        $fouten[] = "Voer een geldig publicatiejaar in.";
    }

    // Alleen opslaan als er geen fouten zijn
    if(empty($fouten)){

        $sql = "INSERT INTO boeken (titel, auteur, genre, publicatiejaar)
                VALUES (:titel, :auteur, :genre, :jaar)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':titel' => $titel,
            ':auteur' => $auteur,
            ':genre' => $genre,
            ':jaar' => $jaar
        ]);

        echo "<p style='color:green;'>Boek succesvol toegevoegd!</p>";
    }
}
?>

<h2>Boek toevoegen</h2>

<?php
// Fouten tonen
if(!empty($fouten)){
    echo "<ul style='color:red;'>";
    foreach($fouten as $fout){
        echo "<li>$fout</li>";
    }
    echo "</ul>";
}
?>

<form method="POST">

Titel:<br>
<input type="text" name="titel" value="<?= $_POST['titel'] ?? '' ?>"><br><br>

Auteur:<br>
<input type="text" name="auteur" value="<?= $_POST['auteur'] ?? '' ?>"><br><br>

Genre:<br>
<input type="text" name="genre" value="<?= $_POST['genre'] ?? '' ?>"><br><br>

Publicatiejaar:<br>
<input type="number" name="publicatiejaar" value="<?= $_POST['publicatiejaar'] ?? '' ?>"><br><br>

<button type="submit" name="submit">Toevoegen</button>

</form>