<?php

namespace App\DAO;

// Import classes from global namespace
use \App\DTO\Animal;
use \PDO;
use \DateTime;

/**
 * DAO class dealing with "Animal" class objects
 */
class AnimalManager{

    /**
     * Attribute allowing to stock an instance of db connection
     */
    private $db;
    
    /**
     * Getter of $db
     */
    public function getDb(){
        return $this->db;
    }

    /**
     * Setter de $db
     */
    public function setDb(PDO $db){
        $this->db = $db;
    }

    /**
     * Constructor hydrating $db with an instance of db connection
     */
    public function __construct($db){
        $this->setDb($db);
    }

    /**
     * Method allowing to save an "Animal" class object in db "animals" table
     */
    public function save(Animal $animalToSave){

        // Prepare to insert
        $createNewAnimal = $this->getDb()->prepare("INSERT INTO animals(name, species, birthdate) VALUES (?,?,?)");

        // execute
        return $createNewAnimal->execute([
            $animalToSave->getName(),
            $animalToSave->getSpecies(),
            $animalToSave->getBirthdate()->format('Y-m-d'),
        ]);
    }

    /**
     * Méthode permettant de convertir un tableau de données en un objet de la classe "Animal"
     */
    public function buildDomainObject(array $animalInfos){

        // Création d'un nouvel objet Animal
        $newAnimal = new Animal();

        // Hydratation de l'animal avec les infos récupérées dans la base de données
        $newAnimal->setId( $animalInfos['id'] );
        $newAnimal->setName( $animalInfos['name'] );
        $newAnimal->setSpecies( $animalInfos['species'] );
        $newAnimal->setBirthdate( new DateTime( $animalInfos['birthdate'] ) );

        return $newAnimal;
    }

    /**
     * Method allowing to show every object of "animal" class in BDD
     */
    public function findAll(){

        // Requête SQL pour récupérer les infos
        $getAnimals = $this->getDb()->query('SELECT * FROM animals');

        // Récupération des animaux sous forme d'arrays associatifs
        $animalsList = $getAnimals->fetchAll(PDO::FETCH_ASSOC);

        // Création d'un nouveau table qui contiendra tous les objets sous forme d'objets de la classe Animal
        $animalsObjects = [];

        // Pour chaque sous tableau d'animal, on crée un objet "Animal" que l'on ajoute dans le tableau $animalsObjects
        foreach($animalsList as $animalInfos){

            // Ajout du nouvel animal hydraté dans le tableau $animalsObjects
            $animalsObjects[] = $this->buildDomainObject($animalInfos);

        }

        // La méthode retourne le tableau contenant tous les animaux sous form d'objets de la classe "Animal"
        return $animalsObjects;

    }

}