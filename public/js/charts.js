$(function(){

    Chart.defaults.global.responsive = true;

    $('.get-charts').click(function(e){
        e.preventDefault();
        var date_start = $('.date-start').val();
        var date_finish = $('.date-finish').val();
        var url = '/admin/pedidos-estatisticas?date_start=' + date_start + '&date_finish=' + date_finish;

        $.getJSON(url, function (result) {
            chartOrders(result);
            chartOrdersSales(result);
            chartOrdersDebits(result);
            $('.charts').find('label').removeClass('hide');
        });
    });


});

function chartOrders (result){
    var labels = [],data=[];
    for (var i = 0; i < result.orders.length; i++) {
        labels.push(monthTranslate(result.orders[i].month));
        data.push(result.orders[i].pedidos);
    }

    var buyerData = {
        labels : labels,
        datasets : [
            {
                label: "Pedidos Finalizados",
                fillColor: "#5196B9",
                strokeColor: "#5196B9",
                highlightFill: "#5196B9",
                highlightStroke: "#5196B9",
                data : data
            }
        ]
    };
    var buyers = document.getElementById('chart-orders').getContext('2d');
    new Chart(buyers).Bar(buyerData, {
        bezierCurve : true,
        multiTooltipTemplate: "<%= value %>"
    });
}

function chartOrdersSales (result){
    var labels = [],data=[];
    for (var i = 0; i < result.priceTotal.length; i++) {
        labels.push(monthTranslate(result.priceTotal[i].month));
        data.push(result.priceTotal[i].priceTotal);
    }

    var buyerData = {
        labels : labels,
        datasets : [
            {
                fillColor: "#49AF2B",
                strokeColor: "#49AF2B",
                highlightFill: "#49AF2B",
                highlightStroke: "#49AF2B",
                data : data
            }
        ]
    };
    var buyers = document.getElementById('chart-orders-sales').getContext('2d');
    new Chart(buyers).Line(buyerData, {
        bezierCurve : true,
        multiTooltipTemplate: "<%= datasetLabel %> - <%= Quantidade de pedidos por mês %>"
    });
}

function chartOrdersDebits (result){
    var labels = [],data=[], debits = [];
    for (var i = 0; i < result.priceTotal.length; i++) {
        labels.push(monthTranslate(result.priceTotal[i].month));
        data.push(result.priceTotal[i].priceTotal);
    }

    for (var i = 0; i < result.debits.length; i++) {
        debits.push(result.debits[i].debits);
    }

    var buyerData = {
        labels : labels,
        datasets : [
            {
                fillColor: "#5196B9",
                strokeColor: "#5196B9",
                highlightFill: "#5196B9",
                highlightStroke: "#5196B9",
                pointColor : "#5196B9",
                pointStrokeColor : "#5196B9",
                data : data
            },
            {
                fillColor : "#D26525",
                strokeColor : "#D26525",
                pointColor : "#D26525",
                pointStrokeColor : "#D26525",
                highlightFill: "#D26525",
                highlightStroke: "#D26525",
                data : debits
            }
        ]
    };
    var buyers = document.getElementById('chart-orders-debits').getContext('2d');
    new Chart(buyers).Bar(buyerData, {
        bezierCurve : true
    });
}

function monthTranslate(month)
{
    switch (month){
        case 'January':
            return 'Janeiro';
            break;
        case 'February':
            return 'Fevereiro';
            break;
        case 'March':
            return 'Março';
            break;
        case 'April':
            return 'Abril';
            break;
        case 'May':
            return 'Maio';
            break;
        case 'June':
            return 'Junho';
            break;
        case 'July':
            return 'Julho';
            break;
        case 'August':
            return 'Agosto';
            break;
        case 'September':
            return 'Setembro';
            break;
        case 'October':
            return 'Outubro';
            break;
        case 'November':
            return 'Novembro';
            break;
        case 'December':
            return 'Dezembro';
            break;
    }
}