
<?php

$user = $result["data"]['user'];
    
?>

<div id="mainTitle">
    <h1>Votre compte utilisateur</h1>
</div>

<p>
<form class="formChangePseudo" action="index.php?ctrl=security&action=ChangePseudo&id=<?= $user->getId() ?>" method="post">
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Votre pseudo</span>
        <input oninput="addInput('submitPseudo','pseudo')" type="text" id="pseudo" name="pseudo" class="form-control" placeholder="<?= $user->getPseudo()  ?>" aria-label="Votre titre" aria-describedby="basic-addon1">
    </div>
    <div class="col-12">
        <button id="submitPseudo" class="btn btn-primary" name="submit" type="submit">Enregistrer la modification</button>
    </div>
</form>
</p>

<p>
<form class="formChangeEmail" action="index.php?ctrl=security&action=ChangeEmail&id=<?= $user->getId() ?>" method="post">
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Votre email</span>
        <input oninput="addInput('submitEmail','email')" type="text" id="email" name="email" class="form-control" placeholder="<?= $user->getEmail()  ?>" aria-label="Votre titre" aria-describedby="basic-addon1">
    </div>
    <div class="col-12">
        <button id="submitEmail" class="btn btn-primary" name="submit" type="submit">Enregistrer la modification</button>
    </div>
</form>
</p>

<p>
<a href="#" onclick = "togg('password')">Changer votre mots de passe</a>
<form class="formChangePassword" id='password' action="index.php?ctrl=security&action=ChangePassword&id=<?= $user->getId() ?>" method="post">
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Votre mots de passe actuel</span>
        <input type="password" id="current_password" name="current_password" class="form-control" placeholder="" aria-label="Votre titre" aria-describedby="basic-addon1">
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Votre nouveau mots de passe</span>
        <input type="password" id="new_password" name="new_password" class="form-control" placeholder="" aria-label="Votre titre" aria-describedby="basic-addon1">
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Retaper votre nouveau mots de passe</span>
        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="" aria-label="Votre titre" aria-describedby="basic-addon1">
    </div>
    <div class="col-12">
        <button class="btn btn-primary" name="submit" type="submit">Valider</button>
    </div>
</form>
</p>

