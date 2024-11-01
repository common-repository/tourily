<li class="widget-container">

    <h3 class="widget-title">Listings By <?php echo $title ?></h3>
    <ul>
        <?php foreach ($items as $name => $slug): ?>
            <li><a href="/<?php echo get_option(TOURILY_OPTION_LISTING_PREFIX) ?>/<?php echo $search_prefix ?>/<?php echo $slug ?>"><?php echo $name ?></a></li>
        <?php endforeach ?>
    </ul>
</li>
