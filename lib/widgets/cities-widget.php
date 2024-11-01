<?php


class Tourily_Cities_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'tourily_cities',
            'Tourily Cities',
            array('description' => 'Tourily listings by city.')
        );
    }


    public function widget($args, $instance)
    {
        $items = $this->load_data();
        $title = 'City';
        $search_prefix = 'cities';

        echo $before_widget;
        include(TOURILY_DIR . '/templates/widget-sidebar.php');
        echo $after_widget;
    }


    private function load_data()
    {
        $cities = get_option(TOURILY_OPTION_CITY, array());

        $results = array();
        foreach ($cities as $city => $listings)
        {
            $results[$city] = tourily_slug($city);
        }

        return $results;
    }
}


add_action('widgets_init', create_function('', 'register_widget("Tourily_Cities_Widget");' ));
