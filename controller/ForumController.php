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


           if(Session::getUser())

                return [
                    "view" => VIEW_DIR."forum/listTopics.php",
                    "data" => [
                        "topics" => $topicManager->findAll(["creationdate", "DESC"])
                    ]
                ];

            else

                return [
                    "view" => VIEW_DIR."home.php"
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

                $this->redirectTo("forum", "posts", $id);
        
            }
         
         }



        public function addTopic(){


            if(isset($_POST['submit'])){

                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                

                if($text && $title){

                    $dataTopic=['title' => $title, 'user_id' => Session::getUser()->getId()];

                    $topicManager = new TopicManager();

                    $lastInsertId = $topicManager->add($dataTopic);

                    $dataPost =['text' => $text, 'user_id' => Session::getUser()->getId(), 'topic_id' => $lastInsertId];

                    $postManager = new PostManager();

                    $postManager->add($dataPost);

                    Session::addFlash('success', 'Le topic a bien été créé !');
                    
                }else{

                    Session::addFlash('error', 'Echec lors de la validation ! Erreur dans l\'un des champs.');
    
                }

                $this->redirectTo("forum");
        
            }
         
         }


         public function toggClosed($id){

            $topicManager = new TopicManager();

            $topic = $topicManager->findOneById($id);

            if($topic->getUser()->getId() == Session::getUser()->getId()){

                if($topic->getClosed()){

                    $topicManager->updateClosed($id,0);

                }else{
                    
                    $topicManager->updateClosed($id,1);

                }

            }

            switch ($_GET['from']) {
                case 'posts':
                    $this->redirectTo("post", "posts", $id);
                    break;
                
                case 'forum':
                    $this->redirectTo("forum");
                    break;
            }
            


         }
        

    }
