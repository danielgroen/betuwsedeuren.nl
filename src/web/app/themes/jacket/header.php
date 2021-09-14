<?php

require_once('includes/Functions.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo get_bloginfo('name'); ?></title>
  <meta name="author" content="Betuwse Deuren">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/fonts/campton/style.css">

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
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

<body <?php body_class('page '); ?>>
  <header>
    <div class="container-fluid top-menu">
      <div class="topRightItem top-menu-right">
        <div class="twentyfourseven">24|7</div> <i class="fa fa-phone" aria-hidden="true"></i> <a class="tel" href="tel:+31488481133">0488 48 11 33</a> <a href="https://nl-nl.facebook.com/Betuwse-Deuren-BV-637099336306222/" target="_blank"><i class="fa facebookTopRight fa-facebook" aria-hidden="true"></i></a><a href="#modal-search" data-toggle="modal"><i class="fa fa-search"></i></a>

      </div>
    </div>
    <div class="container-fluid">
      <a href="/">
        <div class="col-md-3 logo">
          <img src="/wp-content/uploads/2018/05/logo-header.png" class="img-responsive" />
        </div>
      </a>
      <nav class="navbar col-lg-7 navbar-default" role="navigation">
        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
      </nav>
    </div>
  </header>

  <?php if (is_front_page()) { ?>
    <div class="block hero">
      <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="hero__image">
      <article class="hero__article">
        <span class="hero__article__title"><?php the_field('header_title'); ?></span>
        <p class="hero__article__introduction"><?php the_field('header_introduction'); ?></p>
        <a href="<?php the_field('header_button'); ?>" target="_blank" class="hero__article__button"><?php Functions::getIcon('download'); ?><?php the_field('header_button_text'); ?></a>
      </article>
    </div>
  <?php } ?>

  <div class="blue-banner">
    <div class="grid">
      <a class="blue-banner__item" href="https://betuwsedeuren.hormannpartner.nl/" target="_blank">Premium partner
        <?php Functions::getIcon('hormann'); ?></a>
      <a class="blue-banner__item" href="/particulieren">Particulieren <br /> en Bedrijven</a>
      <a class="blue-banner__item" href="/bouwbedrijven-en-aannemers">Bouwbedrijven <br /> en Aannemers</a>
      <a class="blue-banner__item" href="/woning-beheerders-verhuurders">woning-<br /> beheerders<br /> verhuurders</a>
    </div>
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