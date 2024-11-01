$(function() {
    $('#InsertTourilyCode').click(function(e) {
        e.preventDefault();

        var shortcode = '<p>[tourily';

        // Min price
        shortcode += ' price_min="' + $('#tourily_price_min').val() + '"';

        // Max price
        shortcode += ' price_max="' + $('#tourily_price_max').val() + '"';

        // Status
        if ($('#tourily_status').val() != 'all') {
            shortcode += ' status="' + $('#tourily_status').val() + '"';
        }

        // Zip code
        if ($('#tourily_zip_code').val() != 'all') {
            shortcode += ' zip_code="' + $('#tourily_zip_code').val() + '"';
        }

        // City
        if ($('#tourily_city').val() != 'all') {
            shortcode += ' city="' + $('#tourily_city').val() + '"';
        }

        // Subdivision
        if ($('#tourily_subdivision').val() != 'all') {
            shortcode += ' subdivision="' + $('#tourily_subdivision').val() + '"';
        }

        // Community
        if ($('#tourily_community').val() != 'all') {
            shortcode += ' community="' + $('#tourily_community').val() + '"';
        }

        shortcode += ']</p>';
        
        tinyMCEPopup.editor.execCommand('mceInsertContent', false, shortcode);
        tinyMCEPopup.close();
    });
});
