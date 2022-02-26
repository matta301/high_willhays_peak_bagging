// Show modal when complete county top
const showTrophyModal = () => {
  const urlSearchParams = new URLSearchParams(window.location.search);
  const params = Object.fromEntries(urlSearchParams.entries());
  if (params.completed) {
    populateBadge(params);
    $('.bd-example-modal-sm').modal('show');
  }
};

// Populate image string and county name
const populateBadge = (params) => {
  document.querySelector('.congratulations-dialog-message span').innerHTML =
    params.county;
  document.querySelector('.congratulations-dialog-badge').src =
    location.origin +'/app/plugins/high_willhays_peak_bagging/assets/' +
    'images/badges/' + params.county + '-historic-county-top.png';
  return;
};

document.addEventListener('DOMContentLoaded', () => {
  const trophyModal = document.querySelector('.js-congratulations-dialog');
  if (!trophyModal) return;

  showTrophyModal();
});
