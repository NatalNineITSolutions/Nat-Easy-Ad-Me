<div class="modal fade" tabindex="-1" id="msg91_modal">
    <div class="modal-dialog">
        <div class="popup_contents modal-content">
            <div class="popup_contents__header">
                <div class="popup_contents__header__flex">
                    <div class="popup_contents__header__contents">
                        <h2 class="popup_contents__header__title">{{ __('MSG91') }}</h2>
                    </div>
                    <div class="popup_contents__header__close" data-bs-dismiss="modal">
                        <span class="popup_contents__close popup_close"> <i class="fas fa-times"></i> </span>
                    </div>
                </div>
            </div>

            <form action="{{route('admin.sms.gateway.update')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="sms_gateway_name" value="msg91">
                <div class="popup_contents__body">
                    <!--otp env settings -->
                    <h5 class="mb-4">{{ __('Configure MSG91 credentials') }}</h5>
                    <div class="form__input__single">
                        <label for="MSG91_AUTH_TOKEN"><strong>{{__('MSG91 Auth Key')}} <span class="text-danger">*</span></strong></label>
                        <input type="text"  class="form-control" name="msg91_auth_key" value=""
                               placeholder="{{ __('MSG91 Auth Key')}}">
                    </div>

                    <div class="form__input__single">
                        <label for="MSG91_OTP_TEMPLATE_ID"><strong>{{__('OTP Template ID')}} <span class="text-danger">*</span> </strong></label>
                        <input type="text" class="form-control" name="msg91_otp_template_id" value=""
                               placeholder="{{ __('OTP Template ID')}}">
                    </div>

                    <div class="form__input__single">
                        <label for="MSG91_NOTIFY_TEMPLATE_ID"><strong>{{__('Notify User Register Template ID')}} <span class="text-danger">*</span> </strong></label>
                        <input type="text" class="form-control" name="msg91_notify_user_register_template_id" value=""
                               placeholder="{{ __('Notify User Register Template ID')}}">
                    </div>

                    <div class="form__input__single">
                        <label for="disable_user_otp_verify"><strong>{{__('OTP Expire Time Add')}}</strong></label>
                        <select name="user_otp_expire_time" class="form-control">
                            <option  value="30">{{__('30 Second')}}</option>
                            @for($i=1; $i<=5; $i=$i+0.5)
                                <option value="{{$i}}">{{__($i . ($i > 1 ? ' Minutes' : ' Minute'))}}</option>
                            @endfor
                        </select>
                        <p class="form-text text-muted mt-2">{{__('User OTP verify Expire Time Add.')}}</p>
                    </div>

                    <button type="submit" id="update" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
