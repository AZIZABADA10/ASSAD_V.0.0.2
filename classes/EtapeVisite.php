<?php
namespace App\Classes;

use PDO;

class EtapeVisite
{
    private string $titre;
    private string $description;
    private int $ordre;
    private int $idVisite;

    public function __construct(string $titre,string $description,int $ordre,int $idVisite) {
        $this->titre = $titre;
        $this->description = $description;
        $this->ordre = $ordre;
        $this->idVisite = $idVisite;
    }

    public function createEtapeVisite(PDO $pdo): bool
    {
        $sql = "INSERT INTO etapesvisite 
        (titreetape, descriptionetape, ordreetape, id_visite)
        VALUES (?, ?, ?, ?)";

        return $pdo->prepare($sql)->execute([$this->titre,$this->description,
            $this->ordre,
            $this->idVisite
        ]);
    }
}
