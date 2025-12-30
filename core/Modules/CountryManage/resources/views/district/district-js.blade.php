<script>
(function ($) {
    "use strict";

    /* ==============================
       ADD MODAL (Add District / City)
    ============================== */

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

        $('#city').select2({
            dropdownParent: $('#addModal'),
            width: '100%'
        });
    });

    /* Country → State */
    $(document).on('change', '#country', function () {
        let country_id = $(this).val();

        $('#state').html('<option value="">Loading...</option>');
        $('#district').html('<option value="">Select District</option>');
        $('#city').html('<option value="">Select City</option>');

        if (country_id) {
            $.get("{{ route('admin.get.state.by.country', '') }}/" + country_id, function (res) {
                let options = '<option value="">Select State</option>';
                $.each(res, function (i, state) {
                    options += `<option value="${state.id}">${state.state}</option>`;
                });
                $('#state').html(options).trigger('change.select2');
            });
        }
    });

    /* State → District */
    $(document).on('change', '#state', function () {
        let state_id = $(this).val();

        $('#district').html('<option value="">Loading...</option>');
        $('#city').html('<option value="">Select City</option>');

        if (state_id) {
            $.get("{{ route('admin.get.district.by.state', '') }}/" + state_id, function (res) {
                let options = '<option value="">Select District</option>';
                $.each(res, function (i, district) {
                    options += `<option value="${district.id}">${district.district}</option>`;
                });
                $('#district').html(options).trigger('change.select2');
            });
        }
    });

    /* District → City */
    $(document).on('change', '#district', function () {
        let district_id = $(this).val();

        $('#city').html('<option value="">Loading...</option>');

        if (district_id) {
            $.get("{{ route('admin.get.city.by.district', '') }}/" + district_id, function (res) {
                let options = '<option value="">Select City</option>';
                $.each(res, function (i, city) {
                    options += `<option value="${city.id}">${city.city}</option>`;
                });
                $('#city').html(options).trigger('change.select2');
            });
        }
    });

    /* ==============================
       EDIT MODAL (Prefill Correctly)
    ============================== */

    $(document).on('click', '.edit_city_modal, .edit_district_modal', function () {

        let country_id  = $(this).data('country_id') || $(this).data('country');
        let state_id    = $(this).data('state_id') || $(this).data('state');
        let district_id = $(this).data('district_id');
        let city_id     = $(this).data('city_id');

        setTimeout(function () {

            $('#edit_country').select2({
                dropdownParent: $('#editCityModal, #editDistrictModal'),
                width: '100%'
            }).val(country_id).trigger('change.select2');

            /* load states */
            $.get("{{ route('admin.get.state.by.country', '') }}/" + country_id, function (res) {
                let options = '<option value="">Select State</option>';
                $.each(res, function (i, state) {
                    options += `<option value="${state.id}">${state.state}</option>`;
                });
                $('#edit_state').html(options).val(state_id).trigger('change.select2');

                /* load districts */
                $.get("{{ route('admin.get.district.by.state', '') }}/" + state_id, function (res2) {
                    let options2 = '<option value="">Select District</option>';
                    $.each(res2, function (i, district) {
                        options2 += `<option value="${district.id}">${district.district}</option>`;
                    });
                    $('#edit_district').html(options2).val(district_id).trigger('change.select2');

                    /* load cities */
                    if (city_id) {
                        $.get("{{ route('admin.get.city.by.district', '') }}/" + district_id, function (res3) {
                            let options3 = '<option value="">Select City</option>';
                            $.each(res3, function (i, city) {
                                options3 += `<option value="${city.id}">${city.city}</option>`;
                            });
                            $('#edit_city').html(options3).val(city_id).trigger('change.select2');
                        });
                    }
                });
            });

        }, 200);
    });

})(jQuery);
</script>
