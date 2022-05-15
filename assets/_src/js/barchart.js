import Chart from 'chart.js/auto';

/**
 * Generate random colour for bar chart
 * @return {color}
 */
const randomColourGenerator = () => {
  let color = '#';
  for (let i = 0; i < 3; i++) {
    color += ('0' + Math.floor(Math.random() *
      Math.pow(16, 2) / 2).toString(16)).slice(-2);
  }
  return color;
};

/**
 * Get the current year to display
 * in bar chart
 * @return {string} year
 */
const getCurrentYear = () => {
  const date = new Date();
  return date.getFullYear();
};

/**
 * Display chart on dashboard page
 * @param {string} currentYear
 */
const displayChart = (currentYear) => {
  const completedData = JSON.parse(sessionStorage.getItem('completed'));
  console.log(completedData.length);

  if (completedData.length > 0) {
    const data = [];
    const monthArray = ['1', '2', '3', '4', '5', '6', '7',
      '8', '9', '10', '11', '12'];

    let i;
    for (i = 0; i < monthArray.length; i++) {
      for (let j = 0; j < completedData.length; j++) {
        if (monthArray[i] == completedData[j].month &&
          completedData[j].year == currentYear) {
          const ele = completedData[j].elevation.replace(',', '').split('m');
          const dataSet = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
          dataSet.splice(i, 0, ele[0]);

          // Chart js bar chart object data
          const obj = {
            label: completedData[j].county_top_name,
            backgroundColor: randomColourGenerator(),
            pointBackgroundColor: 'white',
            borderWidth: 1,
            pointBorderColor: '#249EBF',
            data: dataSet,
            year: completedData[j].year,
            summitInfo: {
              peak_id: completedData[j].peak_id,
              county: completedData[j].county_top_name,
              date: completedData[j].summit_date,
            },
          };

          data.push(obj);
        }
      }
    }

    new Chart(document.getElementById('myChart'), {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May',
          'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: data,
      },
    });

    barChartTabs();
  }
};

const barChartTabs = () => {
  jQuery('.bar-chart .nav-link').on('click tap', function(e) {
    const year = e.target.innerText;
    const chart = Chart.getChart('myChart');
    chart.destroy();
    displayChart(year);
  });
};


document.addEventListener('DOMContentLoaded', () => {
  displayChart(getCurrentYear());

  document.querySelector('.bar-chart .nav-tabs .active').click();
});
