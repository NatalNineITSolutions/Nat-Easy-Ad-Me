<!-- Payment & Order Confirmation Modal -->
<div class="modal fade" id="orderPaymentModal" tabindex="-1" aria-labelledby="orderPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('user.order.store') }}" method="POST">
      @csrf

      {{-- --- AGGREGATE ORDER TOTALS --- --}}
      <input type="hidden" name="total_delivery_charge" id="modal_delivery_charge" value="0">
      <input type="hidden" name="grand_total"             id="modal_grand_total"     value="0">
      <input type="hidden" name="bv_points"        id="modal_bv_points"        value="0">

      {{-- --- USER & SHIPPING INFO --- --}}
      <input type="hidden" name="transaction_id" id="modal_transaction_id" value="">
      <input type="hidden" name="name"           id="modal_name"          value="">
      <input type="hidden" name="email"          id="modal_email"         value="">
      <input type="hidden" name="phone_number"   id="modal_phone"         value="">
      <input type="hidden" name="address"        id="modal_address"       value="">
      <input type="hidden" name="country_id"     id="modal_country_id"    value="">
      <input type="hidden" name="state_id"       id="modal_state_id"      value="">
      <input type="hidden" name="city_id"        id="modal_city_id"       value="">
      <input type="hidden" name="is_paid"        id="modal_is_paid"       value="0">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ __('Confirm Payment') }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="confirm-payment payment-border">
            <div class="single-checkbox">
              <div class="checkbox-inlines">
                <label class="checkbox-label">
                  {{-- Wallet option if available --}}
                  @if(Auth::check() && Auth::user()->user_wallet?->balance > 0)
                    {!! \App\Helpers\PaymentGatewayRenderHelper::renderWalletForm() !!}
                    <div class="wallet-balance mt-2">
                      {{ __('Wallet Balance:') }}
                      <strong class="main-balance">
                        {{ float_amount_with_currency_symbol(Auth::user()->user_wallet?->balance) }}
                      </strong>
                    </div>
                    <br>
                  @endif

                  {{-- Razorpay / other gateways --}}
                  {!! \App\Helpers\PaymentGatewayRenderHelper::renderPaymentGatewayForForm() !!}
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button 
           type="button" 
            id="razorpayPayBtn"
            class="btn btn-primary">
            {{ __('Pay & Order Now') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- required scripts --}}
<script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
<x-payment.payment-gateway-js />