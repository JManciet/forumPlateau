<?php

$users = $result["data"]['users'];
    
?>


<h1>Liste utilisateurs</h1>


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
            foreach($users as  $user) { ?>
                <tr>
                    <td><?= $user->getPseudo() ?></td>
                    <td><?= $user->getRole() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getRegisterdate() ?></td>
                    <td>
                        <?php 
                        if($user->getRole()!="ROLE_ADMIN"){ ?>
                        <form action="" method="get">
                            <input type="date" name="banneduntil" id="banneduntil">
                            <input type="submit" value="valider">
                        </form>

                        <?php }?>
                    </td>
                </tr>

        <?php } ?>
    </tbody>
</table>