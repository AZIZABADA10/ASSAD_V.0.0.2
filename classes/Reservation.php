<?php
namespace App\Classes;

use PDO;

class Reservation
{
    private int $idVisite;
    private int $idUtilisateur;
    private int $nbPersonnes;
    private string $dateReservation;
    private string $statut;

    public function __construct(int $idVisite,int $idUtilisateur,int $nbPersonnes,string $dateReservation,string $statut = 'en_attente')
    {
        $this->idVisite  = $idVisite;
        $this->idUtilisateur = $idUtilisateur;
        $this->nbPersonnes = $nbPersonnes;
        $this->dateReservation = $dateReservation;
        $this->statut = $statut;
    }

    public function getIdVisite(): int 
    {
        return $this->idVisite; 
    }
    public function getIdUtilisateur(): int 
    { 
        return $this->idUtilisateur; 
    }
    public function getNbPersonnes(): int 
    { 
        return $this->nbPersonnes; 
    }
    public function getDateReservation(): string 
    { 
        return $this->dateReservation; 
    }
    public function getStatut(): string 
    { 
        return $this->statut; 
    }

    public function setIdVisite(int $id): void 
    { 
        $this->idVisite = $id; 
    }
    public function setIdUtilisateur(int $id): void 
    { 
        $this->idUtilisateur = $id; 
    }
    public function setNbPersonnes(int $nb): void 
    { 
        $this->nbPersonnes = $nb; 
    }
    public function setDateReservation(string $date): void 
    { 
        $this->dateReservation = $date; 
    }
    public function setStatut(string $statut): void 
    { 
        $this->statut = $statut; 
    }

    public function annulerStatut(PDO $pdo, int $id_reservation): void
    {
        $sql = "UPDATE reservations SET statut = 'annulee' WHERE id_reservation = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_reservation]);
    }

    public function confirmerStatut(PDO $pdo, int $id_reservation): void
    {
        $sql = "UPDATE reservations SET statut = 'confirmee' WHERE id_reservation = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_reservation]);
    }

    public function creerReservation(PDO $pdo): void
    {
        $sql = "INSERT INTO reservations (id_visite,id_utilisateur,nb_personnes,date_reservation,statut)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $this->idVisite,
            $this->idUtilisateur,
            $this->nbPersonnes,
            $this->dateReservation,
            $this->statut
        ]);
    }

    public static function getAllReservations(PDO $pdo, ?int $idGuide = null): array
    {
        $sql = "
            SELECT 
                r.id_reservation,
                r.statut,
                r.nb_personnes,
                r.date_reservation,
                u.nom_complet AS visiteur,
                v.titre AS visite
            FROM reservations r
            JOIN visitesguidees v ON r.id_visite = v.id_visite
            JOIN utilisateurs u ON r.id_utilisateur = u.id_utilisateur
        ";

        if ($idGuide !== null) {
            $sql .= " WHERE v.id_guide = :id_guide";
        }

        $sql .= " ORDER BY r.date_reservation DESC";

        $stmt = $pdo->prepare($sql);

        if ($idGuide !== null) {
            $stmt->execute([':id_guide' => $idGuide]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    }

