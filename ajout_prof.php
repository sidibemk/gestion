<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<html>
<div class="corp">
<img src="titre_img/ajout_prof.png" class="position_titre">
<center><pre>
<?php
if(isset($_POST['adresse'])){//s'il a cliquer sur ajouter la 2eme fois
if($_POST['nom']!="" and $_POST['prenom']!="" and $_POST['adresse']!="" and $_POST['telephone']!="" and $_POST['pseudo']!="" and $_POST['passe']!=""){
$nom=addslashes($_POST['nom']);
$prenom=addslashes($_POST['prenom']);//Premier ou 2eme devoir -- 1 ou 2
$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
$telephone=$_POST['telephone'];
$pseudo=$_POST['pseudo'];
$passe=$_POST['passe'];
$compte=mysql_fetch_array(mysql_query("select count(*) as nb from prof where nom='$nom' and prenom='$prenom'"));// pour ne pas ajouter deux profs similaires
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">alert("erreur! Ce prof existe déja ");</SCRIPT>
<?php
}
else{
mysql_query("insert into prof(nom,prenom,adresse,telephone) values('$nom','$prenom','$adresse','$telephone')");
	/*		Ajouter le num dans le login    */
$numprof=mysql_fetch_array(mysql_query("select numprof from prof where nom='$nom' and prenom='$prenom'"));
$num=$numprof['numprof'];
mysql_query("insert into login(Num,pseudo,passe,type) values('$num','$pseudo','$passe','prof')");
?><SCRIPT LANGUAGE="Javascript">alert("Insertion avec succés!");</SCRIPT>
<?php
}
}
else{
?>
<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");</SCRIPT>
<?php
}
echo '<br/><a href="ajout_prof.php">Revenir à la page précédente !</a>';
}
else {
 ?>
 <form action="ajout_prof.php" method="POST" class="formulaire">
 Nom           :         <input type="text" name="nom"><br/>
 Prenom      :         <input type="text" name="prenom"><br/>
 Adresse     :          <textarea name="adresse"> </textarea><br/>
 Telephone  :       <input type="text" name="telephone"> <br/>
 Pseudo        :      <input type="text" name="pseudo"> <br/>
 Password     :       <input type="password" name="passe"> <br/>
<center><input type="image" src="button.png"></center>
</form>
<?php
}
?>
</pre></center>
</div>
</html>
