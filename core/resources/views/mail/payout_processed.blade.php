@component('mail::message')
# Payout Processed

Hello {{ $user->first_name }},

Your payout of {{ number_format($payout->net_amount, 2) }} has been successfully processed.

**Payout Details:**  
- Date: {{ $payout->created_at->format('M d, Y') }}  
- Gross Amount: {{ number_format($payout->payout_amount, 2) }}  
- TDS Deduction: {{ number_format($payout->tds_deduction, 2) }}  
- Service Charge: {{ number_format($payout->service_charge, 2) }}  
- Net Amount: {{ number_format($payout->net_amount, 2) }}  

Thanks,  
{{ config('app.name') }}
@endcomponent