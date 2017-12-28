<?php

function getConnect(){
require_once('connect.php');
$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connexion->query('SET NAMES UTF8');
return $connexion;
}


//fonction du directeur
function ajouterEmploye($login,$mdp,$nom,$prenom,$fonction){
    $connexion=getConnect();
    $requete="INSERT INTO employe VALUES(0,'$login',$mdp,$nom,$prenom,$fonction)";
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}

function releverIDemploye($nom){ //retourn l'id de l'employe (necessaire pour la fonction modifierInfoEmploye)
    $connexion=getConnect();
    $requete="SELECT id_employe FROM employe WHERE nom='$nom'";
    $resultat=$connexion -> query($requete);
    $resultat -> setFetchMode(PDO::FETCH_OBJ);
    $idEmploye = $resultat ->fetchall();
    $resultat -> closeCursor();
    return $idEmploye;
}

function modifierInfoEmploye($idEmploye,$login,$mdp,$fonction,$nom,$prenom){
    $connexion=getConnect();
    $requete="UPDATE employe SET login='$login', mdp='$mdp', fonction='$fonction', nom='$nom', prenom='$prenom' WHERE id_employe=$idEmploye";
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}

function ajouterIntervention($nomIntervention,$prix){
    $connexion=getConnect();
    $requete="INSERT INTO intervention VALUES('$nomIntervention','$prix')";
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}

function ajouterPieceIntervention($nomIntervention,$nomPiece){ //nomIntervention est la clé primaire de intervention
    $connexion=getConnect();
    $requete="INSERT INTO piece VALUES('$nomIntervention','$nomPiece')";
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}

function chercherIntervention($nomIntervention){
    $connexion=getConnect();
    $requete="SELECT nomIntervention, nomPiece FROM intervention NATURAL JOIN piece";
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}


//fonction de l'agent
function ajouterClient($nom,$prenom,$adresse,$numTel,$email,$decouvert){
    $connexion=getConnect();
    $requete="INSERT INTO client VALUES(0,'$nom','$prenom','$adresse','$numTel','$email','decouvert')"; //+ cle etrangere nomIntervention initialisé a null
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}

function modifierInfoClient($idClient,$nom,$prenom,$adresse,$numTel,$email,$decouvert){
    $connexion=getConnect();
    $requete="UPDATE client SET nom='$nom', prenom='$prenom', adresse='$adresse', numTel='$numTel', email='$email', decouvert='$decouvert' WHERE id_client=$idClient";
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}

function releverIDclient($nom){
    $connexion=getConnect();
    $requete="SELECT id_client FROM client WHERE nom='$nom'";
    $resultat=$connexion -> query($requete);
    $resultat -> setFetchMode(PDO::FETCH_OBJ);
    $idClient = $resultat ->fetchall();
    $resultat -> closeCursor();
    return $idClient;
}

function nouvelleInterventionClient($idClient,$nomIntervention){
    $connexion=getConnect();
    $requete="UPDATE client SET nomIntervention='$nomIntervention' WHERE id_client='$idClient'"; //on lie un client a une intervention
    $resultat=$connexion -> query($requete);
    $resultat -> closeCursor();
}

function syntheseClient($id){ 
    $connexion=getConnect();
    $requete="SELECT * FROM client NATURAL JOIN intervention WHERE id_client='$id'"; //mal ecrite
    $resultat=$connexion -> query($requete);
    $resultat -> setFetchMode(PDO::FETCH_OBJ);
    $client = $resultat ->fetchall();
    $resultat -> closeCursor();
    return $client;
}

