<?php

namespace App\Model\News;

class NewsManagerPDO extends NewsManager
{
    public function getList($debut = -1, $limite = -1)
    {
        $sql = 'SELECT news.id, idUser, login, titre, chapo, contenu, dateAjout, dateModif FROM news, users WHERE news.idUser = users.id ORDER BY id DESC';

        if (-1 != $debut || -1 != $limite) {
            $sql .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
        }

        $q = $this->dao->query($sql);
        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\News\News');

        $listeNews = $q->fetchAll();

        foreach ($listeNews as $news) {
            $news->setDateAjout(new \DateTime($news->dateAjout()));
            $news->setDateModif(new \DateTime($news->dateModif()));
        }

        $q->closeCursor();

        return $listeNews;
    }

    public function getUnique($id)
    {
        $q = $this->dao->prepare('SELECT news.id, idUser, login, titre, chapo, contenu, dateAjout, dateModif FROM news, users WHERE news.id = :id AND news.idUser = users.id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\News\News');

        if ($news = $q->fetch()) {
            $news->setDateAjout(new \DateTime($news->dateAjout()));
            $news->setDateModif(new \DateTime($news->dateModif()));

            return $news;
        }

        return null;
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM comments WHERE idNews = ' . (int) $id);
        $this->dao->exec('DELETE FROM news WHERE id = ' . (int) $id);
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
    }

    protected function add(News $news)
    {
        $q = $this->dao->prepare('INSERT INTO news SET idUser = :idUser, titre = :titre, chapo = :chapo, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');

        $q->bindValue(':titre', $news->titre());
        $q->bindValue(':chapo', $news->chapo());
        $q->bindValue(':idUser', $news->idUser());
        $q->bindValue(':contenu', $news->contenu());

        $q->execute();
    }

    protected function modify(News $news)
    {
        $q = $this->dao->prepare('UPDATE news SET idUser = :idUser, titre = :titre, chapo = :chapo, contenu = :contenu, dateModif = NOW() WHERE id = :id');

        $q->bindValue(':titre', $news->titre());
        $q->bindValue(':chapo', $news->chapo());
        $q->bindValue(':idUser', $news->idUser());
        $q->bindValue(':contenu', $news->contenu());
        $q->bindValue(':id', $news->id(), \PDO::PARAM_INT);

        $q->execute();
    }
}
