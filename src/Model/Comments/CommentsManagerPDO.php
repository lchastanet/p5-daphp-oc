<?php

namespace App\Model\Comments;

class CommentsManagerPDO extends CommentsManager
{
    public function getListOf($news)
    {
        if (!ctype_digit($news)) {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
        }

        $q = $this->dao->prepare('SELECT comments.id, idNews, idUser, login, contenu, date FROM comments, users WHERE idNews = :news AND comments.validated = :validated AND comments.idUser = users.id');
        $q->bindValue(':news', $news, \PDO::PARAM_INT);
        $q->bindValue(':validated', true, \PDO::PARAM_BOOL);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Comments\Comment');

        $comments = $q->fetchAll();

        foreach ($comments as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
        }

        return $comments;
    }

    public function getAdminList($validated)
    {
        $q = $this->dao->prepare('SELECT comments.id, idNews, idUser, login, contenu, date, comments.validated FROM comments, users WHERE comments.validated = :validated AND comments.idUser = users.id');
        $q->bindValue(':validated', $validated, \PDO::PARAM_BOOL);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Comments\Comment');

        $comments = $q->fetchAll();

        foreach ($comments as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
        }

        return $comments;
    }

    public function get($id)
    {
        $q = $this->dao->prepare('SELECT comments.id, idNews, idUser, login, contenu FROM comments, users WHERE id = :id AND comments.idUser = users.id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Comments\Comment');

        return $q->fetch();
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
        $q = $this->dao->prepare('UPDATE comments SET validated = :validated WHERE id = :id');

        $q->bindValue(':validated', true, \PDO::PARAM_BOOL);
        $q->bindValue(':id', $id, \PDO::PARAM_INT);

        $q->execute();
    }

    protected function add(Comment $comment)
    {
        $q = $this->dao->prepare('INSERT INTO comments SET idNews = :news, idUser = :idUser, contenu = :contenu, date = NOW(), validated = :validated');

        $q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
        $q->bindValue(':idUser', $comment->idUser());
        $q->bindValue(':contenu', $comment->contenu());
        $q->bindValue(':validated', $comment->validated(), \PDO::PARAM_BOOL);

        $q->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    protected function modify(Comment $comment)
    {
        $q = $this->dao->prepare('UPDATE comments SET idUser = :idUser, contenu = :contenu WHERE id = :id');

        $q->bindValue(':idUser', $comment->idUser());
        $q->bindValue(':contenu', $comment->contenu());
        $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

        $q->execute();
    }
}
