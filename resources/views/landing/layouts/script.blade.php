<script>
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('hidden');
    }
</script>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Optional: close dropdown if click outside
    document.addEventListener('click', function(event) {
        const button = document.getElementById('userMenuButton');
        const dropdown = document.getElementById('userDropdown');
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
@stack('scripts')
