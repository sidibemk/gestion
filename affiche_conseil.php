<?php
session_start();
include('cadre.php');
$data=mysql_query("select distinct promotion from classe order by promotion desc");
$retour=mysql_query("select distinct nom from classe"); //pour afficher les classe existantes
?>
<div class="corp">
<img src="titre_img/affiche_conseil.png" class="position_titre">
<center><pre>
<?php
if(isset($_GET['supp_conseil'])){
$id=$_GET['supp_conseil'];
mysql_query("delete from conseil where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succés!"); </SCRIPT> <?php
}
else if(isset($_POST['nomcl']) and isset($_POST['numsem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$numsem=$_POST['numsem'];
$donnee=mysql_query("select * from classe,conseil where classe.codecl=conseil.codecl and classe.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$numsem'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
?><center><table id="rounded-corner">
<thead><tr><?php if(isset($_SESSION['admin'])) echo '<th class="rounded-company">Supprimer</th>'; ?>
<th class="<?php echo rond(); ?>">Semestre</th>
<th class="rounded-q4">Classe</th>
</tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(1,2); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysql_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '</td><td><a href="affiche_conseil.php?supp_conseil='.$a['id'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">Supprimer</td>'; } echo '<td>S'.$a['numsem'].'</td><td>'.$a['nom'].'</td></tr>';
}
?>
</tbody>
</table></center>
<?php
}//fin   if(isset($_POST['radio']
else{ ?>

<form method="post" action="affiche_conseil.php" class="formulaire">
Veuillez choisir la classe et la promotion :<br/><br/>
Classe              :       <select name="nomcl"> 
<?php while($a=mysql_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
Promotion        :       <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/>
Semestre           :        <select name="numsem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="Afficher les stages">
</form>
<?php }
?>
<br/><br/><a href="affiche_conseil.php">Revenir à la page précédente !</a>
</pre></center>
</div>
</body>
</html>