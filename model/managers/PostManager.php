<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\PostManager;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }


        public function findPostsByTopic($topicId, $order = null){


            $orderQuery = ($order) ?                 
            "ORDER BY ".$order[0]. " ".$order[1] :
            "";

        $sql = "SELECT *
                FROM ".$this->tableName." t
                LEFT JOIN user u ON t.user_id = u.id_user
                WHERE topic_id = :id
                ".$orderQuery;

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $topicId]), 
            $this->className
        );

        }

    }