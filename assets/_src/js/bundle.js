import './trophy-modal';
import './honour-roll';

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
      console.log(buttonName);

      // Toggle display trash icon
      const completeButton = modal.querySelector('.btn-complete');
      const editButton = modal.querySelector('.btn-edit');
      const trashButton = modal.querySelector('.btn-trash');

      if (event.target.innerText.toLowerCase() == 'edit') {
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
      document.querySelector('.js-peak_county').value = data.posttitle;
      document.querySelector('.js-peak-country').value = data.country;
      document.querySelector('.js-summit-date').value =
        data.date != '' ? data.date : '';
      document.querySelector('.js-field-report').value =
        data.fieldreport != '' ? data.fieldreport : '';
      document.querySelector('.js-button-type').value = buttonName;
      document.querySelector('.js-modal-title').innerHTML =
      `<span>${buttonName}</span> ${data.name}`;

      // Preview image
      const previewImg =
        document.querySelector('.js-preview-image');
      if (data.guid != '') {
        previewImg.querySelector('.js-peak-summit-image-preview').src =
            data.guid;
        previewImg.classList.remove('d-none');
      } else {
        previewImg.src = '';
        previewImg.classList.add('d-none');
      }
    });
  });
};


const modalErrors = () => {
  const peakError = document.querySelector('#county-tops-tabs .active');
  const button = peakError.querySelectorAll('.btn');

  const urlSearchParams = new URLSearchParams(window.location.search);
  const params = Object.fromEntries(urlSearchParams.entries());
  console.log(params);

  if (params.error_id) {
    console.log('HAS ERROR');
    console.log(parseInt(params.error_id));
    for (let i = 0; i < button.length; i++) {
      if (button[i].dataset.id == params.error_id) {
        setTimeout(() => {
          $(`#peak-${params.error_id}`).click();
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


document.addEventListener('DOMContentLoaded', () => {
  const modal = document.querySelector('#historic-modal');
  if (!modal) return;

  modalErrors(modal);
  historicCountyTopModal();
  modalUpdateSuccessful();
  clearModalErrors();
});
