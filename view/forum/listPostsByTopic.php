<?php

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>

<h1>liste posts <?php echo ($topic->getClosed() ?'<i class="fa-solid fa-lock"></i>' :'<i class="fa-solid fa-lock-open"></i>') ?></h1>

<?php
if($posts!=null)

    foreach($posts as $post){
        ?>
        <strong>Par <?=$post->getPseudo()?></strong> le <?=$post->getDatePost()?>
        <p><?=$post->getText()?></p>
        <?php
    }
 else {
    echo "<p>aucune réponse</p>";
 }
 ?>
<div>
    <?php

    if($topic->getUser()->getId() == App\Session::getUser()->getId()){

        if($topic->getClosed()){
            echo "<span class='badge text-bg-success'><a class='lock' href='index.php?ctrl=forum&action=toggClosed&id=".$topic->getId()."&from=posts'>Dévérouiller le topic</a></span>";
        }else{
            echo "<span class='badge text-bg-danger'><a class='lock' href='index.php?ctrl=forum&action=toggClosed&id=".$topic->getId()."&from=posts'>Vérouiller le topic</a></span>";
        }

    }
    
    ?>
</div>
<?php
if(!$topic->getClosed()){
        ?>

<h2>Creer un nouveau post</h2>

<form method="POST" action="index.php?ctrl=forum&action=addPost&id=<?=$_GET['id']?>">
    <table>
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


<?php
   }  else {
 ?>

<h2>Topic fermé</h2>

<?php
    }
 ?>
