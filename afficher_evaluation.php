<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
$data=mysql_query("select distinct promotion from classe order by promotion desc");
?>
<div class="corp">
<img src="titre_img/affich_note.png" class="position_titre"><pre>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$_SESSION['semestre']=$_POST['radiosem'];
$nomcl=$_POST['nomcl'];
$semestre=$_SESSION['semestre'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$_POST['promotion'];
$donnee=mysql_query("select nommat from matiere,enseignement,classe where matiere.codemat=enseignement.codemat and enseignement.codecl=classe.codecl and classe.nom='$nomcl' and promotion='$promo' and enseignement.numsem='$semestre'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
$_SESSION['classe']=$nomcl;
?>
<form method="post" action="afficher_evaluation.php" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Les matiéres correspondantes<LEGEND>  
   <?php
   $i=6;
   while($a=mysql_fetch_array($donnee)){
		echo '<input type="radio" name="radio" value="'.$a['nommat'].'" id="choix'.$i.'" /> <label for="choix'.$i.'">'.$a['nommat'].'</label><br /><br />';
		$i++;
   }
   ?>
<input type="submit" value="Afficher les devoirs">
</fieldset>
</form>
<?php
}
else if(isset($_POST['radio'])){
$semestre=$_SESSION['semestre'];
$nommat=$_POST['radio'];
$_SESSION['radio_matiere']=$nommat;
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$donnee=mysql_query("select numdev,date_dev,nommat,nom,coeficient,numsem,n_devoir from devoir,matiere,classe where matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and classe.nom='$nomcl' and devoir.numsem='$semestre' and matiere.nommat='$nommat' and promotion='$promo'");
?>
<center><h2>Veuilliez choisir le devoir pour lequel vous voulez voir l'evalution</h2><br/><br/>
<table id="rounded-corner">
<thead><tr><th scope="col" class="rounded-company">Evaluation</th><th scope="col" class="rounded-q1">Matiére</th><th scope="col" class="rounded-q2">Date_devoir</th><th scope="col" class="rounded-q3">Classe</th><th scope="col" class="rounded-q3">Coefficient</th><th scope="col" class="rounded-q3">Semestre</th><th scope="col" class="rounded-q4">1er/2eme devoir</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysql_fetch_array($donnee)){
echo '<td><a href="afficher_evaluation.php?affich_eval='.$a['numdev'].'">Voir l\'evaluation</a></td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['nom'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td></tr>';
}
?>
 </tbody>
</table>
<br/><br/><a href="afficher_evaluation.php">Revenir à la page principale !</a></center>
<?php
}//fin   if(isset($_POST['radio']
else if(isset($_GET['affich_eval'])){// si on a cliquer sur voir l'evaluation d'un devoir
//$semestre=$_SESSION['semestre'];
//$nommat=$_SESSION['radio_matiere'];
//$nomcl=$_SESSION['classe'];
//$promo=$_SESSION['promo'];
$numdev=$_GET['affich_eval'];
$donnee=mysql_query("select numeval,date_dev,nommat,nom,nomel,prenomel,note,coeficient,numsem,promotion,n_devoir from devoir,matiere,classe,eleve,evaluation where evaluation.numdev=devoir.numdev and eleve.numel=evaluation.numel and matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and devoir.numdev='$numdev'");//  and matiere.nommat='$nommat'      and devoir.numsem='$semestre'
?>
<center><table id="rounded-corner" >
<thead><?php echo Edition2();?><th class="<?php echo rond2(); ?>">Nom</th>
<th>Prenom</th>
<th>classe</th>
<th>Promotion</th>
<th>Matiere</th>
<th>Date devoir</th>
<th>Coefficient</th>
<th>Semestre</th>
<th>N° de devoir</th>
<th class="rounded-q4">Note</th></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan2(9,11); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysql_fetch_array($donnee)){
?> <tr> <?php
if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ 
echo '<td><a href="modif_eval.php?modif_eval='.$a['numeval'].'">modifier</a></td><td><a href="modif_eval.php?supp_eval='.$a['numeval'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">supprimer</a></td>';}
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td><td>'.$a['note'].'</td></tr>';
}
?>
</tbody>
</table>
<br/><br/><a href="afficher_evaluation.php">Revenir à la page principale !</a></center>
<?php }
else {
$retour=mysql_query("select distinct nom from classe");
?>
<form method="post" action="afficher_evaluation.php" class="formulaire">
Veuillez choisir le Semestre, la promotion et la classe : <br/><br/>
   <FIELDSET>
 <LEGEND align=top>Critères d'affichage<LEGEND>  <pre>
Promotion       :        <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Classe                :        <select name="nomcl"> 
<?php while($a=mysql_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
Semestre          :         <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="Afficher les matieres">
</pre></fieldset>
</form>
<?php } ?>
</pre>
</div>
</body>
</html>