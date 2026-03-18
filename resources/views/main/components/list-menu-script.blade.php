{{-- Shared script for toggleListMenu dropdown functionality --}}
<script>
  function toggleListMenu(e, btn) {
    e.preventDefault();
    e.stopPropagation();
    const menu = btn.nextElementSibling;
    const isHidden = menu.classList.contains('hidden');
    document.querySelectorAll('.list-dropdown').forEach(m => m.classList.add('hidden'));
    if (isHidden) { menu.classList.remove('hidden'); }
  }
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.list-menu-container')) {
      document.querySelectorAll('.list-dropdown').forEach(m => m.classList.add('hidden'));
    }
  });
</script>
