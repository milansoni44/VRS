/*$(function () {
var chart = c3.generate({

    bindto: '#chart',

    data: {
    columns: [
    ['data1', 30, 200, 100, 400, 150, 250],
    ['data2', 50, 20, 10, 40, 15, 25]
    ],
    types: {
    data1: 'line',
    data2: 'line'
    }
},

axis: {
    x: {
    type: 'categorized'
    }
}

});



});*/

$(function () {
    $.ajax({
            url:"http://localhost/VRS/index.php/webservices/getDaywiseIncomeExpense",
            type : "GET",
            async : false,
            // dataType: "json",
            success: function(response){
                    //alert(JSON.parse(response));
                    // alert(response);
                    var chart = c3.generate({
                    bindto: '#combine-chart',
                    data: {
                        columns: [
                            JSON.parse(response).income,
                            JSON.parse(response).expense,
                            //['Income', 30, 20, 50, 40, 60, 50,30, 20, 50, 40, 60, 50, 30, 20, 50, 40, 60, 50,30, 20, 50, 40, 60, 50,30, 20, 50, 40, 60, 50],
                            //['Expense', 30, 130, 90, 240, 130, 220,30, 130, 90, 240, 130, 220, 30, 20, 50, 40, 60, 50,30, 20, 50, 40, 60, 50,30, 20, 50, 40, 60, 50],
                          
                        ],
                        types: {
                            Income: 'bar',
                            Expense: 'bar',
                            
                        },
                        colors: {
                            Income: '#65CEA7',
                            Expense: '#FC8675',
                        },
                       
                    },
                     axis: {
                        x: {
                            type: 'categorized'
                        }
                    }
                });
            },
        });
});
    $(function () {
    var chart = c3.generate({
        bindto: '#roated-chart',
        data: {
        columns: [
        ['data1', 30, 200, 100, 400, 150, 250],
        ['data2', 50, 20, 10, 40, 15, 25]
        ],
        types: {
        data1: 'bar'
        }
    },
    axis: {
        rotated: true,
        x: {
        type: 'categorized'
        }
    }
    });
    });