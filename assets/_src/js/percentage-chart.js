import progressbar from 'progressbar.js';

const initPercentageChart = (percentageChart) => {
  const completedData = sessionStorage.getItem('completed');
  if (!completedData) return;

  const completedTotal = JSON.parse(completedData);
  const totalPeaks = '93';
  const circle = new progressbar.Circle(percentageChart, {
    color: '#7B5545',
    strokeWidth: 8,
    trailWidth: 1,
    text: {
      value: `${completedTotal.length} / ${totalPeaks}
        <br/><small>Completed Peaks</small>`,
      style: {
        color: '#999',
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        textAlign: 'center',
      },
    },
  });
  circle.animate(completedTotal.length / totalPeaks);
};

document.addEventListener('DOMContentLoaded', () => {
  const percentageChart = document.querySelector('.js-percentage-chart');
  if (!percentageChart) return;
  initPercentageChart(percentageChart);
});
