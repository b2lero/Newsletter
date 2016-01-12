<?php

  ini_set('display_errors',1);

  include('./include/init.inc.php');
  $db = db_connect(); // DATABASE

  $error = array();
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // sanitisation
  $name = trim(strip_tags($_POST['name']));
  $email = trim(strip_tags($_POST['email']));

  // validation
	if($name == ''){
		$error['no-name'] = 'le nom est obligatoire';
	}

	if($email == ''){
		$error['no-email'] = 'aucune adresse mail introduite';
	} elseif (is_valid_mail($email) == false) {
    $error['no-email'] = 'email invalide';
	}


	if(empty($error)){
		$sql = 'INSERT INTO user(name, email) VALUES(:name, :email)';
    $secret = uniqid();
		$preparedStatement = $db->prepare($sql);
		$preparedStatement->bindValue('name', htmlentities($_POST['name']));
		$preparedStatement->bindValue('email', $_POST['email']);
		$preparedStatement->execute();
	}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Newsletter</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <style media="screen">
      .container{
        width: 400px;
        margin: 0 auto;
      }
      .formulaire{
        margin-top: 20px;
      }
      .display_error{
        color: red;
        font-size: 12px;
      }
    </style>
  </head>
  <body>
      <div class="container">
        <h1>Inscription newsletter</h1>
        <p>
          Page permettant de s'enregistrer au mailing list.
        </p>
        <div class="formulaire">
          <form class="pure-form pure-form-stacked" action="index.php" method="post">
            <fieldset>
              <div class="pure-control-group">
                <label for="name">Votre nom</label>
                <input type="text" name="name" placeholder="entrez votre nom">
                  <?php echo message_erreur($error,'no-name')?>
              </div>
              <div class="pure-control-group">
                <label for="email">Votre email</label>
                <input type="text" name="email" placeholder="entrez votre email">
                  <?php echo message_erreur($error,'no-email'); ?>
              </div>
              <div class="pure-controls">
                <button type="submit" class="pure-button pure-button-primary">s'enregistrer</button>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
  </body>
</html>
