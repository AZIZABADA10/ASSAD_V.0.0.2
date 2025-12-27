<?php
namespace App\Classes;

use PDO;

class VisiteGuidee
{
    private string $titre;
    private string $dateHeure;
    private string $langue;
    private int $capaciteMax;
    private string $statut;
    private int $duree;
    private float $prix;
    private int $idGuide;

    public function __construct(string $titre,string $dateHeure,string $langue,int $capaciteMax,string $statut,int $duree,float $prix,int $idGuide) 
    {
        $this->titre = $titre;
        $this->dateHeure = $dateHeure;
        $this->langue = $langue;
        $this->capaciteMax = $capaciteMax;
        $this->statut = $statut;
        $this->duree = $duree;
        $this->prix = $prix;
        $this->idGuide = $idGuide;
    }


    public function getTitre(): string 
    { 
        return $this->titre; 
    }
    public function getDateHeure(): string 
    { 
        return $this->dateHeure;
    }
    public function getLangue(): string 
    { 
        return $this->langue; 
    }
    public function getCapaciteMax(): int 
    { 
        return $this->capaciteMax; 
    }
    public function getStatut(): string
    { 
        return $this->statut; 
    }
    public function getDuree(): int 
    {
         return $this->duree;
    }
    public function getPrix(): float 
    {
         return $this->prix;
    }
    public function getIdGuide(): int 
    { 
        return $this->idGuide;
    }


    public function setTitre(string $titre): void 
    { 
        $this->titre = $titre; 
    }
    public function setDateHeure(string $dateHeure): void 
    { 
        $this->dateHeure = $dateHeure; 
    }
    public function setLangue(string $langue): void 
    { 
        $this->langue = $langue; 
    }
    public function setCapaciteMax(int $capaciteMax): void 
    {
        $this->capaciteMax = $capaciteMax; 
    }
    public function setStatut(string $statut): void 
    { 
        $this->statut = $statut; 
    }
    public function setDuree(int $duree): void { $this->duree = $duree; }
    public function setPrix(float $prix): void { $this->prix = $prix; }
    public function setIdGuide(int $idGuide): void { $this->idGuide = $idGuide; }

    public function createVisite(PDO $pdo): bool
    {
        $sql = "INSERT INTO visitesguidees 
        (titre, date_heure, langue, capacite_max, statut, duree, prix, id_guide)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->titre,
            $this->dateHeure,
            $this->langue,
            $this->capaciteMax,
            $this->statut,
            $this->duree,
            $this->prix,
            $this->idGuide
        ]);
    }

    public function changerStatut(PDO $pdo, int $idVisite, string $nouveauStatut): bool
    {
        $sql = "UPDATE visitesguidees SET statut = ? WHERE id_visite = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nouveauStatut, $idVisite]);
    }

    public static function annuler(PDO $pdo, int $idVisite): bool
    {
        $sql = "UPDATE visitesguidees SET statut='annulee' WHERE id_visite=?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$idVisite]);
    }

    public function getAllViste(){
        $sql = "SELECT * FROM visitesguidees"; 
        return $stmt->prepare($sql)->execute()->fetchAll();
    }
}
