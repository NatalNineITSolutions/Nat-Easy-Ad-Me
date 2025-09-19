@php
    $type = 'branch';
    $trash_icon = 'las la-trash';
    $check_icon = 'las la-check';
    $spinner_icon = 'fa-spin las la-spinner';
@endphp

<input type="hidden" id="mediaType" value="{{ $type }}">
<script>
    // ensure Dropzone doesn't auto initialize any .dropzone elements
    if (typeof Dropzone !== 'undefined') {
        Dropzone.autoDiscover = false;
    }
</script>

<script>
    (function($) {
        "use strict";

        var mainUploadBtn = '';
        // keep a reference to the Dropzone instance so we don't create it twice
        window.branchDropzone = window.branchDropzone || null;

        // Utility: ensure modal is hidden on page load (just in case)
        $(function() {
            var branchModal = $('#branch_media_upload_modal');
            if (branchModal.length) {
                branchModal.removeClass('show').css('display', 'none').attr('aria-hidden', 'true');
                $('.modal-backdrop').remove(); // remove any stray backdrops
            }
        });

        // Initialize Dropzone ONCE
        function initBranchDropzone() {
            // if library missing, skip
            if (typeof Dropzone === 'undefined') return;

            var dzElement = document.getElementById('branchPlaceholderForm');
            if (!dzElement) return;

            // If an instance already exists, don't create another
            if (dzElement.dropzone || window.branchDropzone) {
                // instance already created
                return;
            }

            // Create instance and store it
            window.branchDropzone = new Dropzone(dzElement, {
                url: "{{ route('branch.upload.media.file') }}",
                paramName: "file",
                maxFilesize: 10,
                maxFiles: 50,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "{{ __('Drag or Select Your Image') }}",
                init: function() {
                    var dz = this;

                    dz.on("success", function(file, response) {
                        // reload media library after successful upload
                        $('#branch_load_all_media_images').trigger('click');
                        // mark first item selected once library loaded
                        // (the loadAllImages success will re-select).
                    });

                    dz.on("error", function(file, errorMessage) {
                        // You can improve error handling here if needed
                        console.warn('Dropzone upload error:', errorMessage);
                    });

                    dz.on("removedfile", function(file) {
                        // optional: handle remove action if you delete files client-side
                    });
                }
            });
        }

        // Initialize dropzone immediately (safe, creates once)
        $(document).ready(function() {
            initBranchDropzone();
        });

        // --- Media selection / delete / load logic (uses branch_* ids) ---

        // After selecting image (Set Image button)
        $(document).on('click', '.media_upload_modal_submit_btn', function(e) {
            e.preventDefault();
            var allData = $('.media-uploader-image-list li.selected');
            if (allData.length) {
                mainUploadBtn.parent().find('.img-wrap').html('');
                var imageId = '';
                $.each(allData, function(index, value) {
                    var el = $(this).data();
                    var separator = (index === allData.length - 1) ? '' : '|';
                    imageId += el.imgid + separator;
                    mainUploadBtn.prev('input').attr('data-imgsrc', el.imgsrc);
                    mainUploadBtn.parent().find('.img-wrap').append(
                        '<div class="img-inner-wrap"><div class="rmv-span" data-imageid="' + el.imgid +
                        '"><i class="{{ $trash_icon }}"></i></div><div class="attachment-preview"><div class="thumbnail"><div class="centered"><img src="' +
                        el.imgsrc + '"></div></div></div></div>');
                });
                mainUploadBtn.prev('input').val(imageId);
            }
            // hide branch modal
            $('#branch_media_upload_modal').modal('hide');
            mainUploadBtn.text('Change Image');
            mainUploadBtn.attr('data-image-ids', imageId);
        });

        // Delete image
        $(document).on('click', '.media_library_image_delete_btn', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __("Are you sure to delete this image") }}',
                text: '{{ __("This image will remove permanently") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("Yes, Delete It") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteImage();
                }
            });
        });

        function deleteImage() {
            $.ajax({
                type: "POST",
                url: "{{ route('branch.upload.media.file.delete') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    img_id: $('.image_id').text(),
                    type: 'branch'
                },
                success: function() {
                    $('.media-uploader-image-info a,.media-uploader-image-info .img-meta').hide();
                    $('.media-uploader-image-list li.selected').remove();
                    $('.media-uploader-image-info .img-wrapper img').attr('src', '');
                    $('.media-uploader-image-info .img-info .img-title').text('');
                }
            });
        }

        // Media form button click -> open modal and load images if needed
        $(document).on('click', '.media_upload_form_btn', function(e) {
            e.preventDefault();
            var parent = $('#branch_media_upload_modal');
            var loadAllImage = $('#branch_load_all_media_images');
            var el = $(this);
            var imageId = el.prev('input').val();
            mainUploadBtn = el;

            // set modal title and button text
            parent.find('.media_upload_modal_submit_btn').text(el.data('btntitle') || '{{ __("Set Image") }}');
            parent.find('.media_upload_modal_submit_btn').attr('data-inputname', el.prev('input').attr('name'));
            parent.find('.modal-title').text(el.data('modaltitle') || '{{ __("Upload Image") }}');

            if (el.data('mulitple')) {
                parent.attr('data-mulitple', 'true');
            } else {
                parent.removeAttr('data-mulitple');
            }

            // ensure Dropzone is initialized (safe; init will only run once)
            initBranchDropzone();

            // open bootstrap modal
            parent.modal('show');

            // load media library and pre-select previously selected images
            loadAllImage.attr('data-selectedimage', '');
            if (imageId && imageId.length) {
                loadAllImage.attr('data-selectedimage', imageId);
            }
            // trigger click so loadAllImages fires
            loadAllImage.trigger('click');
        });

        // Selecting an image in library
        $('body').on('click', '.media-uploader-image-list > li', function(e) {
            e.preventDefault();
            var el = $(this);
            var allData = el.data();

            if (typeof $('#branch_media_upload_modal').attr('data-mulitple') === 'undefined') {
                el.toggleClass('selected').siblings().removeClass('selected');
            } else {
                el.toggleClass('selected');
            }

            $('.media-uploader-image-info a,.media-uploader-image-info .img-meta,.delete_image_form').show();

            var parent = $('.img-meta');
            parent.children('.date').text(allData.date || '');
            parent.children('.dimension').text(allData.dimension || '');
            parent.children('.size').text(allData.size || '');
            parent.children('.imgsrc').text(allData.imgsrc || '');
            parent.children('.image_id').text(allData.imgid || '');
            parent.find('input[name="img_alt_tag"]').val(allData.alt || '');
            parent.parent().find('input[name="img_id"]').val(allData.imgid || '');

            $('.img_alt_submit_btn').html('<i class="{{ $check_icon }}"></i>');
            $('.img-info .img-title').text(allData.title || '');
            $('.media-uploader-image-info .img-wrapper img').attr('src', allData.imgsrc || '');
        });

        // Dropzone options removed — we initialize programmatically via initBranchDropzone()

        // Load all images (AJAX)
        $(document).on('click', '#branch_load_all_media_images', function(e) {
            e.preventDefault();
            loadAllImages();
        });

        function loadAllImages() {
            const selectedImage = $('#branch_load_all_media_images').data('selectedimage') || '';
            $.ajax({
                type: "POST",
                url: "{{ route('branch.upload.media.file.all') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    selected: selectedImage
                },
                success: function(data) {
                    $('.media-uploader-image-list').html('');
                    $.each(data, function(index, value) {
                        if ($('.media-uploader-image-list li[data-imgid="' + value.image_id + '"]').length < 1) {
                            $('.media-uploader-image-list').append(
                                '<li data-date="' + value.upload_at + '" data-imgid="' + value.image_id + '" data-imgsrc="' + value.img_url + '" data-size="' + value.size + '" data-dimension="' + value.dimensions + '" data-title="' + value.title + '" data-alt="' + value.alt + '">' +
                                '<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img src="' + value.img_url + '" alt=""></div></div></div>' +
                                '</li>'
                            );
                        }
                    });
                    $('.media_upload_modal_submit_btn').show();
                    selectOldImage();
                    $('#branch_loadmorewrap button').show();
                }
            });
        }

        // re-select previously selected images
        function selectOldImage() {
            if (!mainUploadBtn || !mainUploadBtn.length) return;
            var imageId = mainUploadBtn.prev('input').val();
            if (!imageId) return;
            var imgArr = imageId.split('|').filter(el => el != "");
            $.each(imgArr, function(index, value) {
                $('.media-uploader-image-list li[data-imgid="' + value + '"]').trigger('click');
            });
        }

        // Load more handler
        $(document).on('click', '#branch_loadmorewrap', function() {
            var mediaImageWrapper = $('#branch_media_library');
            var skip = mediaImageWrapper.find('ul.media-uploader-image-list li').length - 1;
            $('#branch_loadmorewrap button').append(' <i class="{{ $spinner_icon }}"></i>');
            $.ajax({
                type: "POST",
                url: "{{ route('branch.upload.media.file.loadmore') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    skip: skip
                },
                success: function(data) {
                    $.each(data, function(index, value) {
                        if ($('.media-uploader-image-list li[data-imgid="' + value.image_id + '"]').length < 1) {
                            mediaImageWrapper.find('.media-uploader-image-list').append(
                                '<li data-date="' + value.upload_at + '" data-imgid="' + value.image_id + '" data-imgsrc="' + value.img_url + '" data-size="' + value.size + '" data-dimension="' + value.dimensions + '" data-title="' + value.title + '" data-alt="' + value.alt + '">' +
                                '<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img src="' + value.img_url + '" alt=""></div></div></div>' +
                                '</li>'
                            );
                        }
                    });
                    if (!data.length) {
                        $('#branch_loadmorewrap button').hide();
                    }
                    $('#branch_loadmorewrap button i').remove();
                }
            });
        });

    })(jQuery);
</script>
