document.querySelectorAll('[data-confirm]').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        if (!confirm(this.dataset.confirm)) e.preventDefault();
    });
});
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(function(el) {
        var instance = bootstrap.Alert.getOrCreateInstance(el);
        if (instance) instance.close();
    });
}, 4000);