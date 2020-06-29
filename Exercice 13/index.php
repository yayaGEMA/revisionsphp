<?php

require 'models/DTO/Animal.php';
require 'models/DAO/AnimalManager.php';

// Import needed classes in global namespace
use App\DTO\Animal;
use App\DAO\AnimalManager;

require 'models/settings.php';

// Try catch for exceptions
try{
    // Appel des variables
    if(
        isset($_POST['name']) &&
        isset($_POST['species']) &&
        isset($_POST['birthdate'])
    ){

        // Bloc des vérifs

        // Vérif name
        if(!preg_match('/^[a-z\'\- áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ ]{3,50}$/i', $_POST['name'])){
            $errors[] = 'Nom invalide';
        }

        // Vérif species
        if(!preg_match('/^[a-z\'\- áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ ]{2,55}$/i', $_POST['species'])){
            $errors[] = 'Espèce invalide';
        }

        // Vérif birthdate
        if(!preg_match('/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/', $_POST['birthdate'])){
            $errors[] = 'Date de naissance invalide';
        }

        // if no errors
        if(!isset($errors)){

            // Creates a animal manager
            $animalManager = new AnimalManager(getDb());

            // Creates a new object Article
            $newAnimal = new Animal();

            // Hydrates the object with data
            $newAnimal->setName($_POST['name']);
            $newAnimal->setSpecies($_POST['species']);
            $newAnimal->setBirthdate(new DateTime($_POST['birthdate']));

            // Asking manager to save the animal created in the db
            $status = $animalManager->save($newAnimal);

            // $status contains true if the animal save worked, else false
            if($status){
                $success = 'Animal ajouté avec succès !';
            } else {
                $errors[] = 'Problème avec la base de données, veuillez réessayer.';
            }
        }
    }

    // Instanciation du manager des animaux
    $animalManager = new AnimalManager( getDb() );

    // Récupération de tous les animaux
    $animals = $animalManager->findAll();

} catch(Exception $e){
    die('Problème PHP : ' . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <title>AJOUTER UN ANIMAL</title>
</head>
<body>
    <h1>AJOUTER UN ANIMAL</h1>
    <?php
    // Si le tableau $errors existe, alors on rentre dans cette condition
    if(isset($errors)){

        //On parcourt le tableau $errors pour afficher un msg d'erreur pour chaque erreur stockée dans l'array
        foreach($errors as $error){
            echo '<p style="color:red;">' . $error . '</p>';
        }
    }

    // Si le message de succès existe, on l'affiche
    if(isset($success)){
        echo $success;
    } else {

    ?>
    
    <form action="" method="POST">
        <label for="name">Nom de l'animal :</label>
        <input type="text" name="name" placeholder="Sally">
    <br>
        <label for="species">Espèce :</label>
        <input type="text" name="species" placeholder="Chien">
    <br>
        <label for="birthdate">Date de naissance :</label>
        <input type="date" name="birthdate" placeholder="25/04/2014">
    <br>
    <input type="submit">
    </form>
    <?php
    }
    ?>

<h2>Tous nos animaux</h2>

<?php

// Si la BDD est vide, message d'erreur, sinon affichage du tableau
if(empty($animals)){
    echo '<h3 style="color:red;">Oups ! Il n\'y a aucun animal à afficher.</h3>';
} else {
    ?>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Espèce</th>
                    <th>Date de naissance</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($animals as $animal){
                echo
                "<tr>
                    <td>" . htmlspecialchars($animal->getName()) . "</td>
                    <td>" . htmlspecialchars($animal->getSpecies()) . "</td>
                    <td>" . htmlspecialchars($animal->getBirthdate()->format('d-m-Y')) . "</td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
<?php
}
?>

</body>
</html>