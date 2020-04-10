<?php
session_start();
include('cadre.php');
?>
<div class="corp">
<img src="titre_img/type_diplome.png" class="position_titre">
<center><pre>
<?php
$donnee=mysql_query("select * from diplome");
?><center><table id="rounded-corner">
<thead><tr><?php if(isset($_SESSION['admin'])) echo '<th class="rounded-company">Supprimer</th>'; ?>
<th class="rounded-q1" >Titre du diplôme</th>
</tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(0,2); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysql_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '<td><a href="type_diplome.php?supp_type='.$a['numdip'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">Supprimer</td>'; } echo '<td>'.$a['titre_dip'].'</td></tr>'; 
}
?>
</tbody>
</table></center>
<br/><br/><a href="index.php">Revenir à la page principale </a>
<?php
if(isset($_GET['supp_type'])){ 
$id=$_GET['supp_type'];
mysql_query("delete from diplome where numdip='$id'"); }
?>
</pre></center>
</div>