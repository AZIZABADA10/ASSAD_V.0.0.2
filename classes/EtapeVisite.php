<?php

class Commentaire
{
    private int $idVisiteGuidee;
    private int $idUtilisateur;
    private int $note;
    private string $texte;
    private string $date_commentaire;


    public function __construct(int $idVisiteGuidee,int $idUtilisateur,int $note,string $texte,string $date_commentaire)
    {
        $this->idVisiteGuidee= $idVisiteGuidee;
        $this->idUtilisateur= $idUtilisateur;
        $this->note = $note;
        $this->texte = $texte;
        $this->date_commentaire = $date_commentaire;
    }


    public function getIdCommentaire(): int
    {
        return $this->id_commentaire;
    }

    public function getIdVisiteGuidee(): int
    {
        return $this->idVisiteGuidee;
    }

    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function getTexte(): string
    {
        return $this->texte;
    }

    public function getDateCommentaire(): string
    {
        return $this->date_commentaire;
    }


    public function setIdVisiteGuidee(int $idVisiteGuidee): void
    {
        $this->idVisiteGuidee = $idVisiteGuidee;
    }

    public function setIdUtilisateur(int $idUtilisateur): void
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    public function setNote(int $note): void
    {
        $this->note = $note;
    }

    public function setTexte(string $texte): void
    {
        $this->texte = $texte;
    }

    public function setDateCommentaire(string $date_commentaire): void
    {
        $this->date_commentaire = $date_commentaire;
    }


    public function creerCommentaire(string $com): void
    {
        $sql = "INSERT INTO commentaires (
                id_visite,
                id_utilisateur,
                note,
                date_commentaire,
                texte) 
                values (?,?,?,?,?)";
        $pdo->prepare($sql)->execute([
            $this->idVisiteGuidee,
            $this->idUtilisateur,
            $this->note,
            $this->texte ,
            $this->date_commentaire 
        ]);
    }
    public function getAllCommentaire()
    {
        $sql ="SELECT * FROM  commentaires";
        $pdo->prepare($sql)->fetchAll();

    }
}
