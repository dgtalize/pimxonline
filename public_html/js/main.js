$(document).ready(function () {
    $('.btn-delete').click(function () {
        return confirm('Are you sure you want to delete this element?');
    });

    $.fn.select2.defaults.set("theme", "bootstrap");
    $('.select2').select2();
});