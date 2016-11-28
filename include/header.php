
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <link rel="stylesheet" href="asset/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/style.css">

    <title></title>
  </head>
  <body>
    <header>
      <div class="row">
        <div class="col-xs-12">
      </div>
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-max-width: 900px responsive">
          <div class="navbar-header">
            <button class="navbar-toggle" data-target="#LG-collapse" data-toggle="collapse" type="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span> <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
              <i class="fa fa-home fa-2x" style= "margin-left: 50px; margin-top: 15px;" aria-hidden="true"></i>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="LG-collapse">
            <ul class="nav navbar-nav navbar-left">
              <li><a target="_blank" style="margin-top: 25px;" title="consultation" href="consultation.php">Consultation</a></li>
            </ul>
            <img class="logo responsive" style="text-align: center;" src="logo.jpg" alt="">
            <div class="responsive" style="text-align: left; " title="films" >
              <p style="text-align: center;">
                <h1 class="kaushan">FILMS</h1>
              </p>
              <p style="text-align: right; margin-right: 50px;">
                <!--Si l'utilisateur est logué  on modifie le header pour afficher message de bienvenue
                et le lien vers la page deconnexion -->
                <?php if(is_logged_user()){ ?>
                <a target="blank" style= "color: #ffffff;">Bienvenue <?php echo $_SESSION['user']['pseudo']; ?></a> |
                <a target="blank" style= "color: #ffffff;" title="deconnexion" href="deconnexion.php">Deconnexion</a> |
                <a target="blank" style= "color: #ffffff;" title="contact" href="#">Contact</a>
              <?php } else { ?>
                <a target="blank" style= "color: #ffffff;" title="connexion" href="connexion.php">Connexion</a> |
                <a target="blank" style= "color: #ffffff;" title="inscription" href="inscription.php">Inscription</a> |
                <a target="blank" style= "color: #ffffff;" title="contact" href="">Contact</a>
              <?php } ?>
              </p>
            </div>
          </div>
        </div>
      </nav>
    </header>
