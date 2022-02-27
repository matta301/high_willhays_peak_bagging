const trophyIcons = (trophyModal, unique) => {
  const allRows = trophyModal.querySelectorAll('.honour-roll-row');
  for (let i = 0; i < allRows.length; i++) {
    // First Place
    if (allRows[i].dataset.position == unique[0]) {
      const award =
      allRows[i].querySelector(`.place-${unique[0]} .award`);
      award.innerHTML = '<i class="bi bi-trophy"></i>';
    }

    // Second Place
    if (allRows[i].dataset.position == unique[1]) {
      const award =
      allRows[i].querySelector(`.place-${unique[1]} .award`);
      award.innerHTML = '<i class="bi bi-award"></i>';
    }

    // Third Place
    if (allRows[i].dataset.position == unique[2]) {
      const award =
      allRows[i].querySelector(`.place-${unique[2]} .award`);
      award.innerHTML = '<i class="bi bi-award"></i>';
    }
  }
};

const rankings = (trophyModal) => {
  const allTotals = trophyModal.querySelectorAll('.total-peaks');
  const totalsArray = [];
  let unique;

  for (let i = 0; i < allTotals.length; i++) {
    totalsArray.push(allTotals[i].innerText);
    unique = [...new Set(totalsArray)];
    const elem = allTotals[i].parentElement.dataset.position;

    if (elem == unique[0]) {
      allTotals[i].parentElement.classList.add('table-warning');
    }

    if (elem == unique[1]) {
      allTotals[i].parentElement.classList.add('table-success');
    }

    if (elem == unique[2]) {
      allTotals[i].parentElement.classList.add('table-secondary');
    }
  }

  trophyIcons(trophyModal, unique);
};

document.addEventListener('DOMContentLoaded', () => {
  const trophyModal = document.querySelector('.honour-roll-page');
  if (!trophyModal) return;

  rankings(trophyModal);
});
