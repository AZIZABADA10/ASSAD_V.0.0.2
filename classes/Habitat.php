<?php
namespace App\Classes;

use PDO;

class Habitat
{
    private ?int $id;
    private string $nom_habitat;
    private string $typeClimat;
    private string $description;
    private string $zoneZoo;

    public function __construct(string $nom_habitat, string $typeClimat, string $description, string $zoneZoo, int $id = null) 
    {
        $this->nom_habitat = $nom_habitat;
        $this->typeClimat = $typeClimat;
        $this->description = $description;
        $this->zoneZoo = $zoneZoo;
        $this->id = $id;
    }

    public function getId(): ?int 
    { 
        return $this->id; 
    }
    public function getNomHabitat(): string 
    { 
        return $this->nom_habitat; 
    }
    public function getTypeClimat(): string 
    { 
        return $this->typeClimat; 
    }
    public function getDescription(): string 
    { 
        return $this->description; 
    }
    public function getZoneZoo(): string 
    { 
        return $this->zoneZoo; 
    }

    public function setNomHabitat(string $nom_habitat): void 
    { 
        $this->nom_habitat = $nom_habitat; 
    }
    public function setTypeClimat(string $typeClimat): void 
    { 
        $this->typeClimat = $typeClimat; 
    }
    public function setDescription(string $description): void 
    { 
        $this->description = $description; 
    }
    public function setZoneZoo(string $zoneZoo): void 
    { 
        $this->zoneZoo = $zoneZoo; 
    }

    public function createHabitat(PDO $pdo): bool
    {
        $sql = "INSERT INTO habitats (nom_habitat, type_climat, description_habitat, zone_zoo) VALUES (?, ?, ?, ?)";
        return $pdo->prepare($sql)->execute([$this->nom_habitat, $this->typeClimat, $this->description, $this->zoneZoo]);
    }

    public static function getAllHabitats(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM habitats ORDER BY id_habitat DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getHabitatById(PDO $pdo, int $id): ?Habitat
    {
        $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id_habitat = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Habitat($data['nom_habitat'], $data['type_climat'], $data['description_habitat'], $data['zone_zoo'], $data['id_habitat']);
        }
        return null;
    }

    public function updateHabitat(PDO $pdo): bool
    {
        if (!$this->id) return false;
        $sql = "UPDATE habitats SET nom_habitat=?, type_climat=?, description_habitat=?, zone_zoo=? WHERE id_habitat=?";
        return $pdo->prepare($sql)->execute([$this->nom_habitat, $this->typeClimat, $this->description, $this->zoneZoo, $this->id]);
    }

    public function deleteHabitat(PDO $pdo): bool
    {
        if (!$this->id) return false;
        return $pdo->prepare("DELETE FROM habitats WHERE id_habitat=?")->execute([$this->id]);
    }
}
