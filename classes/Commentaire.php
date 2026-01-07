<?php
namespace App\Classes;

use PDO;

class Commentaire
{
    private int $idVisite;
    private int $idUtilisateur;
    private int $note;
    private string $texte;
    private string $dateCommentaire;

    public function __construct(
        int $idVisite,
        int $idUtilisateur,
        int $note,
        string $texte,
        string $dateCommentaire
    ) {
        $this->idVisite = $idVisite;
        $this->idUtilisateur = $idUtilisateur;
        $this->note = $note;
        $this->texte = $texte;
        $this->dateCommentaire = $dateCommentaire;
    }


    public function creer(PDO $pdo): bool
    {
        $sql = "INSERT INTO commentaires 
                (id_visite, id_utilisateur, note, texte, date_commentaire)
                VALUES (?, ?, ?, ?, ?)";

        return $pdo->prepare($sql)->execute([
            $this->idVisite,
            $this->idUtilisateur,
            $this->note,
            $this->texte,
            $this->dateCommentaire
        ]);
    }

    public static function getByVisite(PDO $pdo, int $idVisite): array
    {
        $sql = "
            SELECT c.texte, c.note, c.date_commentaire, u.nom_complet
            FROM commentaires c
            JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
            WHERE c.id_visite = ?
            ORDER BY c.date_commentaire DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idVisite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
