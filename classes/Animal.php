<?php
namespace App\Models;

use PDO;

class Animal
{

    private string $nom_animal;
    private string $espece;
    private string $alimentation;
    private string $image;
    private string $paysOrigine;
    private string $descriptionCourte;
    private int $idHabitat;

    public function __construct(string $nom_animal,string $espece,string $alimentation,string $image,string $paysOrigine,string $descriptionCourte,int $idHabitat)
    {
        $this->nom_animal = $nom_animal;
        $this->espece = $espece;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->paysOrigine = $paysOrigine;
        $this->descriptionCourte = $descriptionCourte;
        $this->idHabitat = $idHabitat;
    }

    public function getNomAnimal(): string
    {
        return $this->nom_animal;
    }
    public function getEspace(): string
    {
        return $this->espece;
    }
    public function getAlimentation(): string
    {
        return $this->alimentation;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function getpaysOrigine(): string
    {
        return $this->paysOrigine;
    }
    public function getDescriptionCourte(): string{
        return $this->descriptionCourte;
    }
    public function getIdHabitat(): string
    {
        return $this-> idHabitat;
    }

    public function setNomAnimal(string $nom_animal):void
    {
        $this->nom_animal = $nom_animal;
    }
    public function setEspace(string $espece):void
    {
        $this->espece = $espece;
    }
    public function setAlimentation(string $alimentation):void
    {
        $this->alimentation = $alimentation;
    }
    public function setImage(string $image):void
    {
        $this->image = $image;
    }
    public function setpaysOrigine(string $paysOrigine):void
    {
        $this->paysOrigine = $paysOrigine;
    }
    public function setDescriptionCourte(string $descriptionCourte):void {
        $this->descriptionCourte = $descriptionCourte;
    }
    public function setIdHabitat(int $idHabitat):void
    {
        $this-> idHabitat = $idHabitat;
    }

    public function createAnimaux(PDO $pdo): bool
    {
        $sql = "INSERT INTO animaux
        (nom, espece, alimentation, image, pays_origine, description_courte, id_habitat)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        return $pdo->prepare($sql)->execute([$this->nom,$this->espece,$this->alimentation,$this->image,$this->paysOrigine,$this->descriptionCourte,$this->idHabitat]);
    }

    public function modifierAnimaux(PDO $pdo,int $id): bool
    {
        $sql = "UPDATE animaux SET nom = ?,espece = ?,alimentation = ?,image = ?,pays_origine = ?,description_courte = ?,id_habitat=? WHERE id=?";
        return $pdo->prepare($sql)->execute([$this->nom,$this->espece,$this->alimentation,$this->image,$this->paysOrigine,$this->descriptionCourte,$this->idHabitat,$id]);
    }

    public static function getAnimaux(PDO $pdo): array
    {
        return $pdo->query("SELECT * FROM animaux")->fetchAll();
    }
}
