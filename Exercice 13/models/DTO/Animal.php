<?php

namespace App\DTO;

use \DateTime;
use \Exception;

/**
 * Classe DTO des animaux
 * 
 * @author Marceau GERARD
 */

 class Animal{
    private $id;
    private $name;
    private $species;
    private $birthdate;

    /* Getters */

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getSpecies(){
        return $this->species;
    }

    public function getBirthdate(){
        return $this->birthdate;
    }

    /* Setters */

    public function setId(int $id){

        if(!preg_match('/^[1-9][0-9]{0,10}$/', $id)){
            throw new Exception('L\'id doit être valide');
        }

        $this->id = $id;
    }

    public function setName(string $name){

        if(!preg_match('/^.{1,50}$/', $name)){
            throw new Exception('Le nom doit contenir entre 1 et 50 caractères');
        }

        $this->name = $name;
    }

    public function setSpecies(string $species){

        if(!preg_match('/^.{1,55}$/', $species)){
            throw new Exception('Le nom de l\'espèce doit contenir entre 1 et 55 caractères');
        }

        $this->species = $species;
    }

    public function setBirthdate(DateTime $birthdate){
        $this->birthdate = $birthdate;
    }
}