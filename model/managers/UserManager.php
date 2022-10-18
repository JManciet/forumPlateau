<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\UserManager;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }


        public function findEmail($email){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.email = :email
                    ";

            return $this->getMultipleResults(
                DAO::select($sql, ['email' => $email]), 
                $this->className
            );
        }


        public function findPseudo($pseudo){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.pseudo = :pseudo
                    ";

            return $this->getMultipleResults(
                DAO::select($sql, ['pseudo' => $pseudo]), 
                $this->className
            );
        }

        public function findUserByPseudo($pseudo){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.pseudo = :pseudo
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['pseudo' => $pseudo], false), 
                $this->className
            );
        }

        public function findUserByEmail($email){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.email = :email
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }


    }

