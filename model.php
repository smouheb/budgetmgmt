<?php

// 1 - creer la query d'insert - Done
// 2 - proteger la query - Done
// 3 - renvoyer sur la meme page avec une confirmation en couleur que c'est bon ou pas
// 4 - convertir date en mysql format

$_POST['amount'] = htmlspecialchars($_POST['amount']);
$_POST['comment'] = htmlspecialchars($_POST['comment']);

$bdd = new PDO('mysql:host=localhost;dbname=money_mgmt','root','root');

$insmove = $bdd->prepare('INSERT INTO money_movement(type,name, amount,comment, date_movement, date_post)VALUES(:type,:name,:amount,:comment, :date_movement, NOW())');

//ensuite optimiser avec bindParam
$insmove->bindValue(':type',$_POST['type']);
$insmove->bindValue(':name',$_POST['c_name']);
$insmove->bindValue(':amount',$_POST['amount']);
$insmove->bindValue(':comment',$_POST['comment']);
$insmove->bindValue(':date_movement',$_POST['date_movement']);
$insmove->execute();

$insmove->closeCursor();


header('Location:front_end.php');

?>
