<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<div class="corp">
<img src="titre_img/ajout_conseil.png" class="position_titre">
<pre>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$semestre=$_POST['radiosem'];
$code_classe=mysql_fetch_array(mysql_query("select codecl from classe where nom='$nomcl' and promotion='$promo'"));
$codecl=$code_classe['codecl'];


$compte=mysql_fetch_array(mysql_query("select count(*) as nb from conseil where numsem='$semestre' and codecl='$codecl'"));
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">alert("erreur! Ce conseil existe déja ");</SCRIPT>
<?php
}
else{
mysql_query("insert into conseil(numsem,codecl) values ('$semestre','$codecl')");
/*
 a la veille de chaque conseil de classe :   on suppose qu'un etudiant passe 2 devoir dans la même matiére dans un semestre,on specifie le semestre dans la requete,alors si on regroup par numel et codemat on va trouver au max 2 notes
*/
$bulletin=mysql_query("select eleve.numel,matiere.codemat,avg(note) as moyen from eleve,devoir,matiere,evaluation,classe where matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and devoir.numdev=evaluation.numdev and evaluation.numel=eleve.numel and devoir.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$semestre' group by numel,matiere.codemat");
while($b=mysql_fetch_array($bulletin)){
$numel=$b['numel'];
$codemat=$b['codemat'];
$notef=$b['moyen'];
mysql_query("insert into bulletin(numsem,numel,codemat,notefinal) values('$semestre','$numel','$codemat','$notef')");
}
?>	<SCRIPT LANGUAGE="Javascript">alert("Ajouté avec succés!");</SCRIPT> 	<?php
}
?>
<br/><br/><a href="ajout_conseil.php">Revenir à la page precedente !</a>
</form>

<?php
}
else {
$data=mysql_query("select distinct promotion from classe order by promotion desc");
$retour=mysql_query("select distinct nom from classe"); // afficher les classes
?>
<form method="post" action="ajout_conseil.php" class="formulaire">
Veuillez choisir le Semestre, la promotion et la classe :<br/><br/><br/>
Promotion      :       <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Classe              :       <select name="nomcl"> 
<?php while($a=mysql_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
Semestre        :        <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="Valider le conseil">
</form>
<?php } ?>
</pre>
</div>
</body>
</html>