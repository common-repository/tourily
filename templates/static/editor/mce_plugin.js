(function() {
    tinymce.create('tinymce.plugins.TourilyPlugin', {
        init : function(ed, url) {
            ed.addCommand('mceTourily', function() {
                ed.windowManager.open({
                    file : url + '/shortcode.php',
                    width : 400,
                    height : 400,
                    inline : 1
                }, {
                    plugin_url : url, // Plugin absolute URL
                    some_custom_arg : 'custom arg' // Custom argument
                });
            });

            // Register example button
            ed.addButton('tourily', {
                title : 'Insert listings from Tourily',
                cmd : 'mceTourily',
                image : url + '/icon.png'
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : 'Tourily plugin',
                author : 'Tourily',
                authorurl : 'http://www.tourily.com',
                infourl : 'http://www.tourily.com',
                version : '1.0'
            };
        }
    });

    tinymce.PluginManager.add('tourily', tinymce.plugins.TourilyPlugin);
})();
