const historicCountyTopModal = () => {
  const modal = document.querySelector('#historic-modal');
  if (!modal) {
    return;
  }

  const button = document.querySelectorAll('.js-btn-complete');
  button.forEach((element) => {
    element.addEventListener('click', (event) => {
      const data = event.target.dataset;
      const buttonName = event.target.innerText.toLowerCase();
      console.log(data);

      // Toggle display trash icon
      const completeButton = modal.querySelector('.btn-complete');
      const editButton = modal.querySelector('.btn-edit');
      const trashButton = modal.querySelector('.btn-trash');

      if (event.target.innerText == 'Edit') {
        editButton.classList.remove('d-none');
        trashButton.classList.remove('d-none');
        completeButton.classList.add('d-none');

        // Inputs
        modal.querySelector('.js-summit-date').value = data.date;
        modal.querySelector('.js-field-report').value = data.fieldreport;
      } else {
        editButton.classList.add('d-none');
        trashButton.classList.add('d-none');
        completeButton.classList.remove('d-none');
      }

      document.querySelector('.js-county-top-id').value = data.id;
      document.querySelector('.js-peak-country').value = data.country;
      document.querySelector('.js-button-type').value = buttonName;
      document.querySelector('.js-modal-title').innerHTML =
      `<span>${buttonName}</span> ${data.name}`;
    });
  });
};


const modalFormErrors = () => {
  const peakError = document.querySelector('#county-tops-tabs');
  const button = peakError.querySelectorAll('.btn-outline-primary');

  const urlSearchParams = new URLSearchParams(window.location.search);
  const params = Object.fromEntries(urlSearchParams.entries());

  if (params.error_id) {
    for (let i = 0; i < button.length; i++) {
      if (button[i].dataset.id == params.error_id) {
        setTimeout(() => {
          $(`#${button[i].id}`).click();
        }, 500);
      }
    }
  }
};


const modalUpdateSuccessful = () => {
  const body = document.querySelector('.page-template-page-peakbagging');
  if (!body) return;

  const urlSearchParams = new URLSearchParams(window.location.search);
  const params = Object.fromEntries(urlSearchParams.entries());

  const alert =
  `<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Update Successful!</strong>
    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
    >
    </button>
  </div>`;

  if (params.update == 'success') {
    body.insertAdjacentHTML('afterbegin', alert);

    setTimeout(() => {
      document.querySelector('.alert').remove();
    }, 3000);
  }
};


const clearModalErrors = () => {
  $('#historic-modal').on('hidden.bs.modal', function() {
    const errors = document.querySelectorAll('.form-error');
    for (let i = 0; i < errors.length; i++) {
      errors[i].remove();
    }
  });
};


const showSuccessBadge = () => {
  const urlSearchParams = new URLSearchParams(window.location.search);
  const params = Object.fromEntries(urlSearchParams.entries());

  if (params.success) {
    console.log(true);
    $('.bd-example-modal-sm').modal('show');
  }
};

document.addEventListener('DOMContentLoaded', () => {
  modalFormErrors();
  historicCountyTopModal();
  showSuccessBadge();
  modalUpdateSuccessful();
  clearModalErrors();
});
