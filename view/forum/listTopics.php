<?php

$topics = $result["data"]['topics'];
    
?>

<h1>liste topics</h1>

<?php
foreach($topics as $topic ){

    ?>
    <p>
    <div><a href="index.php?ctrl=post&action=posts&id=<?=$topic->getId()?>"><?=$topic->getTitle()?></a></div>
    <div><?=$topic->getCreationdate()?></div>
    <div>Nombre de reponse ??</div>
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


  
