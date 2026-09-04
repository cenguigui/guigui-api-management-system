$(document).ready(function () {
    // Theme Switch
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    $('#theme-toggle').click(function () {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';

        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
    });

    function updateThemeIcon(theme) {
        const icon = theme === 'light' ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
        $('#theme-toggle').html(icon);
    }

    // Search Functionality
    $('.search-input').on('keyup', function () {
        const value = $(this).val().toLowerCase();
        $('.api-card').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Mobile Menu (Simple toggle)
    $('.mobile-menu-btn').click(function () {
        // Implementation for mobile menu if needed
    });
});
