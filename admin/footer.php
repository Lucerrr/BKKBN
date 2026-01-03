        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        // Dark Mode Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = themeToggleBtn.querySelector('i');
        
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            if (theme === 'dark') {
                themeIcon.classList.remove('bi-moon-stars');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-stars');
            }
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        }

        // Initialize Theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);
    </script>
</body>
</html>