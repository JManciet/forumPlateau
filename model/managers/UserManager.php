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


        public function findUser($id){


            $sql = "
            SELECT 
            u.*,
            COUNT(DISTINCT p.id_post) nbPosts,
            COUNT(DISTINCT t.id_topic) nbTopics   
            FROM user u
            LEFT JOIN post p ON p.user_id = u.id_user
            LEFT JOIN topic t ON t.user_id = u.id_user
            WHERE u.id_user= :id
            ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );


        }
        
        public function findAllUsers($order = null){

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *, TIMESTAMPDIFF(SECOND, NOW(), banneduntil) timeBannedRemaining
                    FROM ".$this->tableName." a
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
        }
        
        
        
        public function bann($id, $days){

            $sql = "UPDATE ".$this->tableName."
                    SET banneduntil = DATE_ADD(NOW(), INTERVAL :days DAY)
                    WHERE id_user = :id";

        
            DAO::update($sql, ['id' => $id,
                                   'days' => $days]); 
                
        
        }


        public function cancelBann($id){

            $sql = "UPDATE ".$this->tableName."
                    SET banneduntil = null
                    WHERE id_user = :id";

            
            DAO::update($sql, ['id' => $id]); 
        
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

            $sql = "SELECT *, TIMESTAMPDIFF(SECOND, NOW(), banneduntil) timeBannedRemaining
                    FROM ".$this->tableName." a
                    WHERE a.email = :email
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }


        public function updatePassword($password,$id){

            $sql = "UPDATE ".$this->tableName."
                    SET mdp = :password
                    WHERE id_user = :id";

            
            return DAO::update($sql, ['password' => $password,
                                      'id' => $id]); 
        
        }


        public function updatePseudo($pseudo,$id){

            $sql = "UPDATE ".$this->tableName."
                    SET pseudo = :pseudo
                    WHERE id_user = :id";

            
            return DAO::update($sql, ['pseudo' => $pseudo,
                                      'id' => $id]); 
        
        }

        public function updateEmail($email,$id){

            $sql = "UPDATE ".$this->tableName."
                    SET email = :email
                    WHERE id_user = :id";

            
            return DAO::update($sql, ['email' => $email,
                                      'id' => $id]); 
        
        }


    }

