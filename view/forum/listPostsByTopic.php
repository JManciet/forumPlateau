<?php

$posts = $result["data"]['posts'];
    
?>

<h1>liste posts</h1>

<?php
if($posts!=null)

    foreach($posts as $post){
        ?>
        <p><?=$post->getText()?></p>
        <?php
    }
 else {
    echo "<p>aucune réponse</p>";
 }
 ?>

<h2>Creer un nouveau post</h2>

<form method="POST" action="index.php?ctrl=post&action=addPost&id=<?=$_GET['id']?>">
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

