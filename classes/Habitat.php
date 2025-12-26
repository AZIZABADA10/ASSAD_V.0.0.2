<?php
namespace App\Classes;

use PDO;

class Habitat
{

    private string $nom_habitat;
    private string $typeClimat;
    private string $description;
    private string $zoneZoo;

    public function __construct(string $nom_habitat,string $typeClimat,string $description,string $zoneZoo) 
    {
        $this->nom_habitat = $nom_habitat;
        $this->typeClimat = $typeClimat;
        $this->description = $description;
        $this->zoneZoo = $zoneZoo;
    }

    public function getNomHabitat(): string 
    { 
        return $this->nom_habitat;
    }

    public function getTypeClimat():string
    {
        return $this->typeClimat;
    }

    public function getDescription():string
    {
        return $this->zoneZoo;
    }

    public function setNomHbitat(string $nom_habitat):void
    {
        $this->nom_habitat = $nom_habitat;
    }

    public function setTypeClimat(string $typeClimat):void 
    {
        $this->TypeClimat = $typeClimat;
    }

    public function setDescription(string $description):void 
    {
        $this->description = $description;
    }
    public function setZoneZoo(string $zoneZoo):void 
    {
        $this->zoneZoo = $zoneZoo;
    }

    public function createAnimaux(PDO $pdo): bool
    {
        $sql = "INSERT INTO habitats (nom, type_climat, description, zone_zoo) VALUES (?, ?, ?, ?)";
        return $pdo->prepare($sql)->execute([$this->nom,$this->typeClimat,$this->description,$this->zoneZoo]);
    }

    public static function getHabitat(PDO $pdo): array
    {
        return $pdo->query("SELECT * FROM habitats")->fetchAll();
    }

    public function delete(PDO $pdo): bool
    {
        return $pdo->prepare("DELETE FROM habitats WHERE id = ?")->execute([$this->id]);
    }
}
