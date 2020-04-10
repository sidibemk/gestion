<?php
session_start();
include('cadre.php');
?>
<div class="corp">
<img src="titre_img/affich_note.png" class="position_titre"><pre>
<?php
if(isset($_GET['nomcl'])){//affichage de la promotion
$nomcl=$_GET['nomcl'];
$_SESSION['nomcl']=$_GET['nomcl'];//session du nomcl choisis dans le menu pour laisser la variable jusqu'a la page ou on va afficher la liste
$data=mysql_query("select promotion from classe where nom='$nomcl' order by promotion desc");
?>
<form action="afficher_note.php" method="POST" class="formulaire">
Veuillez choisir la promotion et le semestre pour <?php echo $nomcl; ?> : <br/><br/>
   <FIELDSET>
 <LEGEND align=top>Critères d'affichage<LEGEND>  <pre>
Promotion      :        <select name="promotion">
<?php while($a=mysql_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Semestre         :         <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="afficher">
</pre></fieldset>
</form>
<?php } 

if(isset($_POST['radiosem'])){
$nomcl=$_SESSION['nomcl'];
$_SESSION['semestre']=$_POST['radiosem'];
$promo=$_POST['promotion'];
$semestre=$_SESSION['semestre'];//seulement pour la requete
$donnee=mysql_query("select nommat from matiere,enseignement,classe where matiere.codemat=enseignement.codemat and enseignement.codecl=classe.codecl and nom='$nomcl' and enseignement.numsem='$semestre' and promotion='$promo'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
$a=0;
//$_SESSION['classe']=$classe;
?>
<form method="post" action="afficher_note.php" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Matiéres étudiée<LEGEND>  <pre>
   <p>
   <?php
   $i=1;
   while($a=mysql_fetch_array($donnee)){
   echo '<input type="radio" name="radio" value="'.$a['nommat'].'" id="choix'.$i.'" /> <label for="choix'.$i.'">'.$a['nommat'].'</label><br /><br />';
   $i++;
   }
   ?>
   </pre></fieldset>
<input type="submit" value="Afficher les notes">
   </p>
</form>
<?php
}
else if(isset($_POST['radio'])){
$semestre=$_SESSION['semestre'];
$nommat=$_POST['radio'];
$nomcl=$_SESSION['nomcl'];
$donnee=mysql_query("select nomel,prenomel,nom,nommat,date_dev,coeficient,note from eleve,classe,matiere,devoir,evaluation where eleve.codecl=classe.codecl and evaluation.numdev=devoir.numdev and devoir.codemat=matiere.codemat and evaluation.numel=eleve.numel and matiere.nommat='$nommat' and nom='$nomcl' and devoir.numsem='$semestre'");
?><center><table id="rounded-corner">
<thead><tr><th class="rounded-company">Nom d'èleve</th>
<th scope="col" class="rounded-q2">Prenom d'éleve</th>
<th scope="col" class="rounded-q2">Classe</th>
<th scope="col" class="rounded-q2">Matiere</th>
<th scope="col" class="rounded-q2">Date du devoir</th>
<th scope="col" class="rounded-q2">Coefficient</th><th scope="col" class="rounded-q4">Note</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysql_fetch_array($donnee)){
echo '<tr><td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['coeficient'].'</td><td>'.$a['note'].'</td></tr>';
}
?>
</tbody>
</table></center>
<?php
}//fin   if(isset($_POST['radio']
?>
</pre>
</div>
<body>
</html>

