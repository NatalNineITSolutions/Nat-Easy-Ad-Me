<style>
    /* Gradient Background */
    .pricing-section {
            background: linear-gradient(to right, #6d0f7b, #e44042); /* Adjusted Gradient Colors */
            color: white;
            text-align: center;
            padding: 80px 20px;
            position: relative;
        }

        /* Small Decorative Circles */
        .pricing-section::before, .pricing-section::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .pricing-section::before {
            top: 20px;
            left: 30px;
        }

        .pricing-section::after {
            bottom: 30px;
            right: 40px;
        }

        /* Heading Styles */
        .pricing-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .pricing-section h3 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .pricing-section p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 10px auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .pricing-section h2 {
                font-size: 2rem;
            }
            .pricing-section h3 {
                font-size: 1.5rem;
            }
        }
</style>

<section class="pricing-section">
    <h3>PROFILE VERIFICATION</h3>
<h2>Get Verified</h2>
<h3>Choose Your Verification Plan</h3>
<p>
    Verify your profile to gain trust and visibility. A verified profile increases your chances of connecting with others</p>
</section>