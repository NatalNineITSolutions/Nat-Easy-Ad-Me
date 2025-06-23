<div class="modal fade" id="orderPaymentModal" tabindex="-1" aria-labelledby="orderPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('user.order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hidden fields -->
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="product_quantity" value="{{ $quantity }}">
            <input type="hidden" name="product_total_price" value="{{ $finalTotal }}">
            <input type="hidden" name="total_delivery_charge" id="modal_delivery_charge" value="0">
            <input type="hidden" name="grand_total" id="modal_grand_total" value="0">
            <input type="hidden" name="transaction_id" id="modal_transaction_id">

            <!-- Shipping info -->
            <input type="hidden" name="name" id="modal_name">
            <input type="hidden" name="email" id="modal_email">
            <input type="hidden" name="phone_number" id="modal_phone">
            <input type="hidden" name="address" id="modal_address">
            <input type="hidden" name="country_id" id="modal_country_id">
            <input type="hidden" name="state_id" id="modal_state_id">
            <input type="hidden" name="city_id" id="modal_city_id">
            <input type="hidden" name="is_paid" id="modal_is_paid" value="0">

            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ __('Confirm Payment') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="confirm-payment payment-border">
                        <div class="single-checkbox">
                            <div class="checkbox-inlines">
                                <label class="checkbox-label">
                                    {{-- Wallet or Gateway --}}
                                    @if(Auth::check() && Auth::user()->user_wallet?->balance > 0)
                                        {!! \App\Helpers\PaymentGatewayRenderHelper::renderWalletForm() !!}
                                        <span class="wallet-balance mt-2 d-block">{{ __('Wallet Balance:') }}
                                            <strong class="main-balance">
                                                {{ float_amount_with_currency_symbol(Auth::user()->user_wallet?->balance) }}
                                            </strong>
                                        </span>
                                        <br>
                                    @endif

                                    {!! \App\Helpers\PaymentGatewayRenderHelper::renderPaymentGatewayForForm() !!}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Pay & Order Now') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
<x-payment.payment-gateway-js />