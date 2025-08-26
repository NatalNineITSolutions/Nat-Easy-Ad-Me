@php
    $branchType = 'branch';
@endphp

<div class="modal fade" id="branch_media_upload_modal" tabindex="-1" aria-labelledby="branchMediaUploadLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="branchMediaUploadLabel">{{ __('Media Uploads') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="branch_upload_media_image" data-bs-toggle="tab" href="#branch_upload_files"
                            role="tab" aria-selected="true">{{ __('Upload Files') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="branch_load_all_media_images" data-bs-toggle="tab" href="#branch_media_library"
                            role="tab" aria-selected="false" data-type="{{ $branchType }}">{{ __('Media Library') }}</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <!-- Upload Files Tab -->
                    <div class="tab-pane fade show active" id="branch_upload_files" role="tabpanel">
                        <form action="{{ route('branch.upload.media.file') }}" method="POST" id="branchPlaceholderForm" class="dropzone" enctype="multipart/form-data">
                            @csrf
                        </form>
                    </div>

                    <!-- Media Library Tab -->
                    <div class="tab-pane fade" id="branch_media_library" role="tabpanel">
                        <div class="all-uploaded-images">
                            <div class="main-content-area-wrap">
                                <div class="image-preloader-wrapper">
                                    <div class="lds-spinner">
                                        <div></div><div></div><div></div><div></div>
                                        <div></div><div></div><div></div><div></div>
                                        <div></div><div></div><div></div><div></div>
                                    </div>
                                </div>
                                <div class="image-list-wrapper">
                                    <ul class="media-uploader-image-list"></ul>
                                    <div id="branch_loadmorewrap">
                                        <button type="button" class="btn btn-outline-primary">{{ __('Load More') }}</button>
                                    </div>
                                </div>

                                <div class="media-uploader-image-info">
                                    <div class="img-wrapper">
                                        <img src="" alt="">
                                    </div>
                                    <div class="img-info">
                                        <h5 class="img-title"></h5>
                                        <ul class="img-meta" style="display: none;">
                                            <li class="date"></li>
                                            <li class="dimension"></li>
                                            <li class="size"></li>
                                            <li class="image_id" style="display:none;"></li>
                                            <li class="imgsrc"></li>
                                            <li class="imgalt">
                                                <div class="img-alt-wrap">
                                                    <input type="text" name="img_alt_tag" placeholder="{{ __('alt') }}">
                                                    <button class="btn btn-success img_alt_submit_btn"><i class="las la-check"></i></button>
                                                </div>
                                            </li>
                                        </ul>
                                        <a tabindex="0" style="display: none"
                                            class="btn btn-danger btn-sm mb-3 media_library_image_delete_btn"
                                            data-type="branch" role="button">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-primary media_upload_modal_submit_btn"
                        data-bs-dismiss="modal"
                        style="display: none;">
                    {{ __('Set Image') }}
                </button>
            </div>

        </div>
    </div>
</div>