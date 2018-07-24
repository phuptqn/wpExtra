jQuery(function ($) {

    $('.lsow-piecharts').waypoint(function (direction) {

        $(this.element).find('.lsow-piechart .lsow-percentage').each(function () {

            var track_color = $(this).data('track-color');
            var bar_color = $(this).data('bar-color');

            $(this).easyPieChart({
                animate: 2000,
                lineWidth: 10,
                barColor: bar_color,
                trackColor: track_color,
                scaleColor: false,
                lineCap: 'square',
                size: 220

            });

        });

    }, { offset: Waypoint.viewportHeight() - 100,
        triggerOnce: true});


});