<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity{

        private $id;
        private $email;
        private $role;
        private $mdp;
        private $pseudo;
        private $avatar;
        private $registerdate;
        private $banneduntil;
        private $timeBannedRemaining;
        private $nbTopics;
        private $nbPosts;
        

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of title
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getRole()
        {
                return $this->role;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }

        

        /**
         * Get the value of closed
         */ 
        public function getMdp()
        {
                return $this->mdp;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setMdp($mdp)
        {
                $this->mdp = $mdp;

                return $this;
        }

         /**
         * Get the value of closed
         */ 
        public function getPseudo()
        {
                return $this->pseudo;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setPseudo($pseudo)
        {
                $this->pseudo = $pseudo;

                return $this;
        }

         /**
         * Get the value of closed
         */ 
        public function getAvatar()
        {
                return $this->avatar;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setAvatar($avatar)
        {
                $this->avatar = $avatar;

                return $this;
        }


        public function getRegisterdate(){
            $formattedDate = $this->registerdate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setRegisterdate($date){
            $this->registerdate = new \DateTime($date);
            return $this;
        }


        public function getBanneduntil()
        {       
             if(is_null($this->banneduntil)) {
                return null;
             } else {
                $formattedDate = $this->banneduntil->format("d/m/Y, H:i:s");
                return $formattedDate;

             }

               
        }

        
        public function setBanneduntil($banneduntil)
        {
                if(is_null($banneduntil)) {
                        $this->banneduntil = NULL;
                } else {
                        $this->banneduntil = new \DateTime($banneduntil);
                        return $this;

                }
        }


        public function hasRole($role){
                
                if($this->role == $role ){
                        return true;
                } else{
                        return false;
                }
                
        }


        
        public function getTimeBannedRemaining()
        {
                return $this->timeBannedRemaining;
        }

        
        public function setTimeBannedRemaining($timeBannedRemaining)
        {

                if($timeBannedRemaining<0){

                        $this->setBanneduntil(null);   

                }else{

                        $this->timeBannedRemaining = $this->secondsToTime($timeBannedRemaining);

                }
                
        }

        private function secondsToTime($seconds) {

                if(!is_null($seconds)){
                        $dtF = new \DateTime('@0');
                        $dtT = new \DateTime("@$seconds");
                        return $dtF->diff($dtT)->format('%a jours, %h heures et %i minutes');
                }else{

                        return null;
                }
            }

        /**
         * Get the value of nbTopics
         */ 
        public function getNbTopics()
        {
                return $this->nbTopics;
        }

        /**
         * Set the value of nbTopics
         *
         * @return  self
         */ 
        public function setNbTopics($nbTopics)
        {
                $this->nbTopics = $nbTopics;

                return $this;
        }

        /**
         * Get the value of nbPosts
         */ 
        public function getNbPosts()
        {
                return $this->nbPosts;
        }

        /**
         * Set the value of nbPosts
         *
         * @return  self
         */ 
        public function setNbPosts($nbPosts)
        {
                $this->nbPosts = $nbPosts;

                return $this;
        }
    }