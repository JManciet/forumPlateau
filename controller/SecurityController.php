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
            $users = $manager->findAll(['registerdate', 'DESC']);

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

                            Session::setUser($user);

                            Session::addFlash('success', 'Connection établie !');
                            $this->redirectTo("home");

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
          
            $userManager = new UserManager();
 
             return [
                 "view" => VIEW_DIR."security/viewProfile.php",
                 "data" => [
                     "user" => $userManager->findOneById($id)
                 ]
             ];
         
         }


    }