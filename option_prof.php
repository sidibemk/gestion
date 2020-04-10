<?php
session_start();
include('cadre.php');
mysql_connect("localhost", "root", "");
mysql_select_db("gestion");
echo '<div class="corp">';
if(isset($_GET['matiere'])){
$id=$_GET['matiere'];
$data=mysql_query("select prof.nom,prenom,nommat,classe.nom as nomcl,promotion,numsem from prof,enseignement,matiere,classe where enseignement.numprof=prof.numprof and classe.codecl=enseignement.codecl and matiere.codemat=enseignement.codemat and  enseignement.numprof='$id' order by promotion desc");
?>
<center><h1>Matieres enseignées par cet enseignant</h1></center>
<table id="rounded-corner">
<thead><tr> <th scope="col" class="rounded-company">Nom</th>
 <th scope="col" class="rounded-q2">Prenom</th>
 <th scope="col" class="rounded-q2">Matiére</th>
 <th scope="col" class="rounded-q2">Classe</th>
 <th scope="col" class="rounded-q2">Promotion</th>
 <th scope="col" class="rounded-q4">Semestre</th></tr></thead>
<tfoot>
<tr>
<td colspan="5"class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysql_fetch_array($data)){
echo '<tr><td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['nommat'].'</td><td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['numsem'].'</td></tr>';
}
?>
<tbody>
</table>
<?php 
}
else if(isset($_GET['classe'])){
$id=$_GET['classe'];
$data=mysql_query("select * from prof,classe where numprof=numprofcoord and numprof='$id' order by promotion desc");
?>
<center><h1>Classe coordonées par cet enseignant</h1></center>
<table id="rounded-corner">
<thead><tr> <th scope="col" class="rounded-company">Nom</th>
 <th scope="col" class="rounded-q2">Prenom</th>
 <th scope="col" class="rounded-q2">Classes coordonées</th>
 <th scope="col" class="rounded-q4">Promotion</th></tr></thead>
<tfoot>
<tr>
<td colspan="3" class="rounded-foot-left">&nbsp;</td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysql_fetch_array($data)){
echo '<tr><td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td></tr>';
}
?>
<tbody>
</table>
<?php
}
?>
</div>