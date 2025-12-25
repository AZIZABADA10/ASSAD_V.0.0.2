<?php
namespace App\Models;

use PDO;

class VisiteGuidee
{
    private string $titre;
    private string $dateHeure;
    private string $langue;
    private int $capaciteMax;
    private string $status;
    private int $duree;
    private float $prix;
    private int $idGuide;

    public function __construct(string $titre,string $dateHeure,string $langue,int $capaciteMax,string $status,int $duree,float $prix,int $idGuide)
    {
    $this->titre = $titre;
    $this->dateHeure = $dateHeure;
    $this->langue = $langue;
    $this->capaciteMax = $capaciteMax;
    $this->status = $status;
    $this->duree = $duree;
    $this->prix = $prix;
    $this->idGuide = $idGuide;
    }

public function getDuree(): int
    {
        return $this->duree;
    }
    public function getPrix(): float
    {
        return $this->prix;
    }
    public function getidGuide(): int
    {
        return $this->idGuide;
    }
    
    public function getTitre(): string
    {
        return $this->titre;
    }
    public function getDateHeure(): date
    {
        return $this->dateHeure;
    }
    public function getlangue(): string
    {
        return $this->langue;
    }
    public function getCapaciteMax(): int
    {
        return $this->capaciteMax;
    }
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setDuree(int $duree): void 
    {
        $this->duree  = $duree;
    }
    public function setPrix(int $prix): void 
    {
        $this->prix = $prix;
    }
    public function setidGuide(int $idGuide): void 
    {
        $this->idGuide = $idGuide;
    }
    
    public function setTitre(string $titre): void 
    {
        $this->titre = $titre;
    }
    public function setDateHeure(date $dateHeure): void 
    {
        $this->dateHeure = $dateHeure;
    }
    public function setlangue(string $langue): void 
    {
        $this->langue = $langue;
    }
    public function setCapaciteMax(int $CapaciteMax): void 
    {
        $this->capaciteMax = $capaciteMax;
    }
    public function setStatus(string $status): void 
    {
        $this->status = $status;
    }

    public function createVisiteGuidee(PDO $pdo){
        $sql = "INSERT INTO visitesguidees 
        (
            titre,
            description,
            date_heure,
            langue,
            capacite_max,
            statut,
            duree,
            prix,
            id_guide
        )
        VALUES (?,?,?,?,?,?,?,?,?)
        ";
        return $pdo->prepare($sql)->execute([
            $this->titre,
            $this->description,
            $this->date_heure,
            $this->langue,
            $this->capacite_max,
            $this->statut,
            $this->duree,
            $this->prix,
            $this->id_guide
        ]);

    }

    public function modifierVisteGuidee(PDO $pdo, int $id)
    {
        $sql = "UPDATE visitesguidees 
        SET 
        titre = ?,
        description =? = ?,
        date_heure = ?,
        langue = ?,
        capacite_max = ?,
        statut = ?,
        duree = ?,
        prix = ?,
        id_guide =?
        WHERE id_visite = ? ";
        $pdo->prepare($sql)->execute([
            $this->titre,
            $this->description,
            $this->date_heure,
            $this->langue,
            $this->capacite_max,
            $this->statut,
            $this->duree,
            $this->prix,
            $this->id_guide,
            $id
        ]);
    }

    public function annulerVisite(PDO $pdo, int $id, string $neveauStatut)
    {
        $sql = "UPDATE visitesguidees
        SET  $this->statut = $neveauStatut
        WHERE id_visite = ?
        ";
        $pdo->prepare($sql)->execute([$neveauStatut,$id]);
    }

    public function affichierVisite () 
    {
        return $this->titre.' '.$this->description.' '.$this->date_heure.' '.$this->langue.' '.$this->capacite_max.' '.$this->statut.' '.$this->duree.' '.$this->prix.' '.$this->id_guide;
    }
}