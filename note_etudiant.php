<?php
session_start();
include('cadre.php');
if(isset($_SESSION['etudiant'])){
$id=$_SESSION['etudiant'];
$data=mysql_query("select bulletin.numel,nomel,prenomel,nommat,numsem,promotion,notefinal,nom from matiere,bulletin,eleve,classe where classe.codecl=eleve.codecl and bulletin.numel=eleve.numel and matiere.codemat=bulletin.codemat and eleve.numel='$id' order by numsem");
?>
<div class="corp">
<img src="titre_img/affich_stage.png" class="position_titre">
<pre>
<center><table id="rounded-corner">
<thead><tr><th class="rounded-company">Nom</th>
<th class="rounded-q2">Prenom</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q2">Matiére</th>
<th class="rounded-q2">note final</th>
<th class="rounded-q4">Semestre</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysql_fetch_array($data)){
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['notefinal'].'</td><td>S'.$a['numsem'].'</td></tr>';
}
?>
</tbody>
</table></center>
<br/><br/><a href="index.php">Revenir à la page précédente !</a>
</pre></center>
</div>
<?php } ?>
</html>