<?php get_header(); ?>

  <link rel="stylesheet" href="<?php echo plugins_url('/', __FILE__) ?>static/stylesheets/search-results.css">

  <div id="content" class="tourily-listing-content post entry-content" style="width: 100%; margin: 0; padding: 0;">


    <h1>Real Estate Search Results</h1>


    <?php foreach ($results as $listing): ?>


      <?php include(TOURILY_DIR . '/templates/search-result.php'); ?>


    <?php endforeach ?>


  </div>
  

<?php get_footer(); ?>
