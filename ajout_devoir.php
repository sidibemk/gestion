<?php
session_start();
include('cadre.php');
include('calendrier.html');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<html>
<div class="corp">
<center><pre><img src="titre_img/ajout_devoir.png" class="position_titre">
<form action="ajout_devoir.php" method="POST" class="formulaire">
<?php
if(isset($_POST['nomcl'])){
$_SESSION['nomcl']=$_POST['nomcl'];
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$promo;
$donnee=mysql_query("select codemat,nommat from matiere,classe where matiere.codecl=classe.codecl and nom='$nomcl' and promotion='$promo'");
?>
<FIELDSET>
<LEGEND align=top>Ajouter un devoir<LEGEND><pre>
Matiére                   :          <select name="choix_mat" id="choix">
<?php
while($a=mysql_fetch_array($donnee)){
   echo '<option value="'.$a['codemat'].'">'.$a['nommat'].'</option>';
}
?>
</select><br/><br/>
Date du devoir        :              <input type="text" name="date" class="calendrier"><br/></br/>
Coefficient              :       <select name="coefficient"><?php for($i=1;$i<=15;$i++){ echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
</select><br/><br/>
Semestre                  :      <select name="semestre"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/>
1er / 2ème Devoir    :       <input type="radio" name="devoir" value="1" id="choix1" /> <label for="choix1">1er devoir</label>
                                          <input type="radio" name="devoir" value="2" id="choix2" /> <label for="choix2">2eme devoir</label><br/>
<center><input type="image" src="button.png"></center>
</pre></fieldset>
</form>
<?php }
else if(isset($_POST['date'])){//s'il a cliquer sur ajouter la 2eme fois
$date=addslashes(Nl2br(Htmlspecialchars($_POST['date'])));
$coefficient=$_POST['coefficient'];
$semestre=$_POST['semestre'];
$codemat=$_POST['choix_mat'];
$nomcl=$_SESSION['nomcl'];
$n_devoir=$_POST['devoir'];//Premier ou 2eme devoir -- 1 ou 2
$promo=$_SESSION['promo'];
/*
 pour ne pas ajouter deux controles similaire
 */
$data=mysql_query("select count(*) as nb from devoir where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and codemat='$codemat' and numsem='$semestre' and n_devoir='$n_devoir'");
/*
 pour verifier si l'enseignemet (codecl,nommat,numsem) existe ou  pas
 */
$valider=mysql_query("select count(*) as nb from enseignement where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and codemat='$codemat' and numsem='$semestre'");

$nb=mysql_fetch_array($data);

$nb2=mysql_fetch_array($valider);

$bool=true;

	/*
	pour verifier si l'enseignemet (codecl,nommat,numsem) existe ou  pas
	*/
	if($nb2['nb']!=0){
		$bool=false;
		echo '<br\><h2>Erreur d\'insertion!! Cet enseignement n\'existe pas </h2>';
	}
	/*
	pour ne pas ajouter deux controles similaire
	*/
	if($nb['nb']>0){
		$bool=false;
		echo '<br\><h2>Erreur d\'insertion!! N° de devoir incorrect(impossible d\'ajouter deux devoirs similaires)</h2>';
	}
	if($bool==true){
	$codeclasse=mysql_query("select codecl from classe where nom='$nomcl' and promotion='$promo'");
	$code=mysql_fetch_array($codeclasse);
	$codecl=$code['codecl'];
	mysql_query("insert into devoir(date_dev,coeficient,codemat,codecl,numsem,n_devoir) values('$date','$coefficient','$codemat','$codecl','$semestre','$n_devoir')");
	echo '<h1>Insertion avec succés </h1>';
	}
}
 else {
 $retour=mysql_query("select distinct nom from classe"); 
 $data=mysql_query("select distinct promotion from classe order by promotion desc");
 ?>
 <form action="ajout_devoir.php" method="POST">
    <FIELDSET>
 <LEGEND align=top>Classe/promotion<LEGEND>  <pre>
Promotions      :        <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Classe               :         <select name="nomcl"> 
<?php while($a=mysql_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="submit" value="Suivant"></center>
</pre></fieldset>
</form>
<?php } ?>
</pre></center>
</div>
</html>
