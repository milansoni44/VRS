/**
 * Created by westilian on 1/19/14.
 */

(function(){
    var t;
    function size(animate){
        if (animate == undefined){
            animate = false;
        }
        clearTimeout(t);
        t = setTimeout(function(){
            $("canvas").each(function(i,el){
                $(el).attr({
                    "width":$(el).parent().width(),
                    "height":$(el).parent().outerHeight()
                });
            });
            redraw(animate);
            var m = 0;
            $(".chartJS").height("");
            $(".chartJS").each(function(i,el){ m = Math.max(m,$(el).height()); });
            $(".chartJS").height(m);
        }, 30);
    }
    $(window).on('resize', function(){ size(false); });
    
    function get_date(){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var today = dd+'/'+mm+'/'+yyyy;
        return today;
    }
    var barChartData1;
    var barChartData2;
    var barChartData3;
    var barChartData4;
    function redraw(animation){
        var options = {};
        if (!animation){
            options.animation = false;
        } else {
            options.animation = true;
        }
        /*$.ajax({
            url:"http://localhost/VRS/index.php/webservices/DailyIncomeAndExpense",
            type : "GET",
            async : true,
            // dataType: "json",
            success: function(response){
                var date = get_date();
                //alert(JSON.parse(response).dayIncome);
                barChartData1 = {
                    labels : [date],
                    datasets : [
                        {
                            fillColor : "#FC8675",
                            strokeColor : "#FC8675",
                            data : [JSON.parse(response).dayIncome]
                        },
                        {
                            fillColor : "#6dc5a3",
                            strokeColor : "#6dc5a3",
                            data : [JSON.parse(response).dayExpense]
                        }
                    ]

                }
            },
        }); */
         
        //barChartData1 = loadXMLDoc();
        //alert(barChartData1);
        // var barChartData1 = {
            // labels : ["08-06-2015"],
            // datasets : [
                // {
                    // fillColor : "#FC8675",
                    // strokeColor : "#FC8675",
                    // data : [65]
                // },
                // {
                    // fillColor : "#6dc5a3",
                    // strokeColor : "#6dc5a3",
                    // data : [28]
                // }
            // ]

        // }
         $.ajax({
            url:"http://localhost/VRS/index.php/webservices/getDaywiseIncomeExpense",
            type : "GET",
            async : false,
            // dataType: "json",
            success: function(response){
                var days = JSON.parse(response).days;
                var income = JSON.parse(response).income;
                // alert(income);
                var expense = JSON.parse(response).expense;
                barChartData2 = {
                labels : JSON.parse(response).days,
                // labels : ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"],
                datasets : [
                    {
                        fillColor : "#6dc5a3",
                        strokeColor : "#6dc5a3",
                        data : income
                    },
                    {
                        fillColor : "#FC8675",
                        strokeColor : "#FC8675",
                        data : expense
                    }
                ]

              }
            },
        });
        // var barChartData2 = {
            // labels : [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
            // datasets : [
                // {
                    // fillColor : "#FC8675",
                    // strokeColor : "#FC8675",
                    // data : [65,59,90,81,56,55,40,65,59,90,81,56,55,40,65,59,90,81,56,55,40,65,59,90,81,56,55,40]
                // },
                // {
                    // fillColor : "#6dc5a3",
                    // strokeColor : "#6dc5a3",
                    // data : [28,48,40,19,96,27,100,28,48,40,19,96,27,100,28,48,40,19,96,27,100,28,48,40,19,96,27,100]
                // }
            // ]

        // }
        /*$.ajax({
            url:"http://localhost/VRS/index.php/webservices/vehicleIncomeByRent",
            type : "GET",
            async : false,
            // dataType: "json",
            success: function(response){
                //alert(JSON.parse(response)[1].income);
                document.getElementById("top1").innerHTML=JSON.parse(response)[0].vehicle_reg_no; 
                document.getElementById("top2").innerHTML=JSON.parse(response)[1].vehicle_reg_no; 
                document.getElementById("top3").innerHTML=JSON.parse(response)[2].vehicle_reg_no; 
                document.getElementById("top4").innerHTML=JSON.parse(response)[3].vehicle_reg_no; 
                document.getElementById("top5").innerHTML=JSON.parse(response)[4].vehicle_reg_no; 
                barChartData3 = {
                    labels : ["TOP 5 CARS"],
                    datasets : [
                        {
                            fillColor : "#319fa1",
                            strokeColor : "#319fa1",
                            data : [JSON.parse(response)[0].income]
                        },
                        {
                            fillColor : "#EBC85E",
                            strokeColor : "#EBC85E",
                            data : [JSON.parse(response)[1].income]
                        },
                        {
                            fillColor : "#FC8675",
                            strokeColor : "#FC8675",
                            data : [JSON.parse(response)[2].income]
                        },
                        {
                            fillColor : "#9F79EE",
                            strokeColor : "#9F79EE",
                            data : [JSON.parse(response)[3].income]
                        },
                        {
                            fillColor : "#5AB6DF",
                            strokeColor : "#5AB6DF",
                            data : [JSON.parse(response)[4].income]
                        },
                        
                        
                    ]

                }
            },
        });*/
        // var barChartData3 = {
            // labels : ["TOP 5 CARS"],
            // datasets : [
                // {
                    // fillColor : "#319fa1",
                    // strokeColor : "#319fa1",
                    // data : [8050]
                // },
                // {
                    // fillColor : "#EBC85E",
                    // strokeColor : "#EBC85E",
                    // data : [6500]
                // },
                // {
                    // fillColor : "#FC8675",
                    // strokeColor : "#FC8675",
                    // data : [7500]
                // },
                // {
                    // fillColor : "#9F79EE",
                    // strokeColor : "#9F79EE",
                    // data : [12500]
                // },
                // {
                    // fillColor : "#5AB6DF",
                    // strokeColor : "#5AB6DF",
                    // data : [12500]
                // },
                
                
            // ]

        // }
         /*$.ajax({
            url:"http://vakratundasystem.in/VRS/admin/index.php/webservices/vehicleIncomeByRentLeast",
            type : "GET",
            async : false,
            // dataType: "json",
            success: function(response){
               // alert(JSON.parse(response)[2].incomeleast);
                document.getElementById("bottom1").innerHTML=JSON.parse(response)[0].vehicle_reg_no; 
                document.getElementById("bottom2").innerHTML=JSON.parse(response)[1].vehicle_reg_no; 
                document.getElementById("bottom3").innerHTML=JSON.parse(response)[2].vehicle_reg_no; 
                document.getElementById("bottom4").innerHTML=JSON.parse(response)[3].vehicle_reg_no; 
                document.getElementById("bottom5").innerHTML=JSON.parse(response)[4].vehicle_reg_no; 
                barChartData4 = {
                    labels : ["LEAST 5 CARS"],
                    datasets : [
                        {
                            fillColor : "#319fa1",
                            strokeColor : "#319fa1",
                            data : JSON.parse(response)[0].incomeleast
                        },
                        {
                            fillColor : "#EBC85E",
                            strokeColor : "#EBC85E",
                            data : JSON.parse(response)[1].incomeleast
                        },
                        {
                            fillColor : "#FC8675",
                            strokeColor : "#FC8675",
                            data : JSON.parse(response)[2].incomeleast
                        },
                        {
                            fillColor : "#9F79EE",
                            strokeColor : "#9F79EE",
                            data : JSON.parse(response)[3].incomeleast
                        },
                        {
                            fillColor : "#5AB6DF",
                            strokeColor : "#5AB6DF",
                            data : JSON.parse(response)[4].incomeleast
                        },
                        
                        
                    ]

                }
                
            },
        });*/
        // var barChartData4 = {
            // labels : ["LEAST 5 CARS"],
            // datasets : [
                // {
                    // fillColor : "#319fa1",
                    // strokeColor : "#319fa1",
                    // data : [8050]
                // },
                // {
                    // fillColor : "#EBC85E",
                    // strokeColor : "#EBC85E",
                    // data : [6500]
                // },
                // {
                    // fillColor : "#FC8675",
                    // strokeColor : "#FC8675",
                    // data : [7500]
                // },
                // {
                    // fillColor : "#9F79EE",
                    // strokeColor : "#9F79EE",
                    // data : [12500]
                // },
                // {
                    // fillColor : "#5AB6DF",
                    // strokeColor : "#5AB6DF",
                    // data : [12500]
                // },
                
                
            // ]

        // }
        

        //var myLine1 = new Chart(document.getElementById("bar-chart-js").getContext("2d")).Bar(barChartData1);
        //var myLine2 = new Chart(document.getElementById("bar-chart-js1").getContext("2d")).Bar(barChartData2);
        //var myLine3 = new Chart(document.getElementById("bar-chart-js2").getContext("2d")).Bar(barChartData3);
        //var myLine4 = new Chart(document.getElementById("bar-chart-js3").getContext("2d")).Bar(barChartData4);
        


        var Linedata = {
            labels : ["January","February","March","April","May","June","July"],
            datasets : [
                {
                    fillColor : "#2a323f",
                    strokeColor : "#2a323f",
                    pointColor : "#2a323f",
                    pointStrokeColor : "#fff",
                    data : [100,159,190,281,156,155,140]
                },
                {
                    fillColor : "#6dc5a3",
                    strokeColor : "#6dc5a3",
                    pointColor : "#6dc5a3",
                    pointStrokeColor : "#fff",
                    data : [65,59,90,181,56,55,40]
                },
                {
                    fillColor : "#5f728f",
                    strokeColor : "#5f728f",
                    pointColor : "#5f728f",
                    pointStrokeColor : "#fff",
                    data : [28,48,40,19,96,27,100]
                }

            ]
        }
        // var myLineChart = new Chart(document.getElementById("line-chart-js").getContext("2d")).Line(Linedata);


        var pieData = [
            {
                value: 30,
                color:"#2a323f"
            },
            {
                value : 50,
                color : "#5f728f"
            },
            {
                value : 100,
                color : "#6dc5a3"
            }

        ];

        // var myPie = new Chart(document.getElementById("pie-chart-js").getContext("2d")).Pie(pieData);



        var donutData = [
            {
                value: 30,
                color:"#2a323f"
            },
            {
                value : 50,
                color : "#5f728f"
            },
            {
                value : 100,
                color : "#6dc5a3"
            },
            {
                value : 40,
                color : "#95D7BB"
            },
            {
                value : 120,
                color : "#b8d3f5"
            }

        ]
        //var myDonut = new Chart(document.getElementById("donut-chart-js").getContext("2d")).Doughnut(donutData);
    }




    size(true);

}());
