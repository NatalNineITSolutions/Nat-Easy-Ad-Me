$('.icp-dd').iconpicker();
$('.icp-dd').on('iconpickerSelected', function (e) {
var selectedIcon = e.iconpickerValue;
$(this).parent().parent().children('input').val(selectedIcon);
});
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/icon/icon-picker.blade.php ENDPATH**/ ?>