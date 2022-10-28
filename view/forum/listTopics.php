<?php

$topics = $result["data"]['res']['topics'];

$paginator  = $result["data"]['res']['paginator'];
$currentPage= $paginator['page'];
$start      = $paginator['start'];
$totalPages = $paginator['totalPages'];
$next       = $paginator['next'];
$prev       = $paginator['prev'];

?>

<div id="mainTitle">
    <h1>liste des topics</h1>
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
            <div><strong>par <a href="index.php?ctrl=forum&action=user&id=<?=$topic->getUser()->getId()?>"><?=$topic->getPseudo()?></a> </strong> le <?=$topic->getCreationdate()?></div>
            <div class="topicNbrPost">
                <div>Nombre de posts : <?= $topic->getNbPosts() ?>
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

<nav>
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="index.php?ctrl=forum&action=paginationTopics&id=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
        </li>
        <?php for($page = 1; $page <= $totalPages; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="index.php?ctrl=forum&action=paginationTopics&id=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $totalPages) ? "disabled" : "" ?>">
            <a href="index.php?ctrl=forum&action=paginationTopics&id=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>

<h2>Creer un nouveau topic</h2>

<form method="POST" action="index.php?ctrl=forum&action=addTopic">
    
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Titre</span>
        <input type="text" id="title" name="title" class="form-control" placeholder="Votre titre" aria-label="Votre titre" aria-describedby="basic-addon1">
    </div>
    <div class="input-group">
        <span class="input-group-text">Votre texte</span>
        <textarea class="form-control" aria-label="Votre texte" name="text" id="text"></textarea>
    </div>
    <br>
    <div class="col-12">
        <button class="btn btn-primary" name="submit" type="submit">Valider</button>
    </div>
    <br>
            
</form>


  
