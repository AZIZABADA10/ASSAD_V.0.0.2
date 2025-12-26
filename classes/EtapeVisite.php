<?php
namespace App\Classes;

use PDO;

class EtapeVisite
{

    private string $titreEtape;
    private string $descriptionEtape;
    private int $ordreEtape;
    private int $idVisite;

    
    public function __construct(string $titreEtape,string $descriptionEtape,int $ordreEtape,int $idVisite) {

        $this->titreEtape = $titreEtape;
        $this->descriptionEtape = $descriptionEtape;
        $this->ordreEtape = $ordreEtape;
        $this->idVisite = $idVisite;
    }


    

    public function getTitreEtape(): string
    {
        return $this->titreEtape;
    }

    public function getDescriptionEtape(): string
    {
        return $this->descriptionEtape;
    }

    public function getOrdreEtape(): int
    {
        return $this->ordreEtape;
    }

    


    public function setTitreEtape(string $titreEtape): void
    {
        $this->titreEtape = $titreEtape;
    }

    public function setDescriptionEtape(string $descriptionEtape): void
    {
        $this->descriptionEtape = $descriptionEtape;
    }

    public function setOrdreEtape(int $ordreEtape): void
    {
        $this->ordreEtape = $ordreEtape;
    }

    public function setIdVisite(int $idVisite): void
    {
        $this->idVisite = $idVisite;
    }


    public function create(PDO $pdo): bool
    {
        $sql = "INSERT INTO etapes_visite
                (titre_etape, description_etape, ordre_etape, id_visite)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->titreEtape,
            $this->descriptionEtape,
            $this->ordreEtape,
            $this->idVisite
        ]);
    }
}
