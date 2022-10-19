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



        public function hasRole($role){
                
                if($this->role == $role ){
                        return true;
                } else{
                        return false;
                }
                
        }
    }