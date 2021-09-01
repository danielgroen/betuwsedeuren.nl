<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo get_bloginfo('name'); ?></title>
  <meta name="author" content="Betuwse Deuren">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style/font-awesome.min.css">

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700|Roboto:100,300,400,500,700" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>

  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <?php wp_head(); ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-55951586-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-55951586-1');
  </script>
</head>

<body>
  <header>
    <div class="container-fluid top-menu">
      <div class="topRightItem top-menu-right">
        <div class="twentyfourseven">24|7</div> <i class="fa fa-phone" aria-hidden="true"></i> 0488 48 11 33 <a href="https://nl-nl.facebook.com/Betuwse-Deuren-BV-637099336306222/" target="_blank"><i class="fa facebookTopRight fa-facebook" aria-hidden="true"></i></a><a href="#modal-search" data-toggle="modal"><i class="fa fa-search"></i></a>

      </div>
    </div>
    <div class="container-fluid">
      <a href="/">
        <div class="col-lg-3 logo">
          <img src="/wp-content/uploads/2018/05/logo-header.png" class="img-responsive" />
        </div>
      </a>
      <nav class="navbar col-lg-7 navbar-default" role="navigation">
        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
      </nav>
    </div>
  </header>
  <!-- Einde van Header -->
  <?php
  if (is_front_page()) {
    putRevSlider('homeslider');
  } ?>

  <div class="container-fluid <?php if (!is_front_page()) { ?> pageWithoutHeader <?php } ?> contentOnderSlider">
    <ul id="da-thumbs" class="da-thumbs">

      <li class="col-lg-2 col-lg-offset-2 dealerVanHomePage">
        <a href="https://betuwsedeuren.hormannpartner.nl/" target="_blank">
          dealer van
          <img src="/wp-content/uploads/2017/10/logo_hormann.jpg" class="img-responsive" />
          <div>
            <span class="triangleContentOnderSlider"></span>
          </div>
        </a>
      </li>

      <li class="col-lg-2 pagination-centered textContentOnderSlider" style="padding-top: 51px;">
        <a href="/particulieren">
          <span class="contentOnderSliderText ">Particulieren <br /> en Bedrijven</span>
          <div>
            <span class="triangleContentOnderSlider"></span>
          </div>
        </a>
      </li>

      <li class="col-lg-2 pagination-centered textContentOnderSlider" style="padding-top: 51px;">
        <a href="/bouwbedrijven-en-aannemers">
          <span class="contentOnderSliderText ">Bouwbedrijven <br /> en Aannemers</span>
          <div>
            <span class="triangleContentOnderSlider"></span>
          </div>
        </a>
      </li>

      <li class="col-lg-2 textContentOnderSlider">
        <a href="/woning-beheerders-verhuurders">
          woning-<br />
          beheerders<br />
          verhuurders
          <div>
            <span class="triangleContentOnderSlider"></span>
          </div>
        </a>
      </li>

    </ul>
  </div>

  <main>
    <div class="container">
      <div class="col-lg-12 no-padding">
        <?php
        if (function_exists('yoast_breadcrumb')) {
          yoast_breadcrumb('<p class="breadcrumbs">', '</p>');
        }
        ?>
      </div>
    </div>

    <section id="content">