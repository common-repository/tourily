<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

    <title>
      <?php echo $listing->address ?>,
      <?php echo $listing->city ?>
      <?php echo $listing->zip_code ?> |
      Home For Sale |
      Virtual Tour
    </title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <link rel="stylesheet" href="<?php echo plugins_url('/', __FILE__) ?>static/stylesheets/tour.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="<?php echo plugins_url('/', __FILE__) ?>static/javascripts/tour.js"></script>

    <script>

      $(function($) {
        TourilyTour([
          <?php $last_key = end(array_keys($images)) ?>
          <?php foreach($images as $key => $img): ?>
            {
              thumb: '<?php echo $img->files->tn->url ?>',
              mobile: '<?php echo $img->files->mobile->url ?>',
              fullsize: '<?php echo $img->files->desktop->url ?>',
              title: '<?php echo addslashes($img->title) ?>',
              alt: '<?php echo addslashes($img->alt) ?>'
            }<?php if ($key !== $last_key): ?>,<?php endif ?>
          <?php endforeach ?>
        ]);
      });

    </script>

  </head>


  <body>

    <div id="header_bg"></div>
    <div id="header">
      <h1>
        <?php echo $listing->subtitle ?> |
        <?php echo $listing->address ?>,
        <?php echo $listing->city ?>
        <?php echo $listing->zip_code ?>
      </h1>

      <?php if ($listing->status == 'sold'): ?>
        <div id="status" class="sold">Sold</div>
      <?php elseif ($listing->status == 'contract_contingent' || $listing->status == 'contract_pending'): ?>
        <div id="status" class="contract">Under Contract</div>
      <?php endif ?>
    </div>


    <div id="container"></div>


    <div id="footer_bg"></div>
    <div id="footer">

      <?php if (!isset($_GET['idx'])): ?>
        <a href="/<?php echo get_option(TOURILY_OPTION_LISTING_PREFIX) ?>/<?php echo $path ?>" id="back_to_listing">
          <img src="<?php echo plugins_url('/', __FILE__) ?>static/images/tours/listing.png">
          <span>View Listing</span>
        </a>
      <?php endif ?>

      <div id="buttons">
        <a id="play" href=""><img src="<?php echo plugins_url('/', __FILE__) ?>static/images/tours/pause.png" border="0"></a>
      </div>

      <div id="image_description"></div>

    </div>

    <?php if (!empty($listing->tour_music)): ?>
      <audio loop="true" id="song">
        <source src="http://cdn.tourily.com/audio/<?php echo $listing->tour_music ?>.ogg" type="audio/ogg" />
        <source src="http://cdn.tourily.com/audio/<?php echo $listing->tour_music ?>.mp3" type="audio/mp3" />
      </audio>
    <?php endif ?>

  </body>


</html>
