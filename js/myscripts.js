
const xrlabel = [];
const yrlabel = [];

chartItR();
async function chartItR() {
    await getDataR();
    const cty = document.getElementById('myChartA').getContext('2d');

    const myChartR = new Chart(cty, {
        type: 'line',
        data: {
            labels: xrlabel,
            datasets: [{
                label: 'temprature',
                data: yrlabel,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1
            }]
        },
        // options: {
        //     scales: {
        //         yAxes: [{
        //             ticks: {
        //                 beginAtZero: true
        //             }
        //         }]
        //     }
        // }
    });
}
async function getDataR() {
    const response = await fetch('allDay.csv');
    const data = await response.text();
    // console.log(data);

    const table = data.split('\n');

    table.forEach(row => {
        const columns = row.split(',');
        const time = columns[0];
        xrlabel.push(time);
        const temp = columns[1];
        yrlabel.push(temp);
        // console.log(time, temp);
    });
}

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('currentTime').innerHTML =
        h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    }; // add zero in front of numbers < 10
    return i;
}