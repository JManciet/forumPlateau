<?php

$users = $result["data"]['users'];
    
?>

<div id="mainTitle">
    <h1>Liste des utilisateurs</h1>
</div>

<table class='table table-striped'>
    <thead>
        <tr>
            <th>PSEUDO</th>
            <th>ROLE</th>
            <th>EMAIL</th>
            <th>DATE D'INSCRIPTION</th>
            <th>BANNISSEMENT</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($users as  $user) { 
                
                ?>
                <tr>
                    <td><a href="index.php?ctrl=forum&action=user&id=<?=$user->getId()?>"><?= $user->getPseudo() ?></a></td>
                    <td><?= $user->getRole() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getRegisterdate() ?></td>
                    <td>
                        <?php 
                        if($user->getRole()!="ROLE_ADMIN"){ 
                            if(is_null($user->getBanneduntil())){?>

                                <a href="#" onclick = "togg(<?= $user->getId() ?>)">Bannir ce membre ?</a>

                                <form class="formAddBan" id='<?= $user->getId() ?>' action="index.php?ctrl=security&action=bannUser&id=<?= $user->getId() ?>" method="post">
                                    Pour une durrée de <input type="number" name="bannedUntil" id="bannedUntil"> jours.
                                    <input type="submit" name="submit" value="valider">
                                </form>

                        <?php 
                            } else{
                                
                              
                                ?>

                                <span>Banni encore <?= $user->getTimeBannedRemaining() ?></span>
                                <a href="index.php?ctrl=security&action=cancelBannUser&id=<?= $user->getId() ?>" >Annuler bannissement</a>



                        <?php

                            }
                        }?>
                    </td>
                </tr>

        <?php } ?>
    </tbody>
</table>