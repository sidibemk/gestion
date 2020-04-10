<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
?>
<div class="corp">
<img src="titre_img/affich_classe.png" class="position_titre">
<center>
<?php
$data=mysql_query("select codecl,classe.nom as nomcl,promotion,prof.nom as nomprof from classe,prof where classe.numprofcoord=prof.numprof");
?>
<table id="rounded-corner">
<thead><tr><?php echo Edition();?>
 <th class="<?php echo rond(); ?>">Nom de la classe</th>
 <th class="rounded-q1">Promotion</th>
 <th class="rounded-q4">Prof coordinataire</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(2,4); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysql_fetch_array($data)){
?>
<tr><?php if(isset($_SESSION['admin'])){ 
?><td><a href="modif_classe.php?modif_classe=<?php echo $a['codecl']; ?>">modifier</a></td><td><a href="modif_classe.php?supp_classe=<?php echo $a['codecl']; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette entrée?\ntous les enregistrements en relation avec cette entrée seront perdus'));">supprimer</a></td> <?php }
echo '<td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nomprof'].'</td></tr>';
}
?>
<tbody>
</table>
<?php
echo '<br/><br/><a href="index.php">Revenir à la page précédente !</a>';
?>
</center>
</div>
</html>