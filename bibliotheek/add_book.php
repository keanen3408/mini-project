<?php
require_once 'db.php';

$fouten = [];

if(isset($_POST['submit'])){

    $titel = trim($_POST['titel']);
    $auteur = trim($_POST['auteur']);
    $genre = trim($_POST['genre']);
    $jaar = $_POST['publicatiejaar'];

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

        echo "<p style='color:green; text-align:center;'>Boek succesvol toegevoegd!</p>";
    }
}
?>

<div style="
width:400px;
margin:100px auto;
background:white;
padding:30px;
border-radius:10px;

text-align:center;
font-family:Arial;
">

<h2>Boek toevoegen</h2>

<?php
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
<input type="text" name="titel" value="<?= $_POST['titel'] ?? '' ?>" style="width:90%; padding:8px;"><br><br>

Auteur:<br>
<input type="text" name="auteur" value="<?= $_POST['auteur'] ?? '' ?>" style="width:90%; padding:8px;"><br><br>

Genre:<br>
<input type="text" name="genre" value="<?= $_POST['genre'] ?? '' ?>" style="width:90%; padding:8px;"><br><br>

Publicatiejaar:<br>
<input type="number" name="publicatiejaar" value="<?= $_POST['publicatiejaar'] ?? '' ?>" style="width:90%; padding:8px;"><br><br>

<button type="submit" name="submit" style="
padding:10px 15px;
background:#3498db;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
">
Toevoegen
</button>

</form>

</div>