import Chart from 'chart.js/auto';

const initDoughnut = () => {
  const totals = sessionStorage.getItem('totals');
  if (!totals) return;

  const data = {
    labels: [
      'Scotland',
      'England',
      'Wales',
      'N. Ireland',
    ],
    datasets: [{
      data: JSON.parse(totals),
      backgroundColor: [
        'rgb(61, 109, 162)',
        'rgb(207, 20, 43)',
        'rgb(2, 170, 57)',
        'rgb(251, 210, 84)',
      ],
      hoverOffset: 4,
    }],
  };

  const config = {
    type: 'doughnut',
    data: data,
    options: {
      plugins: {
        legend: {
          position: 'bottom',
        },
      },
    },
  };

  new Chart(document.getElementById('doughnut'), config);
};

document.addEventListener('DOMContentLoaded', () => {
  const doughnutChart = document.querySelector('#doughnut');
  if (!doughnutChart) return;

  initDoughnut();
});
