async function getData() {
    const response = await fetch('allDay.csv');
    const data = await response.text();
    console.log(data);
    
}
getData();