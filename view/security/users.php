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
                </tr>

        <?php } ?>
    </tbody>
</table>