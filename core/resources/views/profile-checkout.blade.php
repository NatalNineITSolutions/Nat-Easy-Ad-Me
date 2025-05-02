<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Complete Payment</h1>
                        <p class="text-blue-100">Secure payment powered by Razorpay</p>
                    </div>
                    <div class="bg-white p-2 rounded-full">
                        <img src="https://razorpay.com/assets/razorpay-logo.svg" alt="Razorpay" class="h-8">
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Order Summary</h2>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID</span>
                        <span class="font-medium" id="order-id">{{ request()->query('order_id') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount</span>
                        <span class="font-medium"
                            id="amount">₹{{ number_format(request()->query('amount'), 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Currency</span>
                        <span class="font-medium" id="currency">{{ strtoupper(request()->query('currency')) }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-gray-600 font-semibold">Total</span>
                        <span class="font-bold text-blue-600"
                            id="total">₹{{ number_format(request()->query('amount'), 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Button -->
            <div class="p-6">
                <button id="pay-button"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200 flex items-center justify-center">
                    <i class="fas fa-lock mr-2"></i> Pay Now Securely
                </button>

                <div class="mt-4 text-center text-sm text-gray-500">
                    <p>You'll be redirected to Razorpay's secure payment page</p>
                </div>

                <div class="mt-6 flex items-center justify-center space-x-4">
                    <img src="https://bsmedia.business-standard.com/_media/bs/img/article/2022-07/04/full/1656922506-9167.jpg?im=FeatureCrop,size=(826,465)" alt="Secure" class="h-8">
                    <img src="https://dnapayments.com/storage/app/media/PCI%20DSS/PCI-DSS-1.png" alt="PCI DSS Compliant" class="h-8">
                </div>
            </div>
        </div>

        <!-- Loading Indicator (hidden by default) -->
        <div id="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-gray-700 font-medium">Processing your payment...</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const order_id = urlParams.get('order_id');
            const amount = urlParams.get('amount');
            const currency = urlParams.get('currency');
            const key    = urlParams.get('key');   
            const profileListingId = urlParams.get('profile_listing_id');
            const userId = urlParams.get('user_id');
            
            const options = {
                key: key,
                amount: amount * 100,
                currency: currency,
                name: "Profile Listing",
                description: "List Profile",
                order_id: order_id,
                handler: function(response) {
                    // Handle successful payment
                    const params = new URLSearchParams({
                        payment_id: response.razorpay_payment_id,
                        order_id: order_id,
                        amount: amount,
                        user_id: userId,
                        signature: response.razorpay_signature,
                        profile_listing_id: profileListingId,
                    });
                    window.location.href = `/payment-profile-success?${params.toString()}`;
                    // window.location.href = `/payment-success?payment_id=${response.razorpay_payment_id}&order_id=${order_id}&amount=${amount}&membership_id=${membership_id}&user_id=${user_id}`;
                },
                prefill: {
                    name: "Johnson",
                    email: "johnson@example.com",
                    contact: "+919876543210"
                },
                theme: {
                    color: "#3399cc"
                },
                modal: {
                    ondismiss: function() {
                        // Handle when user closes the payment form
                        console.log('Payment window closed');
                    }
                }
            };

            const rzp = new Razorpay(options);

            document.getElementById('pay-button').addEventListener('click', function(e) {
                console.log('Payment button clicked');
                e.preventDefault();
                document.getElementById('loading').classList.remove('hidden');
                rzp.open();
            });

            // Close loading if payment window is closed without payment
            rzp.on('payment.failed', function(response) {
                document.getElementById('loading').classList.add('hidden');
                console.error(response.error.code);
                console.error(response.error.description);
                console.error(response.error.source);
                console.error(response.error.step);
                console.error(response.error.reason);
                console.error(response.error.metadata.order_id);
                console.error(response.error.metadata.payment_id);

                // Redirect or show error message
                alert('Payment failed: ' + response.error.description);
            });
        });
    </script>
</body>

</html>
