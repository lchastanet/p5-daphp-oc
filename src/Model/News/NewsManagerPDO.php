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

        $query = $this->dao->query($sql);
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\News\News');

        $listeNews = $query->fetchAll();

        foreach ($listeNews as $news) {
            $news->setDateAjout(new \DateTime($news->dateAjout()));
            $news->setDateModif(new \DateTime($news->dateModif()));
        }

        $query->closeCursor();

        return $listeNews;
    }

    public function getUnique($id)
    {
        $query = $this->dao->prepare('SELECT news.id, idUser, login, titre, chapo, contenu, dateAjout, dateModif FROM news, users WHERE news.id = :id AND news.idUser = users.id');
        $query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\News\News');

        if ($news = $query->fetch()) {
            $news->setDateAjout(new \DateTime($news->dateAjout()));
            $news->setDateModif(new \DateTime($news->dateModif()));

            return $news;
        }

        return null;
    }

    public function deleteNews($id)
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
        $query = $this->dao->prepare('INSERT INTO news SET idUser = :idUser, titre = :titre, chapo = :chapo, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');

        $query->bindValue(':titre', $news->titre());
        $query->bindValue(':chapo', $news->chapo());
        $query->bindValue(':idUser', $news->idUser());
        $query->bindValue(':contenu', $news->contenu());

        $query->execute();
    }

    protected function modify(News $news)
    {
        $query = $this->dao->prepare('UPDATE news SET idUser = :idUser, titre = :titre, chapo = :chapo, contenu = :contenu, dateModif = NOW() WHERE id = :id');

        $query->bindValue(':titre', $news->titre());
        $query->bindValue(':chapo', $news->chapo());
        $query->bindValue(':idUser', $news->idUser());
        $query->bindValue(':contenu', $news->contenu());
        $query->bindValue(':id', $news->id(), \PDO::PARAM_INT);

        $query->execute();
    }
}
