<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>

<html>
<div class="corp">
<img src="titre_img/affich_prof.png" class="position_titre">
<pre>
<?php
$data=mysql_query("select * from prof");
?>
<center><table id="rounded-corner">
<thead><tr><?php echo Edition();?>
 <th scope="col" class="<?php echo rond(); ?>">Nom</th>
 <th scope="col" class="rounded-q2">Prenom</th>
 <th scope="col" class="rounded-q2">Adresse</th>
 <th scope="col" class="rounded-q2">Telephone</th>
 <th scope="col" class="rounded-q2">Matiéres enseignées</th>
 <th scope="col" class="rounded-q4">Classes coordonées</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(5,7); ?>"class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysql_fetch_array($data)){
?>
<tr><?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])){
echo '<tr><td><a href="modif_prof.php?modif_prof='.$a['numprof'].'">modifier</a></td><td><a href="modif_prof.php?supp_prof='.$a['numprof'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">supprimer</a></td>';}
echo '<td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['adresse'].'</td><td>'.$a['telephone'].'</td><td><a href="option_prof.php?matiere='.$a['numprof'].'">Voir</a><td><a href="option_prof.php?classe='.$a['numprof'].'">Voir</a></tr>';
}
?>
<tbody>
</table></center>
<?php
echo '<br/><br/><a href="index.php">Revenir à la page précédente !</a>';
?>
</pre>
</div>
</html>
