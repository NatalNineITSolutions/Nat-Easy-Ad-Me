<div class="modal fade" id="paymentGatewayModal" tabindex="-1" aria-labelledby="paymentGatewayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('matrimony.profilelisting.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Hidden fields for profile data -->
            <input type="hidden" name="name" id="modal_name">
            <input type="hidden" name="age" id="modal_age">
            <input type="hidden" name="occupation" id="modal_occupation">
            <input type="hidden" name="annual_income" id="modal_annual_income">
            <input type="hidden" name="caste" id="modal_caste">
            <input type="hidden" name="motherTongue" id="modal_motherTongue">
            <input type="hidden" name="country" id="modal_country">
            <input type="hidden" name="state" id="modal_state">
            <input type="hidden" name="city" id="modal_city">
            <input type="hidden" name="description" id="modal_description">
            
            <input type="hidden" name="images" id="modal_images">

            <!-- Optionally add image file handling if needed -->


            <div class="modal-content">
                <div class="modal-header">
                    @if(Auth::guard('web')->check())
                        <h4>{{ __('List Profile') }}</h4>
                    @else
                        <x-notice.general-notice :description="__('Notice: Please login to list a profile.')" />
                    @endif
                </div>
                <div class="modal-body">
                    <div class="confirm-payment payment-border">
                        <div class="single-checkbox">
                            <div class="checkbox-inlines">
                                <label class="checkbox-label load_after_login" for="choose">
                                    @if (Auth::check() && Auth::user()->user_wallet?->balance > 0)
                                        @if (moduleExists('Wallet'))
                                            {!! \App\Helpers\PaymentGatewayRenderHelper::renderWalletForm() !!}
                                        @endif
                                        <span class="wallet-balance mt-2 d-block">{{ __('Wallet Balance:') }}
                                            <strong class="main-balance">{{ float_amount_with_currency_symbol(Auth::user()->user_wallet?->balance) }}</strong></span>
                                        <br>
                                        <span class="display_balance"></span>
                                        <br>
                                        <span class="deposit_link"></span>
                                    @endif
                                    {!! \App\Helpers\PaymentGatewayRenderHelper::renderPaymentGatewayForForm() !!}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-wrapper">
                        <button type="button" class="red-global-close-btn" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        @if (Auth::guard('web')->check())
                            <button type="submit" class="red-global-btn buy_membership" id="confirm_buy_membership_load_spinner">
                                {{ __('List Now') }} <span id="buy_membership_load_spinner"></span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>

<x-payment.payment-gateway-js/>
