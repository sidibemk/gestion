<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<html>
<div class="corp">

<img src="titre_img/ajout_classe.png" class="position_titre">
<center><pre>
<div class="formulaire">

<?php
if(isset($_POST['numprof'])){//s'il a cliquer sur ajouter la 2eme fois
$nomcl=$_POST['nomcl'];
$numprof=$_POST['numprof'];
$promo=$_POST['promotion'];
$compte=mysql_fetch_array(mysql_query("select count(*) as nb from classe where nom='$nomcl' and promotion='$promo'"));
$bool=true;
if($compte['nb']>0){
$bool=false;
echo '<h2>Erreur d\'insertion, l\'enregistrement existe déja </h2>';
}
if($bool==true){
mysql_query("insert into classe(nom,numprofcoord,promotion) values ('$nomcl','$numprof','$promo')");
?> <SCRIPT LANGUAGE="Javascript">	alert("Ajouté avec succés!"); </SCRIPT> <?php
}
echo '<br/><a href="ajout_classe.php">Revenir à la page précédente !</a>';
}
else {
$data=mysql_query("select numprof,nom from prof");//select pour les promotions
 ?>
 <form action="ajout_classe.php" method="POST">
 Nom classe        :       <input type="text" name="nomcl"><br/><br/>
 Promotion            :      <input type="text" name="promotion"><br/><br/>
 Prof coordinataire : <select name="numprof"> <br/><br/>
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['numprof'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="image" src="button.png"></center>
</form>
<br/><a href="index.php">Revenir à la page principale !</a>
</div>
</pre></center>
<?php
}
?>
</div>
</pre>
</center>
</div>
</html>
