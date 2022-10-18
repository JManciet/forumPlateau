<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class LoginController extends AbstractController implements ControllerInterface{

        public function index(){
            
                return [
                    "view" => VIEW_DIR."security/login.php"
                ];
        }
            

        public function connection(){


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
                        } else {
                            Session::addFlash('error', 'Mauvais mot de passe !');
                        }
                    } else {
                       Session::addFlash('error', 'Mail inexistant !');
                    }
                 } else {
                    Session::addFlash('error', 'Tous les champs doivent être complétés !');
                 }
                $this->redirectTo("login");
            }
            
        }



    }