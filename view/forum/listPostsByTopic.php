<?php

$posts = $result["data"]['res']['posts'];
$topic = $result["data"]['topic'];

$paginator  = $result["data"]['res']['paginator'];
$currentPage= $paginator['page'];
$start      = $paginator['start'];
$totalPages = $paginator['totalPages'];
$next       = $paginator['next'];
$prev       = $paginator['prev'];
?>

<div id="mainTitle">
    <h1>liste posts <?php echo ($topic->getClosed() ?'<i class="fa-solid fa-lock"></i>' :'<i class="fa-solid fa-lock-open"></i>') ?></h1>
</div>

<div id="postTitle">
    <h2><?= $topic->getTitle() ?></h2>
</div>

<?php
if($posts!=null)

    foreach($posts as $post){
        ?>
        <div class="postContainer">
            <strong>Par <a href="index.php?ctrl=forum&action=user&id=<?=$post->getUser()->getId()?>"><?=$post->getPseudo()?></a></strong> le <?=$post->getDatePost()?>
            <p><?=$post->getText()?></p>
        </div>
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


<nav>
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="index.php?ctrl=forum&action=paginationPosts&page=<?= $currentPage - 1 ?>&id=<?= $topic->getId() ?>" class="page-link">Précédente</a>
        </li>
        <?php for($page = 1; $page <= $totalPages; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="index.php?ctrl=forum&action=paginationPosts&page=<?= $page ?>&id=<?= $topic->getId() ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $totalPages) ? "disabled" : "" ?>">
            <a href="index.php?ctrl=forum&action=paginationPosts&page=<?= $currentPage + 1 ?>&id=<?= $topic->getId() ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>

<h2>Creer un nouveau post</h2>

<form method="POST" action="index.php?ctrl=forum&action=addPost&id=<?=$_GET['id']?>">
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


<?php
   }  else {
 ?>

<h2>Topic fermé</h2>

<?php
    }
 ?>
