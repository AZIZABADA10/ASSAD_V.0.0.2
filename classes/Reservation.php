<?php
namespace App\Classes;


class Reservation
{
    private int $idVisite;
    private int $idUtilisateur;
    private int $nbPersonnes;
    private string $dateReservation;
    private string $statut;

    public function __construct(int $idVisite,int $idUtilisateur,int $nbPersonnes,date $dateReservation,string $statut = 'en_attente')
    {
        $this->idVisite  = $idVisite;
        $this->idutilisateur = $idUtilisateur;
        $this->nbrPersonne = $nbPersonnes;
        $this->dateReservation = $dateReservation;
        $this->statut = $statut;

    }

    
    public function getIdVisite(): int
    {
        return $this->idVisite;
    }
    public function getIdutilisateur(): int
    {
        return $this->idutilisateur;
    }
    public function getNbrPersonne(): int
    {
        return $this->nbrPersonne;
    }
    public function getDateReservation(): date
    {
        return $this->dateReservation;
    }
    public function getStatut(): date
    {
        return $this->statut;
    }


    
    public function setIdVisite(int $id): void
    {
        $this->idVisite = $id;
    }
    public function setIdutilisateur(int $id): void
    {
        $this->idutilisateur = $id;
    }
    public function setNbrPersonne(int $id): void
    {
        $this->nbrPersonne = $id;
    }
    public function setDateReservation(int $date):void
    {
        $this->dateReservation = $date;
    }
    public function setStatut(int $statut):void
    {
        $this->statut = $statut;
    }

    public function annulerStatut(int $id_reservation): void
    {
        $sql = "UPDATE reservations SET statut = 'annulee' where id_reservation =? ";
        $pdo->prepare($sql)->execute([$id_reservation]);
    }
    public function confiermerStatut(int $id_reservation): void
    {
        $sql = "UPDATE reservations SET statut = 'confirmee' where id_reservation =? ";
        $pdo->prepare($sql)->execute([$id_reservation]);
    }

    public function creer_reservation(int $id): void
    {
        $sql = "INSERT INTO reservations (
        idVisite,idUtilisateur,nbPersonnes,dateReservation,statut
        ) values (?,?,?,?,?)";
        $pdo->prepare($sql)->execute([
            $this->idVisite,         
            $this->idutilisateur,
            $this->nbrPersonne,           
            $this->dateReservationn,
            $this->statut
          ]);
    }
    public function getAllreservation()
    {
        $sql = "SELECT * FROM reservations";
        return $pdo->prepare($sql)->fetchAll();
    }
}
