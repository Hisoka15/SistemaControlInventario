'use strict';
const dataEmptyComponent = () => {
    const noData = document.createElement('div');
    noData.className = 'text-center w-full text-gray-500 border-2 border-dashed border-zinc-200 text-xs gap-1 flex flex-col items-center justify-center h-96';
    noData.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-no-axes-combined-icon lucide-chart-no-axes-combined"><path d="M12 16v5"/><path d="M16 14v7"/><path d="M20 10v11"/><path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15"/><path d="M4 18v3"/><path d="M8 14v7"/></svg><span>No hay datos disponibles</span>`;
    return noData;
}

const getInfo = [
    {
        type: 'product',
        data: [],
        componentId: 'containerChartBar',
    },
    {
        type: 'sale',
        data: [],
        componentId: 'containerChartLine',
    }
]

function getStatistics(typeStatistics) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/api/${typeStatistics}/statistics`,
            type: 'GET',
            success: function(response) {
                resolve(response);
            },
            error: function(error) {
                console.log(error);
                reject(error);
            }
        });
    });
}
async function loadStatistics() {
    for (let i = 0; i < getInfo.length; i++) {
        const data = await getStatistics(getInfo[i].type);
        if( data[0].value.length === 0) {
            const container = document.getElementById(getInfo[i].componentId);
            container.innerHTML = '';
            container.appendChild(dataEmptyComponent());
            continue;
        }
        getInfo[i].data = data;
    }
}

function loadDataForChartBar(data) {
    return {
        series: [{
            name: "Ventas",
            data: data[0].value
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                borderRadiusApplication: 'end',
                horizontal: true,
            }
        },
        title: {
            text: 'Productos mas vendidos en los ultimos 30 dias',
            align: 'left'
        },
        subtitle: {
            text: '10 productos mas vendidos',
            align: 'left'
        },
        legend: {
            horizontalAlign: 'left'
        },
        dataLabels: {
            enabled: true
        },
        xaxis: {
            categories: data[0].product,
        }
    };
}

function loadDataForChartLine(data){
    return {
        series: [{
            name: "Ventas",
            data: data[0].value
        },
        {
            name: "Ganancias",
            data: data[0].profits
        }],
        chart: {
            type: 'area',
            height: 350,
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val.toLocaleString('es-ES', { style: 'currency', currency: 'NIO' });
            }
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Ventas en los ultimos 30 dias',
            align: 'left'
        },
        labels: data[0].dates,
        xaxis: {
            type: 'datetime',
        },
        yaxis: {
            opposite: true
        },
        legend: {
            horizontalAlign: 'left'
        }
    };
}

$(document).ready(async () => {
    await loadStatistics();
    const CHARTS = [
        {
            id: 'chartBar',
            data: getInfo[0].data,
            initialLoad: loadDataForChartBar
        },
        {
            id: 'chartLine',
            data: getInfo[1].data,
            initialLoad: loadDataForChartLine
        }
    ]
    CHARTS.forEach(chart => {
        if (chart.data.length !== 0) {
            const initializationChart = new ApexCharts(document.querySelector(`#${chart.id}`), chart.initialLoad(chart.data));
            initializationChart.render();
        } else {
            const container = document.getElementById(chart.id);
            container.innerHTML = '';
            container.appendChild(dataEmptyComponent());
        }
    });
});
