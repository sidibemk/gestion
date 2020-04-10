<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<div class="corp">
<img src="titre_img/ajout_matiere.png" class="position_titre">
<div class="formulaire">
<pre>
<?php
if(isset($_POST['promotion'])){
$_SESSION['promo']=$_POST['promotion'];//pour l'envoyer la 2eme fois 
$_SESSION['nomcl']=$_POST['nomcl'];
?>
<form action="ajout_matiere.php" method="POST" >
Veuillez saisir la nouvelle matiére : <br/><br/>
Matiére       :      <input type="text" name="nommat"><br/><br/>
<center><input type="image" src="button.png"></center>
</form>
<?php }
else if(isset($_POST['nommat'])){//s'il a cliquer sur ajouter la 2eme fois
	if($_POST['nommat']!=""){
		$nomcl=$_SESSION['nomcl'];
		$nommat=addslashes(Htmlspecialchars($_POST['nommat']));
		$promo=$_SESSION['promo'];
		$codeclasse=mysql_fetch_array(mysql_query("select codecl from classe where nom='$nomcl' and promotion='$promo'"));
		$codecl=$codeclasse['codecl'];
		$compte=mysql_fetch_array(mysql_query("select count(*) as nb from matiere where nommat='$nommat' and codecl='$codecl'"));
		$bool=true;
		if($compte['nb']>0){
			$bool=false;
			?> <SCRIPT LANGUAGE="Javascript">	alert("Erreur d\'insertion, l\'enregistrement existe déja"); </SCRIPT> <?php
		}
		if($bool==true){
			mysql_query("insert into matiere(nommat,codecl) values ('$nommat','$codecl')");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Ajouté avec succés!"); </SCRIPT> <?php
		}
	}
	else {
	?> <SCRIPT LANGUAGE="Javascript">	alert("Veuilliez remplire tous les champs!"); </SCRIPT> <?php
	}
	echo '<a href="Ajout_matiere.php">Revenir à la page précédente !</a>';
}
 else{
$data=mysql_query("select distinct promotion from classe order by promotion desc");//select pour les promotions
$nomclasse=mysql_query("select distinct nom from classe");
 ?>
 <form action="ajout_matiere.php" method="POST">
 Promotion        :             <select name="promotion"> 
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Classe                 :         <select name="nomcl"> 
<?php while($a=mysql_fetch_array($nomclasse)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="submit" value="Suivant"></center>
</form>
<?php } ?>
</pre>
</div>
</div>
</html>
