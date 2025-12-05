<script>
(function($){
    "use strict";

    $(function(){
        // Config
        const SEARCH_FORM = '#search_listings_form';
        const DEBOUNCE_MS = 600; // search debounce
        let searchDebounceTimer = null;
        let ajaxInProgress = false;

        // Helper: read common fields and write hidden inputs
        function setCommonFields() {
            const left_value = $('.input-min').val() || 0;
            const right_value = $('.input-max').val() || 0;
            $('#price_range_value').val(left_value + ',' + right_value);

            const distance_km_value = $('#slider-value').text() || 0;
            $('#distance_kilometers_value').val(distance_km_value);

            const get_autocomplete_value = $('#autocomplete').val() || '';
            $('#autocomplete_address').val(get_autocomplete_value);
        }

        // Show/hide loader
        function showLoader() {
            $('#loader').show();
            $('.customTab-content-1, .googleWraper, .custom-pagination').hide();
        }
        function hideLoader() {
            $('#loader').hide();
            $('.customTab-content-1, .googleWraper, .custom-pagination').show();
        }

        // Central submit handler (non-AJAX fallback)
        function submitFilters(useAjax = false) {
            setCommonFields();

            if (useAjax) {
                if (ajaxInProgress) return;
                ajaxInProgress = true;
                showLoader();

                // Example AJAX: replace with your endpoint and data handling
                $.ajax({
                    url: $(SEARCH_FORM).attr('action') || window.location.href,
                    method: $(SEARCH_FORM).attr('method') || 'GET',
                    data: $(SEARCH_FORM).serialize(),
                    success: function(htmlOrJson) {
                        // update results area:
                        // if server returns HTML:
                        // $('.customTab-content-1').html(htmlOrJson);
                        // if JSON, render accordingly.
                    },
                    error: function() {
                        // handle errors (optional)
                    },
                    complete: function(){
                        ajaxInProgress = false;
                        hideLoader();
                    }
                });

            } else {
                // Non-AJAX — just submit form normally
                showLoader();
                $(SEARCH_FORM).trigger('submit');
            }
        }

        // Delegate: change on selects & filters that are direct form inputs
        $(document).on('change', '#search_by_country, #search_by_state, #search_by_city, #search_by_category, #search_by_subcategory, #search_by_child_category, #search_by_rating, #search_by_sorting', function(e){
            e.preventDefault();
            submitFilters(false);
        });

        // Date posted buttons
        $(document).on('click', '#yesterday, #last_week, #today', function(e){
            e.preventDefault();
            const map = {
                '#yesterday': 'yesterday',
                '#last_week': 'last_week',
                '#today': 'today'
            };
            const val = map['#' + this.id] || '';
            $('#date_posted_listing').val(val);
            submitFilters(false);
        });

        // Listing view (grid/list)
        $(document).on('click', '#card_grid, #card_list', function(e){
            e.preventDefault();
            const view = (this.id === 'card_grid') ? 'grid' : 'list';
            $('#listing_grid_and_list_view').val(view);

            // Reset location-related filters if you really want to clear them:
            $('#distance_kilometers_value').val(0);
            $('#autocomplete_address').val('');
            $('#autocomplete').val('');
            $('#location_city_name').val('');
            $('#longitude').val(0);
            $('#latitude').val(0);

            // don't reset price_range_value here unless intentional
            // submit and show loader — optionally use AJAX
            submitFilters(true); // use AJAX so view switch is snappier
        });

        // Featured / top listing
        $(document).on('click', '#featured, #top_listing', function(e){
            e.preventDefault();
            const val = (this.id === 'featured') ? 'featured' : 'top_listing';
            $('#listing_type_preferences').val(val);
            submitFilters(false);
        });

        // Condition (new/used)
        $(document).on('click', '#new, #used', function(e){
            e.preventDefault();
            const val = (this.id === 'new') ? 'new' : 'used';
            $('#listing_condition').val(val);
            submitFilters(false);
        });

        // Search text with debounce
        $(document).on('keyup', '#search_by_query', function(e){
            e.preventDefault();
            const qVal = $(this).val().trim();

            // only trigger when length > 2
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(function(){
                if (qVal.length > 2) {
                    submitFilters(false);
                }
            }, DEBOUNCE_MS);
        });

        // Hide loader initially
        $('#loader').hide();

    });
})(jQuery);
</script>
