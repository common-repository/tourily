<?php


class Tourily_Subdivisions_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'tourily_subdivisions',
            'Tourily Subdivisions',
            array('description' => 'Tourily listings by subdivision.')
        );
    }


    public function widget($args, $instance)
    {
        $items = $this->load_data();
        $title = 'Subdivision';
        $search_prefix = 'subdivisions';

        echo $before_widget;
        include(TOURILY_DIR . '/templates/widget-sidebar.php');
        echo $after_widget;
    }


    private function load_data()
    {
        $subdivisions = get_option(TOURILY_OPTION_SUBDIVISION, array());

        $results = array();
        foreach ($subdivisions as $subdivision => $listings)
        {
            $results[$subdivision] = tourily_slug($subdivision);
        }

        return $results;
    }
}


add_action('widgets_init', create_function('', 'register_widget("Tourily_Subdivisions_Widget");' ));
