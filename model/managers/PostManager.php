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



        public function findPostsPagination($topicId, $order =null){

            $page = $_GET['page'];
            
            $page  = (isset($page) && $page < 100000)? (int) $page : 1;
            $byPage = 5;
            $start = $byPage * ($page - 1);
            $total = count(iterator_to_array($this->findPostsByTopic($topicId)));
            $totalPages = ceil($total / $byPage);

            $next = $page+1;
            $prev = $page-1;

            $paginationInfo = [
                "page"          => $page,
                "start"         => $start,
                "totalPages"    => $totalPages,
                "next"          => $next,
                "prev"          => $prev
            ];

            $orderQuery = ($order) ?                 
            "ORDER BY ".$order[0]. " ".$order[1] :
            "";

            $sql = "SELECT *
                    FROM ".$this->tableName." t
                    LEFT JOIN user u ON t.user_id = u.id_user
                    WHERE topic_id = :id
                    ".$orderQuery."
                    LIMIT ".$start.",".$byPage." ";


            $res = [];
            
            $res['posts'] = $this->getMultipleResults(
                DAO::select($sql, ['id' => $topicId]), 
                $this->className
            );

            $res['paginator'] = $paginationInfo;

            return $res;

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