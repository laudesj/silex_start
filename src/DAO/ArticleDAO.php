<?php

namespace Blog\DAO;

use Doctrine\DBAL\Connection;
use Blog\Domain\Article;

class ArticleDAO
{

    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function findAll() {
        $sql = "select * from articles order by id desc";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $articles = array();
        foreach ($result as $row) {
            $articleId = $row['id'];
            $articles[$articleId] = $this->buildArticle($row);
        }
        return $articles;
    }

    public function find($articleId) {
        $sql = "select * from articles where id = ?";
        $row = $this->db->fetchAssoc($sql, array($articleId));
        if ($row)
            return $this->buildArticle($row);
        else
            throw new \Exception("No article matching id " . $articleId);
    }

    private function buildArticle(array $row) {
        $article = new Article();
        $article->setId($row['id']);
        $article->setTitre($row['titre']);
        $article->setContenu($row['contenu']);
        return $article;
    }
}