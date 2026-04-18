<a href="{{ route('dashboard') }}" class="brand-link">
    <img src="{{ asset('assets/image/logo.png') }}" alt="Logo {{ config('app.name', 'Laravel') }}" class="brand-image logo-lg" style="opacity: .8">
    <span class="brand-text font-weight-light ml-2"><strong>{{ config('app.name', 'Laravel') }}</strong></span>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const body = document.body;
        const sidebar = document.querySelector('.main-sidebar');
        const logoMini = document.querySelector('.logo-mini');
        const logoLg = document.querySelector('.logo-lg');

        function updateLogo() {
            const isCollapsed = body.classList.contains('sidebar-collapse');
            const isHovered = sidebar.matches(':hover');

            if (isCollapsed && !isHovered) {
                logoMini.classList.remove('d-none');
                logoLg.classList.add('d-none');
            } else {
                logoMini.classList.add('d-none');
                logoLg.classList.remove('d-none');
            }
        }

        updateLogo();

        const observer = new MutationObserver(updateLogo);
        observer.observe(body, { attributes: true, attributeFilter: ['class'] });

        sidebar.addEventListener('mouseenter', updateLogo);
        sidebar.addEventListener('mouseleave', updateLogo);
    });
</script>

