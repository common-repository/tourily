<?php get_header(); ?>

  <link rel="stylesheet" href="<?php echo plugins_url('/', __FILE__) ?>static/stylesheets/listing.css">
  
  <div id="tourily_listing">


    <?php $first_image = $images[0]; ?>
    <div id="tourily_cover_image" style="background-image: url(<?php echo $first_image->files->mobile->url ?>)"></div>


    <ul id="tourily_listing_thumbnails">
      <?php foreach ($images as $img): ?>
        <li><a href="<?php echo $img->files->desktop->url ?>"><img src="<?php echo $img->files->tn->url ?>"></a></li>
      <?php endforeach ?>
    </ul>


    <p style="font-size: 16px;"><a href="/<?php echo get_option(TOURILY_OPTION_TOUR_PREFIX) ?>/<?php echo tourily_path_for_listing($listing) ?>">Click here for a virtual tour</a></p>


    <div id="content" class="tourily-listing-content post entry-content" style="width: 100%; margin: 0; padding: 0;">

      <h1><?php echo $listing->address ?>, 
      <?php echo $listing->city ?>
      <?php echo $listing->zip_code ?></h1>

      <h3>"<?php echo $listing->subtitle ?>" Listing Agent: <?php echo $listing->agent->name ?></h3>


      <p style="text-align: justify"><?php echo $listing->description ?></p>


      <div id="tourily_listing_details">

        <div id="tourily_listing_details_right">

          <p><strong>Room Highlights</strong></p>
          <ul>
            <?php foreach ($listing->room_highlights as $room): ?>
              <li><strong><?php echo $room->name ?>:</strong> <?php echo $room->description ?></li>
            <?php endforeach ?>
          </ul>

        </div>

        <p><strong>Listing Details</strong></p>
        <ul>
          <li>Property Type: <?php echo ucwords(str_replace('_', ' ', $listing->property_type)) ?></li>
          <li>Sale Type: <?php echo ucwords(str_replace('_', ' ', $listing->sale_type)) ?></li>
          <li>Price: <?php echo $listing->price ?></li>
          <li>MLS #: <?php echo $listing->mls ?></li>
          <li>Bedrooms: <?php echo $listing->bedrooms ?></li>
          <li>Bathrooms: <?php echo $listing->bathrooms ?></li>
          <li>Levels: <?php echo $listing->levels ?></li>
          <li>Square Footage: <?php echo $listing->square_footage ?></li>
          <li>Lot Size: <?php echo $listing->lot_size ?></li>
        </ul>

        <p><strong>Community</strong></p>
        <ul>
          <li>Name: <?php echo $listing->community_name ?></li>
          <li>Subdivision: <?php echo $listing->subdivision ?></li>
          <li>HOA: <?php echo $listing->hoa ?></li>
        </ul>

        <p><strong>School Information</strong></p>
        <ul>
          <li>District: <?php echo $listing->school_district ?></li>
          <li>Elementary School: <?php echo $listing->school_elementary ?></li>
          <li>Middle School: <?php echo $listing->school_middle ?></li>
          <li>High School: <?php echo $listing->school_high ?></li>
        </ul>

        <p><strong>Financial</strong></p>
        <ul>
          <li>Taxes: <?php echo $listing->taxes ?></li>
          <li>HOA Fee: <?php echo $listing->hoa_fee ?></li>
          <li>Seller Financing: <?php echo $listing->seller_financing ?></li>
          <li>Short Sale: <?php echo $listing->short_sale ?></li>
        </ul>

      </div>


    </div>


  </div>
  

<?php get_footer(); ?>
