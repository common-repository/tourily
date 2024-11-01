<?php


class Tourily_Communities_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'tourily_communities',
            'Tourily Communities',
            array('description' => 'Tourily listings by community.')
        );
    }


    public function widget($args, $instance)
    {
        $items = $this->load_data();
        $title = 'Community';
        $search_prefix = 'communities';

        echo $before_widget;
        include(TOURILY_DIR . '/templates/widget-sidebar.php');
        echo $after_widget;
    }


    private function load_data()
    {
        $communities = get_option(TOURILY_OPTION_COMMUNITY, array());

        $results = array();
        foreach ($communities as $community => $listings)
        {
            $results[$community] = tourily_slug($community);
        }

        return $results;
    }
}


add_action('widgets_init', create_function('', 'register_widget("Tourily_Communities_Widget");' ));
