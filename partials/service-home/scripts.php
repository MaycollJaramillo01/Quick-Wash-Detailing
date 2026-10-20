<script>
(() => {
  const root = document.querySelector('[data-shm-root]');
  if (!root) return;

  const cards = Array.from(root.querySelectorAll('[data-shm-card]'));
  const filters = Array.from(root.querySelectorAll('[data-shm-filter]'));
  const searchInput = root.querySelector('#shmSearch');
  const clearBtn = root.querySelector('#shmClear');
  const resultsEl = root.querySelector('#shmResults');

  if (!cards.length) return;

  let activeFilter = 'all';
  let query = '';

  const updateResults = () => {
    const total = cards.length;
    const shown = cards.filter(card => !card.classList.contains('is-hidden')).length;
    if (resultsEl) {
      resultsEl.textContent = `Showing: ${shown} / ${total}`;
    }
  };

  const apply = () => {
    const normalizedQuery = query.trim().toLowerCase();

    cards.forEach(card => {
      const group = (card.getAttribute('data-shm-group') || '').toLowerCase();
      const text = (card.getAttribute('data-shm-search') || '').toLowerCase();

      const matchesFilter = (activeFilter === 'all') || (group === activeFilter);
      const matchesQuery = (normalizedQuery === '') || text.includes(normalizedQuery);

      card.classList.toggle('is-hidden', !(matchesFilter && matchesQuery));
    });

    updateResults();
  };

  filters.forEach(filterBtn => {
    filterBtn.addEventListener('click', () => {
      activeFilter = (filterBtn.getAttribute('data-shm-filter') || 'all').toLowerCase();

      filters.forEach(btn => {
        const active = (btn === filterBtn);
        btn.classList.toggle('is-active', active);
        btn.setAttribute('aria-pressed', active ? 'true' : 'false');
      });

      apply();
    });
  });

  let debounceTimer = null;
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      window.clearTimeout(debounceTimer);
      debounceTimer = window.setTimeout(() => {
        query = searchInput.value || '';
        apply();
      }, 120);
    });

    searchInput.addEventListener('keydown', event => {
      if (event.key !== 'Escape') return;
      searchInput.value = '';
      query = '';
      apply();
      searchInput.blur();
    });
  }

  if (clearBtn && searchInput) {
    clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      query = '';
      apply();
      searchInput.focus();
    });
  }

  const focusHashCard = () => {
    const rawHash = (window.location.hash || '').replace('#', '').trim();
    if (!rawHash) return;

    const target = document.getElementById(rawHash);
    if (!target || !target.hasAttribute('data-shm-card')) return;

    const targetGroup = (target.getAttribute('data-shm-group') || 'all').toLowerCase();
    const targetFilterButton = filters.find(btn => ((btn.getAttribute('data-shm-filter') || '').toLowerCase() === targetGroup));
    if (targetFilterButton) targetFilterButton.click();

    cards.forEach(card => card.classList.remove('is-focused'));
    target.classList.add('is-focused');
    window.setTimeout(() => target.classList.remove('is-focused'), 1600);
  };

  window.addEventListener('hashchange', focusHashCard);
  window.setTimeout(() => {
    apply();
    focusHashCard();
  }, 100);
})();
</script>
