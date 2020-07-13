import Chart from 'chart.js';

(async () => {
    const response = await fetch('http://127.0.0.1:8001')
    const data = await response.json();

    const datasets = [];

    data['informationData'].forEach(informationData => {
        datasets.push({
            x: parseFloat(informationData[0]),
            y: parseFloat(informationData[1]),
        })
    });

    const dataSatosa = datasets.splice(0, 50);
    const dataVersicolor = datasets.splice(0, 50);

    const canvas = document.querySelector('canvas');
    const ctx = canvas.getContext('2d');

    const chart = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [
                {
                    label: 'Iris Satosa',
                    data: dataSatosa,
                    pointStyle: 'circle',
                    radius: 3,
                    borderWidth: 3,
                    borderColor: 'red',
                    backgroundColor: 'red',
                    fillStyle: 'red'
                },
                {

                    label: 'Iris Versicolor',
                    data: dataVersicolor,
                    pointStyle: 'crossRot',
                    radius: 5,
                    borderWidth: 3,
                    borderColor: 'blue',
                    pointBackgroundColor: 'blue',
                    backgroundColor: 'blue',
                }
            ],
        },
        options: {
            legend: {
                labels: {
                    fontColor: 'black',
                    color: 'blue'
                }
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Długość działki [cm]'
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Długość płatki [cm]'
                    }
                }]
            }
        }
    });

    chart.canvas.parentNode.style.width = '800px';
})();