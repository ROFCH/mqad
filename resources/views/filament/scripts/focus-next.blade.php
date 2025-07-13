
<script>
    function setupValueInputFocus() {
        const inputs = Array.from(document.querySelectorAll('input[type="text"]'));
        inputs.forEach(input => {
            if (!input.classList.contains('value-input')) {
                input.classList.add('value-input');
            }
        });
    }

    // Initial Setup
    setupValueInputFocus();

    // Beobachte DOM-Änderungen (z. B. durch Livewire)
    const observer = new MutationObserver(() => {
        setupValueInputFocus();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });

    // Fokuswechsel bei Enter
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            const inputs = Array.from(document.querySelectorAll('input.value-input'));
            const currentIndex = inputs.indexOf(document.activeElement);
            if (currentIndex !== -1 && currentIndex < inputs.length - 1) {
                e.preventDefault();
                setTimeout(() => {
                    inputs[currentIndex + 1].focus();
                }, 100);
            }
        }
    });
</script>



