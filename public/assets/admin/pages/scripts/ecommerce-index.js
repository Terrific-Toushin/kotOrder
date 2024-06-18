var EcommerceIndex = function () {

    function showTooltip(x, y, labelX, labelY) {
        $('<div id="tooltip" class="chart-tooltip">' + (labelY.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + 'USD<\/div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 60,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#fff'
        }).appendTo("body").fadeIn(200);
    }





    return {

        //main function
        init: function () {
            initChart1();

            // $('#statistics_amounts_tab').on('shown.bs.tab', function (e) {
            //     initChart2();
            // });
        }

    };

}();
