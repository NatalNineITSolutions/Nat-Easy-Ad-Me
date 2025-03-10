<div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Edit Type') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.membership.type.edit')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type_id" id="type_id" value="">
                <div class="modal-body">
                    <x-form.text :title="__('Type')" :type="__('text')" :name="'type'" :id="'edit_type'" :value="''" :placeholder="__('Enter membership type')"/>
                    <x-form.number :title="__('Validity')" :min="7" :max="365" :name="'validity'" :id="'edit_validity'" :divClass="'mb-0'" :value="''" :placeholder="__('Enter validity')"/>
                    <p class="text-info">{{__('Validity must be a number between 7 to 365 days')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mt-4" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <div class="btn_wrapper mt-4">
                        <button type="submit" id="update" class="cmnBtn btn_5 btn_bg_blue radius-5 edit_type">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
