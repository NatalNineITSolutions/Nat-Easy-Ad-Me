<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        // Function to handle closing
        function closeWebView() {
            // For React Native WebView
            if (window.ReactNativeWebView) {
                window.ReactNativeWebView.postMessage('CLOSE_WEBVIEW');
            } 
            // For regular browser (for testing)
            else {
                window.history.back(); // Better than window.close() which often doesn't work
            }
        }

        // Set timeout for auto-close
        setTimeout(closeWebView, 5000);

        // Listen for back button events (Android)
        document.addEventListener('backbutton', closeWebView, false);
    </script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md overflow-hidden text-center p-8">
            <div class="mb-6">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h1>
                <p class="text-gray-600">Your membership has been upgraded successfully.</p>
            </div>
        </div>
    </div>
</body>
</html>