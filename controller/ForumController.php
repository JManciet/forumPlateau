<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["creationdate", "DESC"])
                ]
            ];
        
        }


        public function addTopic(){


            if(isset($_POST['submit'])){

                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                

                if($text && $title){

                    $dataTopic=['title' => $title, 'user_id' => 1];

                    $topicManager = new TopicManager();

                    $lastInsertId = $topicManager->add($dataTopic);

                    $dataPost =['text' => $text, 'user_id' => 1, 'topic_id' => $lastInsertId];

                    $postManager = new PostManager();

                    $postManager->add($dataPost);

                    Session::addFlash('success', 'Le topic a bien été créé !');

                    $this->redirectTo("forum", "listTopic");
                    
                }else{

                    Session::addFlash('error', 'Echec lors de la validation ! Erreur dans l\'un des champs.');

                    $this->redirectTo("forum", "listTopic");
    
                }
        
            }
         
         }

        

    }
