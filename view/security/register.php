<h1>register</h1>

<form method="POST" action="index.php?ctrl=security&action=addUser">
	            <table>
	               <tr>
	                  <td align="right">
	                     <label for="pseudo">Pseudo :</label>
	                  </td>
	                  <td>
	                     <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
	                  </td>
	               </tr>
	               <tr>
	                  <td align="right">
	                     <label for="mail">Mail :</label>
	                  </td>
	                  <td>
	                     <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
	                  </td>
	               </tr>
	               <tr>
	                  <td align="right">
	                     <label for="mail2">Confirmation du mail :</label>
	                  </td>
	                  <td>
	                     <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
	                  </td>
	               </tr>
	               <tr>
	                  <td align="right">
	                     <label for="mdp">Mot de passe :</label>
	                  </td>
	                  <td>
	                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
	                  </td>
	               </tr>
	               <tr>
	                  <td align="right">
	                     <label for="mdp2">Confirmation du mot de passe :</label>
	                  </td>
	                  <td>
	                     <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
	                  </td>
	               </tr>
	               <tr>
	                  <td></td>
	                  <td align="center">
	                     <br />
	                     <input type="submit" name="submit" value="Je m'inscris" />
	                  </td>
	               </tr>
	            </table>
	         </form>