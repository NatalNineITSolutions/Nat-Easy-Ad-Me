@component('mail::message')
# Payout Processed

Hello,

We’ve successfully processed your payout.

**Total Amount:** ₹{{ number_format($totalAmount, 2) }}

Thanks for being with us!  
{{ config('app.name') }}
@endcomponent
