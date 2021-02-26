<?php

/**
 * Reprenez le code de l'exercice précédent et transformez vos requêtes pour utiliser les requêtes préparées
 * la méthode de bind du paramètre et du choix du marqueur de données est à votre convenance.
 */

/**
 * @param $data
 * @return string
 */
function sanitize($data) : string{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    $data = addslashes($data);
    return $data;
}

function preparedRequestUtilisateur(PDO $pdo,$nom,$prenom,$email,$password,$adresse,$cp,$pays){
    $request = $pdo->prepare("
        INSERT INTO table_test_php.utilisateur (nom,prenom,email,password,adresse,code_postal,pays)
        VALUES (:nom,:prenom,:email,:password,:adresse,:code_postal,:pays)                        
    ");


    $request->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':password' => $password,
        ':adresse' => $adresse,
        ':code_postal' => $cp,
        ':pays' => $pays,
    ]);
}

function preparedRequestProduit(PDO $pdo,$titre,$prix,$desc_c,$desc_l){
    $request = $pdo->prepare("
        INSERT INTO table_test_php.produit (titre,prix,description_courte,description_longue)
        VALUES (:titre,:prix,:description_courte,:description_longue)                        
    ");


    $request->execute([
        ':titre' => $titre,
        ':prix' => $prix,
        ':description_courte' => $desc_c,
        ':description_longue' => $desc_l,
    ]);
}


$server = "127.0.0.1";
$db = "table_test_php";
$user = "dev";
$pass = "dev";
try {
    $pdo = new PDO ("mysql:host=$server;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    preparedRequestUtilisateur($pdo,'Bouttefeux','Pierre-Yves','toto@tata.fr','tataalamerenslip','13 bis rue du camp de giblou','59186','France');
    preparedRequestUtilisateur($pdo,'Bouttefeux','Joelle','joelle@toto.fr','nonadesesamours','13 bis rue du camp de giblou','59186','France');
    preparedRequestUtilisateur($pdo,'Bouttefeux','Gabin','gabs@choco.fr','papaetaxelsontlesmeilleurs','rue du sars dagneau','59186','France');
    preparedRequestUtilisateur($pdo,'Bouttefeux','Axel','axel@choco.fr','jeveuxfairemeslego','rue de momignies','59186','France');
    preparedRequestUtilisateur($pdo,'Bouttefeux','Zoe','zouzoute@choco.fr','cestamoilechocolat','rue de momignies','59186','France');
    preparedRequestUtilisateur($pdo,'Bouttefeux','Alexandre','Alex@initiative.fr','jeseraismonproprepatron','rue de momignies','59186','France');

    preparedRequestProduit($pdo,'Pizza',8.54,'pate cuite au four avec plein de truc dessus','Tarte salée de pâte à pain garnie de tomates, anchois, olives, etc. (plat originaire de Naples).');
    preparedRequestProduit($pdo,'lasagne',10.22,'mille feuille a la sauce tomate','Pâtes alimentaires en forme de large ruban.');
    preparedRequestProduit($pdo,'Osso Buco',15.47,'viande avec pate','OSSO BUCO, subst. masc. Plat d origine italienne composé de rouelles de jarret de veau cuisinées avec du vin blanc, un peu de bouillon, des tomates et des épices, servi avec des pâtes ou du riz.');
    preparedRequestProduit($pdo,'chocolat',2.06,'bonheur en morceau','Substance alimentaire (pâte solidifiée) faite de cacao broyé avec du sucre, de la vanille, etc.');
    preparedRequestProduit($pdo,'lego',25.98,'brick de jeu','Jeu de construction constitué de pièces de plastique dur qui s encastrent les unes dans les autres.');
    preparedRequestProduit($pdo,'bois',47,'stere de bois de chauffage','morceaux darbre coupé');

}

catch (PDOException $exception) {
    echo $exception->getMessage();

}
