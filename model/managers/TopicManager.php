<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\TopicManager;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }

        
        public function findTopicsPagination($order =null){

            $page = $_GET['page'];
            
            $page  = (isset($page) && $page < 100000)? (int) $page : 1;
            $byPage = 5;
            $start = $byPage * ($page - 1);
            $total = count(iterator_to_array($this->findAll()));
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

            $sql = "SELECT id_topic, title, creationdate, closed , t.user_id, COUNT(p.topic_id) AS nbPosts, pseudo
                    FROM ".$this->tableName." t
                    LEFT JOIN post p ON t.id_topic = p.topic_id
                    LEFT JOIN user u ON t.user_id = u.id_user
                    GROUP BY t.id_topic
                    ".$orderQuery."
                    LIMIT ".$start.",".$byPage." ";


            $res = [];
            
            $res['topics'] = $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );

            $res['paginator'] = $paginationInfo;

            return $res;

        }


        public function findAllTopics($order =null){


            $orderQuery = ($order) ?                 
            "ORDER BY ".$order[0]. " ".$order[1] :
            "";

            $sql = "SELECT id_topic, title, creationdate, closed , t.user_id, COUNT(p.topic_id) AS nbPosts, pseudo
                    FROM ".$this->tableName." t
                    LEFT JOIN post p ON t.id_topic = p.topic_id
                    LEFT JOIN user u ON t.user_id = u.id_user
                    GROUP BY t.id_topic
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );

        }


        public function updateClosed($id,$closed){

            $sql = "UPDATE ".$this->tableName."
                    SET closed = :closed
                    WHERE id_topic = :id";

            DAO::update($sql, ['closed' => $closed ,'id' => $id]);
            
        }

    }