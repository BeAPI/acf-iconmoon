(function ($) {

    function initialize_field($field) {

        var input = $field.find('input.bea-acf-iconmoon');
        var allowClear = $(input).attr('data-allow-clear') || 0;
        var opts = {
            dropdownCssClass: "bigdrop widefat",
            dropdownAutoWidth: true,
            formatResult: bea_iconmoon_format,
            formatSelection: bea_iconmoon_format_small,
            data: {results: bea_acf_iconmon},
            allowClear: 1 == allowClear
        };

        input.select2(opts);

        /**
         * Format the content in select 2
         *
         * @param css
         * @returns {string}
         */
        function bea_iconmoon_format(css) {
            return "<span style='font-size:3em' class='icon-" + css.id + "'></span> " + css.text;
        }

        /**
         * Format the content in select 2
         *
         * @param css
         * @returns {string}
         */
        function bea_iconmoon_format_small(css) {
            return "<span class='icon-" + css.id + "'></span> " + css.text;
        }

    }

    if (typeof acf.add_action !== 'undefined') {

        /*
         *  ready append (ACF5)
         *
         *  These are 2 events which are fired during the page load
         *  ready = on page load similar to jQuery(document).ready()
         *  append = on new DOM elements appended via repeater field
         *
         *  @type	event
         *  @date	20/07/13
         *
         *  @param	jQueryel (jQuery selection) the jQuery element which contains the ACF fields
         *  @return	n/a
         */

        acf.add_action('ready append', function (jQueryel) {
            // search jQueryel for fields of type 'FIELD_NAME'
            acf.get_fields({type: 'iconmoon'}, jQueryel).each(function () {
                initialize_field($(this));
            });
        });
    } else {
        /*
         *  acf/setup_fields (ACF4)
         *
         *  This event is triggered when ACF adds any new elements to the DOM.
         *
         *  @type	function
         *  @since	1.0.0
         *  @date	01/01/12
         *
         *  @param	event		e: an event object. This can be ignored
         *  @param	Element		postbox: An element which contains the new HTML
         *
         *  @return	n/a
         */
        $(document).on('acf/setup_fields', function (e, postbox) {
            $(postbox).find('.field[data-field_type="iconmoon"]').each(function () {
                console.log($(this));
                initialize_field($(this));
            });
        });
    }
})(jQuery);
