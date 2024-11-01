<table cellpadding="0" cellspacing="0" class="tourily_search_result">

  <tr>

    <td width="100">
      <a href="/<?php echo get_option(TOURILY_OPTION_LISTING_PREFIX) ?>/<?php echo $listing['slug'] ?>"><img src="<?php echo $listing['thumbnail'] ?>" border="0"></a>
    </td>

    <td>

      <h2><a href="/<?php echo get_option(TOURILY_OPTION_LISTING_PREFIX) ?>/<?php echo $listing['slug'] ?>"><?php echo $listing['address'] ?>, <?php echo $listing['city'] ?>, <?php echo $listing['zip_code'] ?></a></h2>

      <p>
        <strong>Price</strong>: $ <?php echo $listing['price'] ?> &nbsp;  &nbsp; 
        <strong>Community</strong>: <?php echo $listing['community_name'] ?> &nbsp;  &nbsp; 
        <strong>Subdivision</strong>: <?php echo $listing['subdivision'] ?>
      </p>

      <p><?php echo $listing['description'] ?></p>

    </td>

  </tr>

</table>
