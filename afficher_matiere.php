<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<html>
<body>
<div class="corp">
<img src="titre_img/affich_matiere.png" class="position_titre">
<pre>
<?php if(isset($_GET['nomcl'])){
$_SESSION['nomcl']=$_GET['nomcl'];
$nomcl=$_GET['nomcl'];
$data=mysql_query("select promotion from classe where nom='$nomcl' order by promotion desc");
?>
<form method="post" action="afficher_matiere.php" class="formulaire">
Veuillez choisir la promotion et le semestre pour <?php echo $nomcl; ?><br /><br />
   <FIELDSET>
 <LEGEND align=top>Crit�res d'affichage<LEGEND>  <pre>
Promotion      :      <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Semestre         :      <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="Afficher les matieres">
</pre></fieldset>
</form>
<br/><br/><a href="index.php">Revenir � la page principale</a>
<?php }  ?>
<?php
if(isset($_POST['radiosem'])){
$nomcl=$_SESSION['nomcl'];
$semestre=$_POST['radiosem'];
$promo=$_POST['promotion'];
$donnee=mysql_query("select matiere.codemat,nommat,classe.nom,numsem,prof.nom as nomprof from matiere,enseignement,classe,prof where matiere.codemat=enseignement.codemat and prof.numprof=enseignement.numprof and enseignement.codecl=classe.codecl and classe.nom='$nomcl' and enseignement.numsem='$semestre' and promotion='$promo'");
?>
<center><table id="rounded-corner"><thead>
<tr><?php echo Edition(); ?>
<th class="<?php echo rond(); ?>">Mati�re</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">Nom prof</th>
<th class="rounded-q4">Semestre</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(3,5); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
   <p>
   <?php
   while($a=mysql_fetch_array($donnee)){
  if(isset($_SESSION['admin'])){ echo '<tr><td><a href="modif_matiere.php?modif_matiere='.$a['codemat'].'">modifier</a></td><td><a href="modif_matiere.php?supp_matiere='.$a['codemat'].'" onclick="return(confirm(\'Etes-vous s�r de vouloir supprimer cette entr�e?\'));">supprimer</a></td>'; } echo '<td>'.$a['nommat'].'</td><td >'.$a['nom'].'</strong></td><td>'.$a['nomprof'].'</td><td>S'.$a['numsem'].'</td></tr>';
   }
   ?>
   </p>
</tbody>
</table></center>
<?php 
echo '<br/><br/><a href="afficher_matiere.php?nomcl='.$nomcl.'">Revenir � la page principale</a>';
} ?>
</div>
</pre>

</body>
</html>