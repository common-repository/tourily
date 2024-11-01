<?php


class Tourily_Prices_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'tourily_prices',
            'Tourily Prices',
            array('description' => 'Tourily listings by price.')
        );
    }


    public function widget($args, $instance)
    {
        $items = $this->load_data();
        $title = 'Price';
        $search_prefix = 'prices';

        echo $before_widget;
        include(TOURILY_DIR . '/templates/widget-sidebar.php');
        echo $after_widget;
    }


    private function load_data()
    {
        $prices = get_option(TOURILY_OPTION_PRICE, array());

        $results = array();
        foreach ($prices as $price => $listings)
        {
            $range = tourily_range_for_price($price);

            $results[tourily_format_range($range)] = tourily_slug_range($range);
        }

        return $results;
    }
}


add_action('widgets_init', create_function('', 'register_widget("Tourily_Prices_Widget");' ));
