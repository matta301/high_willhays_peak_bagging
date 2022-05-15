const deleteAccount = () => {
  document.querySelector('.js-delete-peakbagging-account').value = '';
};

document.addEventListener('DOMContentLoaded', () => {
  const modal = document.querySelector('#historicModal');
  if (!modal) {
    return;
  }

  deleteAccount();
});
