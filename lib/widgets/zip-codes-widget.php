<?php


class Tourily_Zipcode_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'tourily_zip_code',
            'Tourily Zip Code',
            array('description' => 'Tourily listings by zip code.')
        );
    }


    public function widget($args, $instance)
    {
        $items = $this->load_data();
        $title = 'Zip Code';
        $search_prefix = 'zip_codes';

        echo $before_widget;
        include(TOURILY_DIR . '/templates/widget-sidebar.php');
        echo $after_widget;
    }


    private function load_data()
    {
        $zip_codes = get_option(TOURILY_OPTION_ZIPCODE, array());

        $results = array();
        foreach ($zip_codes as $zip_code => $listings)
        {
            $results[$zip_code] = tourily_slug($zip_code);
        }

        return $results;
    }
}


add_action('widgets_init', create_function('', 'register_widget("Tourily_Zipcode_Widget");' ));
