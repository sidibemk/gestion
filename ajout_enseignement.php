<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<html>
<div class="corp">
<img src="titre_img/ajout_enseignemt.png" class="position_titre">
<?php
if(isset($_POST['nomcl'])){
$_SESSION['nomcl']=$_POST['nomcl'];
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$promo;//pour l'envoyer la 2eme fois 
$donnee=mysql_query("select codemat,nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$nomcl' and promotion='$promo'");
$prof=mysql_query("select numprof,nom,prenom from prof");
?>
<form action="ajout_enseignement.php" method="POST" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Ajoutet un enseignement<LEGEND>  <pre>
Matiére       :    <select name="choix_mat" id="choix">
<?php
while($a=mysql_fetch_array($donnee)){
   echo '<option value="'.$a['codemat'].'">'.$a['nommat'].'</option>';
}
?>
</select><br/><br/>
Enseignant   :  <select name="n_prof"><?php while($prof2=mysql_fetch_array($prof)){
echo '<option value="'.$prof2['numprof'].'">'.$prof2['nom'].' '.$prof2['prenom'].'</option>';
}
?>
</select><br/><br/>
Semestre       :    <select name="semestre"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<center><input type="image" src="button.png"></center>
</pre></fieldset>
</form>
<?php }
else if(isset($_POST['semestre'])){//s'il a cliquer sur ajouter la 2eme fois
$semestre=$_POST['semestre'];
$codemat=$_POST['choix_mat'];
$nomcl=$_SESSION['nomcl'];
$n_prof=$_POST['n_prof'];//Premier ou 2eme devoir -- 1 ou 2
$promo=$_SESSION['promo'];
$codeclasse=mysql_fetch_array(mysql_query("select codecl from classe where nom='$nomcl' and promotion='$promo'")) ;
$codecl=$codeclasse['codecl'];
/*
 pour ne pas ajouter deux enseignements similaires
 */
$data=mysql_query("select count(*) as nb from enseignement where codecl='$codecl'  and codemat='$codemat' and numsem='$semestre'");
/*
 pour verifier si l'enseignemet (codecl,nommat,numsem) existe ou deja
 */
 
$nb=mysql_fetch_array($data);


$bool=true;
	
	/*
	pour ne pas ajouter deux controles similaire
	*/
	if($nb['nb']>0){
		$bool=false;
		echo '<br\><h2>Erreur d\'insertion!! (impossible d\'ajouter deux enseignements similaires)</h2>';
		?><SCRIPT LANGUAGE="Javascript">alert("Erreur d\'insertion\nimpossible d\'ajouter deux enseignements similaires");</SCRIPT><?php
	}
	if($bool==true){
	mysql_query("insert into enseignement(codecl,codemat,numprof,numsem) values('$codecl','$codemat','$n_prof','$semestre')");
	?> <SCRIPT LANGUAGE="Javascript">	alert("Ajouté avec succés!"); </SCRIPT> <?php
	}
	echo '<br/><br/><a href="ajout_enseignement.php?">Revenir à la page precedente !</a>';
}
 else {
$data=mysql_query("select distinct promotion from classe order by promotion desc");//select pour les promotions
$donnee=mysql_query("select distinct nom from classe"); 
?>
 <form action="ajout_enseignement.php" method="POST" class="formulaire">
 Veuillez choisir la classe et la promotion : <br/><br/>
    <FIELDSET>
 <LEGEND align=top>Critères d'ajout<LEGEND>  <pre>
 Classe          :       <select name="nomcl"> 
<?php while($a=mysql_fetch_array($donnee)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
 Promotion   :     <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>

<center><input type="submit" value="Afficher"></center>
</pre></fieldset>
</form>
<?php } ?>
</center></pre>
</div>
</html>
