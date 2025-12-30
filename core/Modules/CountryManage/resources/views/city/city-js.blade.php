<script>
(function ($) {
    "use strict";

    $(document).on('shown.bs.modal', '#addModal', function () {

        $('#country').select2({
            dropdownParent: $('#addModal'),
            width: '100%'
        });

        $('#state').select2({
            dropdownParent: $('#addModal'),
            width: '100%'
        });

        $('#district').select2({
            dropdownParent: $('#addModal'),
            width: '100%'
        });
    });

    /* Country → State */
    $(document).on('change', '#country', function () {

        let country_id = $(this).val();

        $('#state').html('<option value="">Loading...</option>').trigger('change');
        $('#district').html('<option value="">Select District</option>').trigger('change');

        if (!country_id) return;

        $.get("{{ route('admin.get.state.by.country', '') }}/" + country_id, function (res) {

            let options = '<option value="">Select State</option>';

            $.each(res, function (i, state) {
                options += `<option value="${state.id}">${state.state}</option>`;
            });

            $('#state')
                .html(options)
                .trigger('change')
                .select2({
                    dropdownParent: $('#addModal'),
                    width: '100%'
                });
        });
    });

    /* State → District */
    $(document).on('change', '#state', function () {

        let state_id = $(this).val();

        $('#district').html('<option value="">Loading...</option>').trigger('change');

        if (!state_id) return;

        $.get("{{ route('admin.get.district.by.state', '') }}/" + state_id, function (res) {

            let options = '<option value="">Select District</option>';

            $.each(res, function (i, district) {
                options += `<option value="${district.id}">${district.district}</option>`;
            });

            $('#district')
                .html(options)
                .trigger('change')
                .select2({
                    dropdownParent: $('#addModal'),
                    width: '100%'
                });
        });
    });

})(jQuery);
</script>
