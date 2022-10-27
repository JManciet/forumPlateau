<?php

$user = $result["data"]['user'];
    
?>

<div id="mainTitle">
    <h1>Profil de <?= $user->getPseudo() ?></h1>
</div>
<p>
    Inscrit depuis le <?= $user->getRegisterdate() ?>
</p>
<p>
    Nombre de topics <?= $user->getNbTopics() ?>
</p>
<p>
    Nombre de posts <?= $user->getNbPosts() ?>
</p>