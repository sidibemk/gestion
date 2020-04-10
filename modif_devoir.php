<?php
session_start();
include('cadre.php');
include('calendrier.html');
echo '<div class="corp">';
if(isset($_GET['modif_dev'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_dev'];
$ligne=mysql_fetch_array(mysql_query("select * from classe,devoir,matiere where classe.codecl=devoir.codecl and matiere.codemat=devoir.codemat and numdev='$id'"));//Pour afficher le nom de l'eleve et la note par deflault et le devoir,
$date=$ligne['date_dev'];

?>
<center><pre><h1>Modifier un devoir</h1>
<form action="modif_devoir.php" method="POST" class="formulaire">
Matiére :<?php echo $ligne['nommat']; ?><br/>
Classe : <?php echo stripslashes($ligne['nom']); ?><br/>
Promotion : <?php echo $ligne['promotion']; ?><br/>
Coefficient : <input type="text" name="coeficient" value="<?php echo $ligne['coeficient']; ?>"><br/>
Semestre : <?php echo $ligne['numsem']; ?><br/>
Devoir N° : <input type="text" name="n_devoir" value="<?php echo $ligne['n_devoir']; ?>"><br/>
Date du devoir     :     <input type="text" name="date" class="calendrier" value="<?php echo $date; ?>"/>
<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
<input type="hidden" name="numdev" value="<?php echo $ligne['numdev']; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="image" src="modifier.png">
</form>
<?php
echo '<br/><br/><a href="afficher_devoir.php">Revenir à la page précédente !</a>';
}
if(isset($_POST['n_devoir'])){//s'il a cliquer sur le bouton modifier
	$id=$_POST['id'];
	if(($_POST['n_devoir']=="1" or $_POST['n_devoir']=="2") and $_POST['date']!="" and $_POST['coeficient']!=""){
		$n_devoir=$_POST['n_devoir'];
		$numdev=$_POST['numdev'];
		$coeficient=$_POST['coeficient'];
		$date=$_POST['date'];
		$compte=mysql_fetch_array(mysql_query("select count(*) as nb from devoir where n_devoir='$n_devoir' and numdev='$numdev' and date_dev='$date'"));
		if($compte['nb']!=0){//deux devoir similaire()2 devoirs par matiere
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur de modification,ce devoir existe déja(verifier le numero de devoir)"); </SCRIPT> <?php
		}
		else{
		mysql_query("update devoir set n_devoir='$n_devoir', coeficient='$coeficient',date_dev='$date' where numdev='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succés!"); </SCRIPT> <?php
		}
	}
	else{
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champs(n° de devoir 1 ou 2)"); </SCRIPT> <?php
		}
	echo '<br/><br/><a href="modif_devoir.php?modif_dev='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_dev'])){
$id=$_GET['supp_dev'];
mysql_query("delete from devoir where numdev='$id'");
mysql_query("delete from evaluation where numdev='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succés!\ntous les evaluations de ce devoir ont été supprimées"); </SCRIPT> <?php
echo '<br/><br/><a href="afficher_devoir.php">Revenir à la page à l\'affichage</a>'; //on revient à la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</center></pre>
</div>