<div class="wrap">

    <h2>Tourily Options</h2>

    <p>This blog is connected to your Tourily.com account.</p>


    <form method="POST" action="">

    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="tourily_listings_prefix">Listings Prefix</label>
        </th>
        <td>
          <input type="text" name="tourily_listings_prefix" id="tourily_listings_prefix" value="<?php echo get_option(TOURILY_OPTION_LISTING_PREFIX) ?>">
          <i>(<?php echo get_option('siteurl') ?>/<b><?php echo get_option(TOURILY_OPTION_LISTING_PREFIX) ?></b>/address)</i>
        </td>
      </tr>
       
      <tr valign="top">
        <th scope="row">
          <label for="tourily_tour_prefix">Tour Prefix</label>
        </th>
        <td>
          <input type="text" name="tourily_tour_prefix" id="tourily_tour_prefix" value="<?php echo get_option(TOURILY_OPTION_TOUR_PREFIX) ?>">
          <i>(<?php echo get_option('siteurl') ?>/<b><?php echo get_option(TOURILY_OPTION_TOUR_PREFIX) ?></b>/address)</i>
        </td>
      </tr>
    </table>
    
    <?php submit_button('Save Options') ?>

    </form>


    <?php if (isset($_GET['tourily-debug'])): ?>

      <h2>Re-Generate Widgets</h2>

      <p>If you are experiencing strange results results or your widgets are not
      displaying the correct listings, try re-generating them:</p>

      <form method="POST" action="">
      
      <input type="hidden" name="tourily_regenerate" value="1">
      <?php submit_button('Re-Generate Widgets') ?>

      </form>


      <h2>Reset Listings</h2>

      <p>This will delete all Tourily listings on your site:</p>

      <form method="POST" action="">
      
      <input type="hidden" name="tourily_reset" value="1">
      <?php submit_button('Delete All Listings') ?>

      </form>

    <?php endif ?>


    <h2>Disconnect from Tourily</h2>

    <p>If you want to prevent this site from receiving updates from Tourily
    in the future, you may disconnect it below. Note that you can always
    re-connect later.</p>

    <form method="POST" action="">
    
    <input type="hidden" name="tourily_disconnect" value="1">
    <?php submit_button('Disconnect from Tourily') ?>

    </form>

</div>
