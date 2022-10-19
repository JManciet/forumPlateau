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

        


        public function updateClosed($id,$closed){

            $sql = "UPDATE ".$this->tableName."
                    SET closed = :closed
                    WHERE id_topic = :id";

            DAO::update($sql, ['closed' => $closed ,'id' => $id]);
            
        }

    }