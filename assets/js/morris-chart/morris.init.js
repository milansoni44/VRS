// Morris.Bar({
    // element: 'graph-bar',
    // data: [
        // {x: '2011 Q1', y: 3, z: 2, a: 3},
        // {x: '2011 Q2', y: 2, z: null, a: 1},
        // {x: '2011 Q3', y: 0, z: 2, a: 4},
        // {x: '2011 Q4', y: 2, z: 4, a: 3}
    // ],
    // xkey: 'x',
    // ykeys: ['y', 'z', 'a'],
    // labels: ['Y', 'Z', 'A'],
    // barColors:['#414e62','#788ba0','#6dc5a3']


// });
$.ajax({
            url:"http://morningstarrentacar.com/VRS/index.php/webservices/vehicleIncomeByRent",
            type : "GET",
            async : false,
            // dataType: "json",
            success: function(response){
                //alert(JSON.parse(response).vehicle_reg_no[2]);
                Morris.Bar({
                    element: 'graph-bar',
                    data: [
                        {x: JSON.parse(response).vehicle_reg_no[0], income: JSON.parse(response).income[0]},
                        {x: JSON.parse(response).vehicle_reg_no[1], income: JSON.parse(response).income[1]},
                        {x: JSON.parse(response).vehicle_reg_no[2], income: JSON.parse(response).income[2]},
                        {x: JSON.parse(response).vehicle_reg_no[3], income: JSON.parse(response).income[3]},
                        {x: JSON.parse(response).vehicle_reg_no[4], income: JSON.parse(response).income[4]},
                    ],
                    xkey: 'x',
                    ykeys: ['income'],
                    labels: ['Income'],
                    // barColors:['#414e62']
                    barColors: function (row, series, type) {
                    // console.log("--> "+row.label, series, type);
                    if(row.label == JSON.parse(response).vehicle_reg_no[0]) return "#AD1D28";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[1]) return "#DEBB27";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[2]) return "#fec04c";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[3]) return "#1AB244";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[4]) return "#000";
                    }

                });
            },
        });
        
    $.ajax({
            url:"http://morningstarrentacar.com/VRS/index.php/webservices/vehicleIncomeByRentLeast",
            type : "GET",
            async : false,
            // dataType: "json",
            success: function(response){
                // alert(response);
                Morris.Bar({
                    element: 'graph-bar1',
                    data: [
                        {x: JSON.parse(response).vehicle_reg_no[0], income: JSON.parse(response).income[0]},
                        {x: JSON.parse(response).vehicle_reg_no[1], income: JSON.parse(response).income[1]},
                        {x: JSON.parse(response).vehicle_reg_no[2], income: JSON.parse(response).income[2]},
                        {x: JSON.parse(response).vehicle_reg_no[3], income: JSON.parse(response).income[3]},
                        {x: JSON.parse(response).vehicle_reg_no[4], income: JSON.parse(response).income[4]},
                    ],
                    xkey: 'x',
                    ykeys: ['income'],
                    labels: ['Income'],
                    // barColors:['#414e62']
                    barColors: function (row, series, type) {
                    // console.log("--> "+row.label, series, type);
                    if(row.label == JSON.parse(response).vehicle_reg_no[0]) return "#AD1D28";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[1]) return "#DEBB27";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[2]) return "#fec04c";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[3]) return "#1AB244";
                    else if(row.label == JSON.parse(response).vehicle_reg_no[4]) return "#000";
                    }

                });
            },
        });    

var day_data = [
    {"elapsed": "I", "value": 34},
    {"elapsed": "II", "value": 24},
    {"elapsed": "III", "value": 3},
    {"elapsed": "IV", "value": 12},
    {"elapsed": "V", "value": 13},
    {"elapsed": "VI", "value": 22},
    {"elapsed": "VII", "value": 5},
    {"elapsed": "VIII", "value": 26},
    {"elapsed": "IX", "value": 12},
    {"elapsed": "X", "value": 19}
];
Morris.Line({
    element: 'graph-line',
    data: day_data,
    xkey: 'elapsed',
    ykeys: ['value'],
    labels: ['value'],
    lineColors:['#1FB5AD'],
    parseTime: false
});




// Use Morris.Area instead of Morris.Line
Morris.Area({
    element: 'graph-area-line',
    behaveLikeLine: false,
    data: [
        {x: '2011 Q1', y: 3, z: 3},
        {x: '2011 Q2', y: 2, z: 1},
        {x: '2011 Q3', y: 2, z: 4},
        {x: '2011 Q4', y: 3, z: 3},
        {x: '2011 Q5', y: 3, z: 4}
    ],
    xkey: 'x',
    ykeys: ['y', 'z'],
    labels: ['Y', 'Z'],
    lineColors:['#414e62','#6dc5a3']



});





// Use Morris.Area instead of Morris.Line
Morris.Donut({
    element: 'graph-donut',
    data: [
        {value: 70, label: 'foo', formatted: 'at least 70%' },
        {value: 15, label: 'bar', formatted: 'approx. 15%' },
        {value: 10, label: 'baz', formatted: 'approx. 10%' },
        {value: 5, label: 'A really really long label', formatted: 'at most 5%' }
    ],
    backgroundColor: '#fff',
    labelColor: '#1fb5ac',
    colors: [
        '#414e62','#788ba0','#6dc5a3','#95D7BB'
    ],
    formatter: function (x, data) { return data.formatted; }
});



// Use Morris.Area instead of Morris.Line
Morris.Area({
    element: 'graph-area',
    behaveLikeLine: true,
    gridEnabled: false,
    gridLineColor: '#dddddd',
    axes: true,
    fillOpacity:.7,
    data: [
        {period: '2010 Q1', iphone: 10, ipad: 10, itouch: 10},
        {period: '2010 Q2', iphone: 1778, ipad: 7294, itouch: 18441},
        {period: '2010 Q3', iphone: 4912, ipad: 12969, itouch: 3501},
        {period: '2010 Q4', iphone: 3767, ipad: 3597, itouch: 5689},
        {period: '2011 Q1', iphone: 6810, ipad: 1914, itouch: 2293},
        {period: '2011 Q2', iphone: 5670, ipad: 4293, itouch: 1881},
        {period: '2011 Q3', iphone: 4820, ipad: 3795, itouch: 1588},
        {period: '2011 Q4', iphone: 25073, ipad: 5967, itouch: 5175},
        {period: '2012 Q1', iphone: 10687, ipad: 34460, itouch: 22028},
        {period: '2012 Q2', iphone: 1000, ipad: 5713, itouch: 1791}


    ],
    lineColors:['#414e62','#788ba0','#6dc5a3'],
    xkey: 'period',
    ykeys: ['iphone', 'ipad', 'itouch'],
    labels: ['iPhone', 'iPad', 'iPod Touch'],
    pointSize: 0,
    lineWidth: 0,
    hideHover: 'auto'

});





