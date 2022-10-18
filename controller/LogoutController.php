<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class LogoutController extends AbstractController implements ControllerInterface{

        public function index(){
            

            session_destroy();


            $this->redirectTo("login");

                
        }
            

        

    }