<div class="business-hour enquiry-hour box-shadow1 mt-4">
    <h3 class="head5 enquiry-head d-flex">{{ __('Enquiry Form') }}</h3>
    <div class="enquiry-wraper">
        <div class="enquiry_form_submit"></div>
        <form id="enquiryForm" action="{{ route('visitor.enquiry.form.submit') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="listing_id" value="{{ $listing->id }}">
            <input type="hidden" name="user_id" value="{{ $listing->user_id }}">

            <!-- Other fields -->
            <div class="input-wraper mt-3">
                <label for="name">{{ __('Name') }}</label>
                <input class="form-control" type="text" name="name" id="name" placeholder="{{ __('Name') }}" required>
            </div>
            <div class="input-wraper mt-3">
                <label for="email">{{ __('Email') }}</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="{{ __('Email') }}"
                    required>
            </div>
            <div class="input-wraper mt-3">
                <label for="phone">{{ __('Phone') }}</label>
                <input class="form-control" type="number" name="phone" id="phone" placeholder="{{ __('Phone') }}"
                    required>
            </div>
            <div class="input-wraper mt-3">
                <label for="message">{{ __('Message') }}</label>
                <textarea class="form-control" name="message" id="message" placeholder="{{ __('Message') }}"
                    required></textarea>
            </div>

            @if($listing->category_id == 54 && $listing->sub_category_id != 107)
                <div class="input-wraper mt-3">
                    <label for="resume">{{ __('Upload Resume (PDF only)') }}</label>
                    <input class="form-control" type="file" name="resume" id="resume" accept=".pdf" required>
                </div>
            @endif

            <button type="submit" class="red-btn mt-3">{{ __('Submit Enquiry') }}</button>
        </form>
    </div>
</div>
</div>

<!-- Add a div to display the response message -->
<div id="responseMessage" class="mt-3"></div>

<script>
    document.getElementById('enquiryForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                // Display the response message
                const responseMessage = document.getElementById('responseMessage');
                if (data.status === 'add_success') {
                    responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    responseMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>