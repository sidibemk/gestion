<?php
session_start();
include('cadre.php');
include('calendrier.html');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<html>
<div class="corp">
<img src="titre_img/ajout_stage.png" class="position_titre">
<center><pre>
<?php if(isset($_SESSION['modif_stage']) and isset($_POST['lieu'])){//si on a cliquer sur ajouter/modifier pour modifier le post pour ne pas entr
	if(!empty($_POST['lieu']) and !empty($_POST['date_debut']) and !empty($_POST['date_fin'])){
		$id=$_SESSION['modif_stage'];
	//	$numel=$_POST['numel'];
		$date_debut=$_POST['date_debut'];
		$date_fin=$_POST['date_fin'];
		$lieu=$_POST['lieu'];
		mysql_query("update stage set lieu_stage='$lieu', date_debut='$date_debut', date_fin='$date_fin' where numstage='$id'");
		?> 	<SCRIPT LANGUAGE="Javascript">alert("Modification avec succes ! ");	</SCRIPT> 	<?php
		unset($_SESSION['modif_stage']);
			echo '<br/><br/><a href="index.php">Revenir à la page d\'accueill !</a>';

	}
	else{
			?> 	<SCRIPT LANGUAGE="Javascript">alert("Veuilliz remplir tous les champs ");	</SCRIPT> 	<?php
		}
}
else if(isset($_POST['lieu'])){		//s'il a cliquer sur ajouter /modifier la 2eme fois pour ajouter
if(!empty($_POST['lieu']) and !empty($_POST['date_debut']) and !empty($_POST['date_fin'])){
	$numel=$_POST['numel'];
	$date_debut=addslashes(Nl2br(Htmlspecialchars($_POST['date_debut'])));//Premier ou 2eme devoir -- 1 ou 2
	$date_fin=addslashes(Nl2br(Htmlspecialchars($_POST['date_fin'])));
	$lieu=addslashes(Nl2br(Htmlspecialchars($_POST['lieu'])));
	$compte=mysql_fetch_array(mysql_query("select count(*) as nb from stage where lieu_stage='$lieu' and numel='$numel' and date_debut='$date_debut' and date_fin='$date_fin'"));
	$bool=true;
	if($compte['nb']>0){
	$bool=false;
	?> 	<SCRIPT LANGUAGE="Javascript">alert("Erreur d\'insertion,le stage existe déja!");	</SCRIPT> 	<?php
	}
	if($bool==true){
	mysql_query("insert into stage(lieu_stage,date_debut,date_fin,numel) values ('$lieu','$date_debut','$date_fin','$numel')");
		?>	<SCRIPT LANGUAGE="Javascript">alert("Ajouté avec succés!");</SCRIPT> 	<?php
	}
	echo '<a href="index.php">Revenir à la page d\'accueill !</a>';
}
else{
?> 	<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	<?php
echo '<a href="index.php">Revenir à la page d\'accueill !</a>';
}
}
else if(!isset($_POST['nomcl']) and !isset($_GET['modif_stage'])){
	$data=mysql_query("select distinct promotion from classe order by promotion desc");//select pour les promotions
	$retour=mysql_query("select distinct nom from classe");
 ?>
 <form action="ajout_stage.php" method="POST" class="formulaire">
 Veuillez choisir la classe et la promotion : <br/><br/>
Promotion         :       <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Classe                :        <select name="nomcl"> 
<?php while($a=mysql_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="submit" value="Suivant"></center>
</form>
<?php }
if((isset($_POST['nomcl']) and isset($_POST['promotion'])) or isset($_GET['modif_stage'])){// si on a cliquer sur suivant ou sur modifier
$id="";
$lieu="";
$date_debut="";
$date_fin="";
if(isset($_GET['modif_stage'])){// si c'est une modification
$id=$_GET['modif_stage'];
$_SESSION['modif_stage']=$id;
$donnee=mysql_fetch_array(mysql_query("select * from stage where numstage='$id'")); //	On selectione les champ qu'on va modifier dans la table stage
$lieu=$donnee['lieu_stage'];
$date_debut=$donnee['date_debut'];
$date_fin=$donnee['date_fin'];
$data=mysql_fetch_array(mysql_query("select numel,nomel,prenomel from eleve where numel=(select numel from stage where numstage='$id')"));// 	on reselectionne le numel pour que ça soit similaire à la requete de l'ajout
}
else{//si c 'est l'ajout
	$_SESSION['promo']=$_POST['promotion'];//pour l'envoyer la 2eme fois 
	$promo=$_POST['promotion'];
	$nomcl=$_POST['nomcl'];
$data=mysql_query("select numel,nomel,prenomel from eleve,classe where classe.codecl=eleve.codecl and nom='$nomcl' and promotion='$promo'");
}
?>
<form action="ajout_stage.php" method="POST" class="formulaire">
Eleve                   :       <?php if(isset($_GET['modif_stage'])){echo $data['nomel'].' '.$data['prenomel'];}else{
?> <select name="numel"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
}?></select><br/><br/> <?php
} ?>

Lieu de stage     :     <input type="text" name="lieu" value="<?php echo $lieu; ?>"><br/><br/>
Date de debut       :        <input type="text" name="date_debut" class="calendrier" value="<?php echo $date_debut; ?>"><br/><br/>
Date de fin        :      <input type="text" name="date_fin" class="calendrier" value="<?php echo $date_fin; ?>"><br/><br/>
<center><input type="image" src="button.png"></center>
</form>
<?php } ?>
</pre></center>
</div>
</html>
