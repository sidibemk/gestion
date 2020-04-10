<?php
session_start();
include('cadre.php');
$data=mysql_query("select distinct promotion from classe order by promotion desc");

?>
<div class="corp">
<img src="titre_img/affich_bulletin.png" class="position_titre">
<pre>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$semestre=$_POST['radiosem'];
$matiere=mysql_query("select matiere.codemat,nommat from enseignement,matiere where enseignement.codemat=matiere.codemat and enseignement.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$semestre'");
echo '<form method="post" action="afficher_bulettin.php" class="formulaire">';
echo 'Veuillez choisir la matiere pour  : '.$nomcl.' '.$promo.'<br/><br/><br/>';
?>
<FIELDSET>
 <LEGEND align=top> Matiéres étudiées </LEGEND>  
 Matiére      :       <select name="codemat"> 
<?php while($c=mysql_fetch_array($matiere)){
echo '<option value="'.$c['codemat'].'">'.$c['nommat'].'</option>';
}?></select>
<input type="hidden" name="nomclasse" value="<?php echo $nomcl; ?>">
<input type="hidden" name="promo" value="<?php echo $promo; ?>">
<input type="hidden" name="semestre" value="<?php echo $semestre; ?>">
<input type="submit" value="Afficher les notes finals">
</FIELDSET>
<br/><br/><a href="afficher_bulettin.php">Revenir à la page precedente !</a>
</form>

<?php
}
else if(isset($_POST['codemat'])){//apres avoir choisis la matiere on affiche les notes
$nomcl=$_POST['nomclasse'];//GI
$semestre=$_POST['semestre'];//4
$promo=$_POST['promo'];//2009
$codemat=$_POST['codemat'];//5
/*		selectionner tout les devoir pour la classe choisis dans le semestre choisis			*/
$dev1=mysql_query("select nomel,prenomel,nom,promotion,nommat,numsem,notefinal from eleve,classe,matiere,bulletin where eleve.numel=bulletin.numel and classe.codecl=eleve.codecl and matiere.codemat=bulletin.codemat and matiere.codemat='$codemat' and numsem='$semestre' and eleve.numel in (select numel from eleve where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo'))");
?><center>
<table id="rounded-corner">
<thead><tr><th class="rounded-company">Nom</th>
<th class="rounded-q1">Prenom</th>
<th class="rounded-q3">classe</th>
<th class="rounded-q3">Promotion</th>
<th class="rounded-q3">Matiere</th>
<th class="rounded-q3">Semestre</th>
<th class="rounded-q4">Note Final</th></tr></thead>
<tfoot>
<tr><td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td></tr>
</tfoot>
 <tbody>
 <?php
   while($a=mysql_fetch_array($dev1)){
    echo '<tr><td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td >'.$a['nom'].'</td><td >'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['numsem'].'</td><td>'.$a['notefinal'].'</td></tr>';
   }
   ?>

 </tbody>
</table></center>
<br/><br/><a href="afficher_bulettin.php">Revenir à la page precedente !</a>
<?php
}
else {
$retour=mysql_query("select distinct nom from classe"); // afficher les classes
?>
<form method="post" action="afficher_bulettin.php" class="formulaire">
Veuillez choisir le Semestre, la promotion et la classe :<br/><br/><br/>
<FIELDSET>
 <LEGEND align=top>Critères d'affichage<LEGEND>  
<pre>Promotion      :       <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Classe              :       <select name="nomcl"> 
<?php while($a=mysql_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
Semestre        :        <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="Afficher les matieres">
</pre>
</FIELDSET>
</form>
<?php } ?>
</pre>
</div>
</body>
</html>