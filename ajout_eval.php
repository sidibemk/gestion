<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<html>
<body>
<div class="corp">
<pre>
<img src="titre_img/ajout_eval.png" class="position_titre">
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
<form method="post" action="ajout_eval.php" class="formulaire">
Veuillez choisr la matiére : <br/><br/>
   <?php
   $i=6;
   while($a=mysql_fetch_array($donnee)){
		echo '<input type="radio" name="radio" value="'.$a['nommat'].'" id="choix'.$i.'" /> <label for="choix'.$i.'">'.$a['nommat'].'</label><br /><br />';
		$i++;
   }
   ?>
<input type="submit" value="Afficher les devoirs">
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
?><center><table id="rounded-corner">
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
echo '<td><a href="ajout_eval.php?ajout_eval='.$a['numdev'].'">Ajouter evaluation</a></td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['nom'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td></tr>';
}
?>
 </tbody>
</table>
<br/><br/><a href="ajout_eval.php">Revenir à la page principale !</a></center>
<?php
}//fin   if(isset($_POST['radio']
else if(isset($_POST['numel'])){ // l'insertion, on recupere le numel et la note avec les autres session et on insert
$numel=$_POST['numel'];
$numdev=$_POST['numdev'];
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$note=str_replace(",",".",$_POST['note']);//replacer les , par . car c double
/*$codecl=mysql_fetch_array(mysql_query("select codecl from classe where nom='$nomcl' and promotion='$promo'"));
$codecl=$codecl['codecl'];*/
$compte=mysql_fetch_array(mysql_query("select count(*) as nb from evaluation where numdev='$numdev' and numel='$numel'"));//pour ne pas repeter le meme enregistrement
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">
alert("erreur d\'insertion, l\'enregistrement existe deja !");
</SCRIPT>
<br/><br/><a href="ajout_eval.php">Revenir à la page principale </a>
<?php
}
else{
mysql_query("insert into evaluation(numdev,numel,note) values('$numdev','$numel','$note')");
?>
<SCRIPT LANGUAGE="Javascript">
alert("Ajout avec succés!");
</SCRIPT>
<br/><br/><a href="ajout_eval.php">Revenir à la page principale </a>
<?php
}
}
else if(isset($_GET['ajout_eval'])){// si on a cliquer sur voir l'evaluation d'un devoir
$semestre=$_SESSION['semestre'];
$nommat=$_SESSION['radio_matiere'];
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$numdev=$_GET['ajout_eval'];
$donnee=mysql_fetch_array(mysql_query("select date_dev,coeficient,n_devoir from devoir where numdev='$numdev'"));//  pour afficher les information du devoir k'il a choisis pour ajouter un devoir
$data=mysql_query("select numel,nomel,prenomel from eleve where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo')");//pour afficher les etudiants
?>
<form method="POST" action="ajout_eval.php" class="formulaire">
Filiére                 :          <?php echo $nomcl.' - '.$promo; ?><br/>
Matiére                :           <?php echo $nommat; ?><br/>
Semestre               :           S<?php echo $semestre; ?><br/>
Date devoir           :           <?php echo $donnee['date_dev']; ?><br/>
Coefficient            :          <?php echo $donnee['coeficient']; ?><br/>
Devoir N°              :           <?php echo $donnee['n_devoir']; ?><br/>
Etudiant               :        <select name="numel"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
}?></select><br/>
Note                       :         <input type="text" name="note">
<input type="hidden" name="numdev" value="<?php echo $numdev; ?>">
<input type="image" src="button.png" style="margin-top:13px;">
</form>
<br/><br/><a href="ajout_eval.php">Revenir à la page principale !</a>
<?php }
else {
$data=mysql_query("select distinct promotion from classe order by promotion desc");
?>
<h2>Veuillez choisir le Semestre, la promotion et la classe :</h2></br>
<form method="post" action="ajout_eval.php" class="formulaire">
Promotion       :         <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/>
<?php
$data=mysql_query("select distinct nom from classe"); ?>

Classe                :        <select name="nomcl"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/>
Semestre           :        <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/><br /><br />
<input type="submit" value="Afficher les matieres">
</form>
<?php } ?>
</pre></center>
</div>
</body>
</html>