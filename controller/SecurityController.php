<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class SecurityController extends AbstractController implements ControllerInterface{

        public function index(){
            
                return [
                    "view" => VIEW_DIR."security/login.php"
                ];
        }
            

        


        public function users(){

            $this->restrictTo("ROLE_USER");

            $manager = new UserManager();
            $users = $manager->findAllUsers(['registerdate', 'DESC']);

            return [
                "view" => VIEW_DIR."security/users.php",
                "data" => [
                    "users" => $users
                ]
            ];
        }


        public function bannUser($id){

        

            if(isset($_POST['submit'])) {



                $days = filter_input(INPUT_POST, "bannedUntil", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

               

                if($days){

                    $userManager = new UserManager();
                    $userManager->bann($id,$days);

                    $this->redirectTo("security","users");

                }


            }



        }

        public function cancelBannUser($id){

        

                    $userManager = new UserManager();
                    $userManager->cancelBann($id);

                    $this->redirectTo("security","users");




        }


        public function addUser($id){


            if(isset($_POST['submit'])) {

                $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $mail2 = filter_input(INPUT_POST, "mail2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $mdp = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $mdp2 = filter_input(INPUT_POST, "mdp2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($pseudo && $mail && $mail2 && $mdp && $mdp2) {
                   $pseudoLength = strlen($pseudo);
                   if($pseudoLength <= 50) {
                    $userManager = new UserManager();
                    $reqPseudo = $userManager->findPseudo($pseudo);
                        if($reqPseudo == null) {
                            if($mail == $mail2) {
                                if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                                    $reqMail = $userManager->findEmail($mail);
                                    if($reqMail == null) {
                                        if($mdp == $mdp2) {
                                            $mdpLength = strlen($mdp);
                                            if($mdpLength >= 8) {

                                                $dataUser =['pseudo' => $pseudo, 'email' => $mail, 'mdp' => password_hash($mdp, PASSWORD_DEFAULT)];

                                                if($userManager->add($dataUser)){
                                                    Session::addFlash('success', 'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter.');
                                                } else {
                                                    Session::addFlash('error', 'Votre compte n\'a pas été créé ! Problème avec base de donnée !');
                                                }
                                            } else {
                                                Session::addFlash('error', 'Vos mots de passe doit faire minimum 8 caractères !');
                                            }
                                        } else {
                                            Session::addFlash('error', 'Vos mots de passes ne correspondent pas !');
                                        }
                                    } else {
                                        Session::addFlash('error', 'Adresse mail déjà utilisée !');
                                    }
                                } else {
                                    Session::addFlash('error', 'Votre adresse mail n\'est pas valide !'); 
                                }
                            } else {
                                Session::addFlash('error', 'Vos adresses mail ne correspondent pas !');
                            }
                        } else {
                            Session::addFlash('error', 'Votre pseudo est déjà utilisée !');
                         }
                   } else {
                      Session::addFlash('error', 'Votre pseudo ne doit pas dépasser 50 caractères !');
                   }
                } else {
                   Session::addFlash('error', 'Tous les champs doivent être complétés !');
                }
                $this->redirectTo("security","addUser");
            }else{
                
                return [
                    "view" => VIEW_DIR."security/register.php"
                ];
                
            }
            
        }


        public function login(){


            if(isset($_POST['submit'])) {

                $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $mdp = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($mail && $mdp) {

                    $userManager = new UserManager();
                    $user = $userManager->findUserByEmail($mail);

                    if($user) {
                       
                        $hashMdp = $user->getMdp();

                        if(password_verify($mdp, $hashMdp)){


                            if(is_null($user->getBanneduntil())){
                                Session::setUser($user);

                                Session::addFlash('success', 'Connection établie !');
                                $this->redirectTo("home");
                            } else {
                                Session::addFlash('error', 'Désolé vous avez été banni ! Revenez dans '.$user->getTimeBannedRemaining());
                            }
                        } else {
                            Session::addFlash('error', 'Mauvais mot de passe !');
                        }
                    } else {
                       Session::addFlash('error', 'Mail inexistant !');
                    }
                 } else {
                    Session::addFlash('error', 'Tous les champs doivent être complétés !');
                 }
                $this->redirectTo("security","login");
            }else{
                

                return [
                    "view" => VIEW_DIR."security/login.php"
                ];


            }
            
        }



        public function logout(){
            

            unset($_SESSION['user']);


            $this->redirectTo("login");

                
        }


        public function profil($id){
          
            if(Session::getUser()->getId() == $id){
            $userManager = new UserManager();
 
             return [
                 "view" => VIEW_DIR."security/viewAccount.php",
                 "data" => [
                     "user" => $userManager->findOneById($id)
                 ]
             ];

            }else{

                Session::addFlash('error', 'Vous n\'ete pas autorisé à voir ce profil !');
                return [
                    "view" => VIEW_DIR."home.php"
                ];
            }
         
         }


         public function changePassword($id){


            if(isset($_POST['submit']) && Session::getUser()->getId() == $id) {

                $currentPassword = filter_input(INPUT_POST, "current_password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $newPassword = filter_input(INPUT_POST, "new_password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $confirmPassword = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($currentPassword && $newPassword && $confirmPassword) {

                    $userManager = new UserManager();
                    $user = $userManager->findUser($id);
                    $hashPassword = $user->getMdp();


                    if($newPassword == $confirmPassword) {
                        $passwordLength = strlen($newPassword);
                        if($passwordLength >= 8) {
                            if(password_verify($currentPassword, $hashPassword)){
                                $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                                if($userManager->updatePassword( $hashPassword, $id)){

                                    Session::getUser()->setMdp( $hashPassword);
                                    Session::addFlash('success', 'Mots de passe mis à jour !');
                                } else
                                    Session::addFlash('error', 'Problème lors de la mise à jour du mots de passe !');

                            } else {
                                Session::addFlash('error', 'Mauvais mot de passe !');
                            }
                        } else {
                            Session::addFlash('error', 'Vos mots de passe doit faire minimum 8 caractères !');
                        }
                    } else {
                        Session::addFlash('error', 'Vos mots de passes ne correspondent pas !');
                    }
                    
                 } else {
                    Session::addFlash('error', 'Tous les champs doivent être complétés !');
                 }
                $this->redirectTo("security","profil",$id);
            }else{
                

                return [
                    "view" => VIEW_DIR."security/viewAccount.php"
                ];


            }
            
        }

        public function changePseudo($id){


            if(isset($_POST['submit']) && Session::getUser()->getId() == $id) {

                $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($pseudo) {
                    $pseudoLength = strlen($pseudo);
                    if($pseudoLength <= 50) {
                        $userManager = new UserManager();
                        $reqPseudo = $userManager->findPseudo($pseudo);
                        if($reqPseudo == null) {
                    

                            if($userManager->updatePseudo($pseudo, $id)){
                                Session::getUser()->setPseudo($pseudo);
                                Session::addFlash('success', 'Votre pseudo à bien été mise à jour !');
                            } else
                                Session::addFlash('error', 'Problème lors de la mise à jour du pseudo !');

                        } else {
                            Session::addFlash('error', 'Votre pseudo est déjà utilisée !');
                        }
                    } else {
                      Session::addFlash('error', 'Votre pseudo ne doit pas dépasser 50 caractères !');
                    }
                } else {
                    Session::addFlash('error', 'Tous les champs doivent être complétés !');
                }
                $this->redirectTo("security","profil",$id);
            }else{
                

                return [
                    "view" => VIEW_DIR."security/viewAccount.php"
                ];


            }
            
        }


        public function changeEmail($id){


            if(isset($_POST['submit']) && Session::getUser()->getId() == $id) {

                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($email) {

                    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $userManager = new UserManager();
                        $reqEmail = $userManager->findEmail($email);
                        if($reqEmail == null) {
                    

                            if($userManager->updateEmail($email, $id)){
                                Session::getUser()->setEmail($email);
                                Session::addFlash('success', 'Votre email à bien été mise à jour !');
                            } else
                                Session::addFlash('error', 'Problème lors de la mise à jour de votre email !');


                        } else {
                            Session::addFlash('error', 'Cet email est déjà utilisée !');
                        }

                    } else {
                        Session::addFlash('error', 'Votre adresse mail n\'est pas valide !'); 
                    }

                } else {
                    Session::addFlash('error', 'Tous les champs doivent être complétés !');
                }
                $this->redirectTo("security","profil",$id);
            }else{
                

                return [
                    "view" => VIEW_DIR."security/viewAccount.php"
                ];


            }
            
        }


    }