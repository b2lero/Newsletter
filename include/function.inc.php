<?php

  // EMAIL VALIDE
  function is_valid_mail($email){
      return filter_var($email, FILTER_VALIDATE_EMAIL);
  }


  // AFFICHAGE ERREURS les erreurs
  function message_erreur($error,$input){
      if($_POST){
        if($error[$input] != ''){
          return '<p class="display_error">' .$error[$input]. '</p>';
      }
    }
  }



  //- CONNEXION a la db
  function db_connect(){
    //definition des variables de connexion a la db
    try{
      $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
      // connexion db
      include('config.inc.php');
      // fin données
      $db = new PDO('mysql:host='.$host.';dbname='.$dbname.'',$user,$password);
      return $db;

    } catch (Exception $e){
      die ('Erreur de connexion : '. $e->getMessage());
    }
  }
?>
