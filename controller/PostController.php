<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class PostController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $postManager = new PostManager();

            return [
                "view" => VIEW_DIR."forum/listPostsByTopic.php",
                "data" => [
                    "posts" => $postManager->findAllById("topic", 2)
                ]
            ];
        
        }

        public function posts($id){
          
            $postManager = new PostManager();
            $topicManager = new TopicManager();

             return [
                 "view" => VIEW_DIR."forum/listPostsByTopic.php",
                 "data" => [
                     "posts" => $postManager->findAllById("topic", $id),
                     "topic" => $topicManager->findOneById($id)
                 ]
             ];
         
         }


         public function addPost($id){

            if(isset($_POST['submit'])){

                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($text){

                    $postManager = new PostManager();

                    $data=['text' => $text, 'user_id' => Session::getUser()->getId(), 'topic_id' => $id];

                    $postManager->add($data);

                    Session::addFlash('success', 'Le message a bien été posté !');
                    
                }else{

                    Session::addFlash('error', 'Echec lors de la validation ! Erreur dans l\'un des champs.');
    
                }

                $this->redirectTo("post", "posts", $id);
        
            }
         
         }

        

    }