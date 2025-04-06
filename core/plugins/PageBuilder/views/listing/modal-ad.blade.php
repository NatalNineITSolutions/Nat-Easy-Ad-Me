<div class="modal-ad-container" style="display: none;" data-show-frequency="{{ $show_every_visits }}"
    data-delay="{{ $delay }}">
    <div class="modal-ad-overlay" style="background: {{ $overlay_color }}"></div>
    <div class="modal-ad-content">
        <div class="modal-ad-timer">
            <span id="countdown-timer">5</span>
        </div>
        <span class="modal-ad-close" style="opacity: 0; visibility: hidden;">&times;</span>
        <div class="modal-ad-body">
            <x-listings.listing-single-list-view :listings="$random_ad" />
        </div>
    </div>
</div>

<style>
    /* Scoped modal styles */
    .modal-ad-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 99999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-ad-container .modal-ad-overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
    }

    .modal-ad-container .modal-ad-content {
        position: relative;
        background: white;
        border-radius: 15px;
        z-index: 100000;
        width: 90%;
        max-width: 600px;
        padding: 25px;
        margin: 20px;
        transform: scale(0.95);
        animation: modalEnter 0.3s ease-out forwards;
    }

    /* Scoped card styles only for modal */
    .modal-ad-container .singleFeatureCard {
        width: 100% !important;
        border: 1px solid transparent !important;
        border-radius: 10px !important;
        transition: all 0.3s !important;
        margin: 0 !important;
        box-shadow: none !important;
    }

    .modal-ad-container .modal-ad-timer {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 40px;
        height: 40px;
        background: #ff4757;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .modal-ad-container .modal-ad-close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #333;
        font-size: 28px;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 100001;
        opacity: 0;
        visibility: hidden;
    }

    .modal-ad-container .modal-ad-close.visible {
        opacity: 1 !important;
        visibility: visible !important;
    }

    .modal-ad-container .modal-ad-body {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    @keyframes modalEnter {
        from {
            transform: scale(0.95);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .modal-ad-container .modal-ad-content {
            width: 95%;
            padding: 15px;
        }

        .modal-ad-container .modal-ad-timer {
            top: -15px;
            right: -15px;
            width: 30px;
            height: 30px;
            font-size: 14px;
        }

        .modal-ad-container .modal-ad-close {
            top: 10px;
            right: 10px;
            font-size: 24px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.querySelector('.modal-ad-container');
        if (!modal) return;

        const showFrequency = parseInt(modal.dataset.showFrequency) || 1;
        const delay = parseInt(modal.dataset.delay) || 5000;

        // Visit tracking logic
        let visitCount = localStorage.getItem('modalVisitCount') || 0;
        visitCount = parseInt(visitCount) + 1;
        localStorage.setItem('modalVisitCount', visitCount);

        // Show logic
        const shouldShow = showFrequency === 0 ?
            visitCount === 1 :
            (visitCount - 1) % showFrequency === 0;

        if (!shouldShow) {
            modal.remove();
            return;
        }

        // Existing modal display logic
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Timer and close logic
        const closeBtn = modal.querySelector('.modal-ad-close');
        const timerElement = document.getElementById('countdown-timer');
        let timeLeft = delay / 1000;
        let canClose = false;

        const timerInterval = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerElement.parentElement.style.display = 'none';
                closeBtn.classList.add('visible');
                canClose = true;
            }
        }, 1000);

        // Close handlers
        const closeModal = () => {
            if (!canClose) return;
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        closeBtn.addEventListener('click', closeModal);
        modal.querySelector('.modal-ad-overlay').addEventListener('click', (e) => {
            if (canClose && e.target === modal.querySelector('.modal-ad-overlay')) {
                closeModal();
            }
        });
    });
</script>
