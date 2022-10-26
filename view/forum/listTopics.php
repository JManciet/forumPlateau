<?php

use Model\Managers\TopicManager;
$topics = $result["data"]['topics'];

?>

<div id="titreTopics">
    <h1>liste topics</h1>
</div>

<?php
foreach($topics as $topic ){
    ?>
    <p>
        <div onclick="location.href='index.php?ctrl=forum&action=posts&id=<?=$topic->getId()?>';" class="topicContainer">
            <div class="topicTitle">
                <div><a href="index.php?ctrl=forum&action=posts&id=<?=$topic->getId()?>"><?=$topic->getTitle()?></a></div>
                <div><?php echo ($topic->getClosed() ?'<i class="fa-solid fa-lock"></i>' :'<i class="fa-solid fa-lock-open"></i>') ?></div>
            </div>
            <div><strong>par ... </strong> le <?=$topic->getCreationdate()?></div>
            <div class="topicNbrPost">
                <div>Nombre de posts : <?php 
                $topicManager = new TopicManager(); 
                echo $topicManager->nbrPostByTopic($topic->getId())["nbrmessage"];;
                ?>
                </div>
                <div><?php

                if($topic->getUser()->getId() == App\Session::getUser()->getId()){

                    if($topic->getClosed()){
                        echo "<span class='badge text-bg-success'><a class='lock' href='index.php?ctrl=forum&action=toggClosed&id=".$topic->getId()."&from=forum'>Dévérouiller le topic</a></span>";
                    }else{
                        echo "<span class='badge text-bg-danger'><a class='lock' href='index.php?ctrl=forum&action=toggClosed&id=".$topic->getId()."&from=forum'>Vérouiller le topic</a></span>";
                    }

                }
                
                ?>
                </div>
            </div>
        </div>
    </p>
    <?php

}  ?>

<h2>Creer un nouveau topic</h2>

<form method="POST" action="index.php?ctrl=forum&action=addTopic">
    <table>
        <tr>
            <td align="right">
                <label for="title">Titre :</label>
            </td>
            <td>
                <input type="text" placeholder="Votre titre" id="title" name="title" />
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="text">Texte :</label>
            </td>
            <td>
                <textarea name="text" id="text"></textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center">
                <br />
                <input type="submit" name="submit" value="Valider" />
            </td>
        </tr>
    </table>
</form>


  
