<?php

namespace App\Model\Comments;

class CommentsManagerPDO extends CommentsManager
{
    public function getListOf($news)
    {
        if (!ctype_digit($news)) {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
        }

        $query = $this->dao->prepare('SELECT comments.id, idNews, idUser, login, contenu, date FROM comments, users WHERE idNews = :news AND comments.validated = :validated AND comments.idUser = users.id');
        $query->bindValue(':news', $news, \PDO::PARAM_INT);
        $query->bindValue(':validated', true, \PDO::PARAM_BOOL);
        $query->execute();

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Comments\Comment');

        $comments = $query->fetchAll();

        foreach ($comments as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
        }

        return $comments;
    }

    public function getAdminList($validated)
    {
        $query = $this->dao->prepare('SELECT comments.id, idNews, idUser, login, contenu, date, comments.validated FROM comments, users WHERE comments.validated = :validated AND comments.idUser = users.id');
        $query->bindValue(':validated', $validated, \PDO::PARAM_BOOL);
        $query->execute();

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Comments\Comment');

        $comments = $query->fetchAll();

        foreach ($comments as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
        }

        return $comments;
    }

    public function get($id)
    {
        $query = $this->dao->prepare('SELECT comments.id, idNews, idUser, login, contenu FROM comments, users WHERE id = :id AND comments.idUser = users.id');
        $query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Comments\Comment');

        return $query->fetch();
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM comments WHERE id = ' . (int) $id);
    }

    public function deleteFromNews($news)
    {
        $this->dao->exec('DELETE FROM comments WHERE idNews = ' . (int) $news);
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    public function validate($id)
    {
        $query = $this->dao->prepare('UPDATE comments SET validated = :validated WHERE id = :id');

        $query->bindValue(':validated', true, \PDO::PARAM_BOOL);
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        $query->execute();
    }

    protected function add(Comment $comment)
    {
        $query = $this->dao->prepare('INSERT INTO comments SET idNews = :news, idUser = :idUser, contenu = :contenu, date = NOW(), validated = :validated');

        $query->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
        $query->bindValue(':idUser', $comment->idUser());
        $query->bindValue(':contenu', $comment->contenu());
        $query->bindValue(':validated', $comment->validated(), \PDO::PARAM_BOOL);

        $query->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    protected function modify(Comment $comment)
    {
        $query = $this->dao->prepare('UPDATE comments SET idUser = :idUser, contenu = :contenu WHERE id = :id');

        $query->bindValue(':idUser', $comment->idUser());
        $query->bindValue(':contenu', $comment->contenu());
        $query->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

        $query->execute();
    }
}
