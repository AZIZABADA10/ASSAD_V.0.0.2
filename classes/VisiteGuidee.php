<?php
namespace App\Classes;

use PDO;

class VisiteGuidee
{
    private string $titre;
    private string $description;
    private string $dateHeure;
    private string $langue;
    private int $capaciteMax;
    private string $statut;
    private int $duree;
    private float $prix;
    private int $idGuide;

    public function __construct(string $titre,string $description,string $dateHeure,string $langue,int $capaciteMax,string $statut,int $duree,float $prix,int $idGuide) 
    {
        $this->titre = $titre;
        $this->description = $description;
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
    public function getDescription(): string 
    { 
        return $this->description; 
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


    public function setDescription(string $description): void 
    { 
        $this->description = $description; 
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
        (titre,description , date_heure, langue, capacite_max, statut, duree, prix, id_guide)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->titre,
            $this->description,
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

    public function annuler(PDO $pdo, int $idVisite): bool
    {
        $sql = "UPDATE visitesguidees SET statut='annulee' WHERE id_visite=?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$idVisite]);
    }

    public static function getAllVisites(PDO $pdo, int $id_guide): array
    {
        $sql = "SELECT * FROM visitesguidees WHERE id_guide = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_guide]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(PDO $pdo, int $idVisite, int $idGuide): ?array
    {
        $stmt = $pdo->prepare(
            "SELECT * FROM visitesguidees WHERE id_visite = ? AND id_guide = ?"
        );
        $stmt->execute([$idVisite, $idGuide]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateVisite(PDO $pdo, int $idVisite): bool
    {
        $sql = "UPDATE visitesguidees
                SET titre=?, date_heure=?, langue=?, capacite_max=?, duree=?, prix=?
                WHERE id_visite=? AND id_guide=?";

        return $pdo->prepare($sql)->execute([$this->titre,$this->dateHeure,$this->langue,$this->capaciteMax,$this->duree,$this->prix,$idVisite,$this->idGuide]);
    }

    public static function supprimer(PDO $pdo, int $idVisite, int $idGuide): bool
    {
        return $pdo->prepare("DELETE FROM visitesguidees WHERE id_visite=? AND id_guide=?")->execute([$idVisite, $idGuide]);
    }

    public static function getVisitesOuvertes(PDO $pdo): array
{
    $stmt = $pdo->prepare(
        "SELECT * FROM visitesguidees WHERE statut='ouverte' ORDER BY date_heure DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




}
