@extends('matrimony.layouts.app')

@section('title', 'Matrimony Home')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

@section('style')

    <style>
        .hibiscus {
            width: 90px;
            margin-bottom: 15px;
        }

        .banner-heading {
            font-family: "Prociono", serif;
            font-size: 60px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .banner-desp {
            font-size: 17px;
            font-weight: 400;
        }

        .banner {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 20px;
            overflow: hidden; /* Prevents horizontal scroll */
        }

        .banner-bg {
            background: url('/assets/img/ban-bg.jpg') no-repeat center center/cover;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            /* Zoom-in Animation */
            animation: zoomIn 3s ease-in infinite alternate;
        }

        @keyframes zoomIn {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.1); /* Slight zoom-in effect */
            }
        }

        .banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay for better text visibility */
            z-index: 1;
        }

        .banner-content {
            width: 100%;
            position: relative;
            z-index: 2; /* Ensures content stays above background */
        }

        .search-container {
            background: rgba(0, 0, 0, 0.58);
            border-radius: 8px;
            padding: 15px;
            display: flex;
            gap: 10px;
            max-width: 1000px;
            margin: 20px auto;
        }

        .search-container select,
        .search-container button {
            width: 100%;
        }

        /* Tablet Design - 2 Column Layout */
        @media (max-width: 992px) {
            .banner-heading {
                font-size: 40px;
            }

            .banner-desp {
                font-size: 14px;
            }

            .search-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px; /* Space between elements */
                justify-content: space-between;
            }

            /* Default: 2 items per row for tablets */
            .search-container select, 
            .search-container button {
                flex: 1 1 calc(50% - 10px); /* 50% width for 2 items per row */
                padding: 8px;
                font-size: 14px;
            }
        }

        /* Mobile Design - Full Stack Layout */
        @media (max-width: 576px) {
            .banner-heading {
                font-size: 32px;
            }

            .banner-desp {
                font-size: 14px;
            }

            .hibiscus {
                width: 60px;
                margin-bottom: 10px;
            }

            .search-container {
                display: flex;
                flex-direction: column;
            }
        }

        /* Product slider */
        .card-slider {
            max-width: 960px;
            margin: 0 auto;
            
            @media screen and (max-width: 1024px) {
                width: 80%;
        }
            
            .slick-prev-icon,
            .slick-next-icon {
                color: black;
            }
            
            .slick-slide {
                padding: 0 10px;
            }
            
            .card {
                position: relative;
                display: flex !important;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 15px;
                border-radius: 3px;
                border: 1px solid rgba(0,0,0,.2);
                background-color: white;
                text-decoration: none;
                color: rgba(0,0,0,.9);
                transition: all .1s linear;
                @media screen and (max-width: 600px) {
                height: auto;
                }
            }

               .card h2 {
                font-size: 15px;
                font-weight: 600;
                text-align: center;
                margin-top: 15px;
                margin-bottom: 15px;
               }

               .card p {
                font-size: 12px;
                font-weight: 600;
               }

                /** Product title */
                .card .title {
                color: #000;
                margin: 0;
                padding: 10px 10px 5px 10px;
                font-size: 16px;
                font-weight: bold;
                }

                .card .title:hover {
                    text-decoration: underline;
                }

                /** Product image */
                .card .image {
                /** Visually place the image above all other content (like the heading) in the parent flex container (.card). */
                order: -1;

                position: relative;
                height: 100px;
                padding: 2px;
                overflow: hidden;

                display: flex;
                justify-content: center;
                align-items: center;
                }

                .card .image img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    filter: grayscale(.5);
                    transition: all .3s ease-in-out;
                }

                    .card .image:hover img {
                    width: 110%;
                    height: 110%;
                    }

                /** Product description */
                .card .description {
                margin: 7px 10px 15px 10px;
                font-size: 14px;
                opacity: .8;
                }

                /** Floating "sale" badge */
                .card .badge {
                position: absolute;
                top: 2px;
                right: 2px;
                z-index: 1;

                padding: 5px 10px;

                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
                color: white;
                background-color: rgb(200,0,0);
                }

                /** Price */
                .card .price {
                padding-left: 10px;
                }

                .card .price .new-price {
                    font-weight: bold;
                }

                .card .price .original-price {
                    margin-left: 5px;
                    font-size: 14px;
                    font-style: italic;
                    opacity: .5;
                    text-decoration: line-through;
                }

                /** Rating */
                .card .rating {
                margin: 10px 0 15px 10px;
                color: orange;
                font-size: 12px;
                }

                /** "30 reviews" link next to stars */
                .card .rating .reviews-link {
                    color: rgba(0,0,0,.6);
                    margin-left: 5px;
                }

                    .card .rating .reviews-link:hover {
                    color: black;
                    }

                    .card .rating .reviews-link:focus {
                    color: royalblue;
                    outline: 3px dotted royalblue;
                    outline-offset: 2px;
                    }

                /** Hover state = add box shadow, underline the title */
                .card:hover {
                border-color: rgba(0,0,0,.4);
                box-shadow: 0 0 10px 0 rgba(0,0,0,.15);
                }

                .card:hover .image img,
                .card:focus .image img {
                    filter: grayscale(0);
                }

                .card a:focus {
                    outline: none;
                }
            }

            .slick-next,
            .slick-prev {
                background-color: black;
            }

            .slick-next:hover,
            .slick-prev:hover {
                background-color: black;
            } 

            .profile-container {
                margin-top: 30px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .card-slider {
                margin-top: 20px;
            }

            .trusted-profiles {
                text-align: center;
            }

            .trusted-profiles h2 {
                font-size: 18px;
                color: #C48C46;
                margin-bottom: 10px;
            }

            .trusted-profiles p {
                font-size: 18px;
                font-weight: 600;
                color: #66451C;
            }

            .slick-slide {
                margin: 0 5px;
            } 

            .btn-profile {
                padding: 10px 15px;
                background-color: #FF166C;
                border: none;
                font-size: 13px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1.2px;
                color: white;
                text-decoration: none;
            }

            /* Perfect match */
            .perfect-match-banner {
                margin-top: 30px;
                margin-bottom: 30px;
                background-color: #ffeebf;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 40px 20px;
                border-radius: 12px;
                text-align: center;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

        .perfect-match-banner h1 {
            font-family: "Prociono", serif;
            color: #4a382f;
            font-size: 28px;
            font-weight:600;
            margin-bottom: 10px;
        }

        .perfect-match-banner p {
            color: #4a382f;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .register-now {
            padding: 10px 20px;
            background-color: black;
            color: #fff;
            border: none;
            outline: none;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
        }

        .support {
            padding: 10px 20px;
            border: 1px solid #000;
            background: transparent;
            outline: none;
            color: #000;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .illustration-container {
            overflow: hidden;     /* Ensures the image stays inside the box */
            position: relative;   /* Needed for proper positioning */
            width: 100%;          /* Container width */
            height: auto;         /* Auto height */
        }

        .illustration {
            width: 150%;          /* Reduce image width for better fit */
            animation: scrollAnimation 15s linear infinite;
        }

        @keyframes scrollAnimation {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%); /* Moves half of the extended width */
            }
        }

        @media (max-width: 600px) {
            .perfect-match-banner h1 {
                font-size: 22px;
            }

            .perfect-match-banner p {
                font-size: 14px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <div class="banner">
        <div class="banner-bg"></div> <!-- Background for Zoom Effect -->
        <div class="banner-content">
            <img class="hibiscus" src="/assets/img/hibiscus.png" alt="Hibiscus">
            <h2 class="banner-heading">Find your <br> <span class="highlight">Right Match</span> here</h2>
            <p class="banner-desp">Forever Starts Here: Your Love, Your Journey, Your Wedding Wonderland!</p>

            <div class="search-container">
                <select class="form-select">
                    <option selected>I'm looking for</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>

                <select class="form-select">
                    <option selected>Age</option>
                    <option>18-25</option>
                    <option>26-35</option>
                    <option>36-45</option>
                </select>

                <select class="form-select">
                    <option selected>Religion</option>
                    <option>Hindu</option>
                    <option>Christian</option>
                    <option>Muslim</option>
                </select>

                <select class="form-select">
                    <option selected>Location</option>
                    <option>Chennai</option>
                    <option>Bangalore</option>
                    <option>Hyderabad</option>
                </select>

                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>   

    <div class="container profile-container">
        <div class="trusted-profiles">
            <h2>TRUSTED PROFILES</h2>
            <p>More than 1500+ Trusted Profiles</p>
        </div>
        <div class="card-slider">
            <div class="card">
                <img src="profile.jpg" alt="Profile Image">
                <h2>Nikitha</h2>
                <p>📅 20 Years &nbsp; 🏋️‍♀️ 5ft, 2in</p>
                <p>📍 Chennai &nbsp; 🎓 UG</p>
                <a href="#" class="btn-profile">View Profile</a>
            </div>
            <div class="card">
                <img src="profile.jpg" alt="Profile Image">
                <h2>Nikitha</h2>
                <p>📅 20 Years &nbsp; 🏋️‍♀️ 5ft, 2in</p>
                <p>📍 Chennai &nbsp; 🎓 UG</p>
                <a href="#" class="btn-profile">View Profile</a>
            </div>
            <div class="card">
                <img src="profile.jpg" alt="Profile Image">
                <h2>Nikitha</h2>
                <p>📅 20 Years &nbsp; 🏋️‍♀️ 5ft, 2in</p>
                <p>📍 Chennai &nbsp; 🎓 UG</p>
                <a href="#" class="btn-profile">View Profile</a>
            </div>
            <div class="card">
                <img src="profile.jpg" alt="Profile Image">
                <h2>Nikitha</h2>
                <p>📅 20 Years &nbsp; 🏋️‍♀️ 5ft, 2in</p>
                <p>📍 Chennai &nbsp; 🎓 UG</p>
                <a href="#" class="btn-profile">View Profile</a>
            </div>
            <div class="card">
                <img src="profile.jpg" alt="Profile Image">
                <h2>Nikitha</h2>
                <p>📅 20 Years &nbsp; 🏋️‍♀️ 5ft, 2in</p>
                <p>📍 Chennai &nbsp; 🎓 UG</p>
                <a href="#" class="btn-profile">View Profile</a>
            </div>
            <div class="card">
                <img src="profile.jpg" alt="Profile Image">
                <h2>Nikitha</h2>
                <p>📅 20 Years &nbsp; 🏋️‍♀️ 5ft, 2in</p>
                <p>📍 Chennai &nbsp; 🎓 UG</p>
                <a href="#" class="btn-profile">View Profile</a>
            </div>
            <div class="card">
                <img src="profile.jpg" alt="Profile Image">
                <h2>Nikitha</h2>
                <p>📅 20 Years &nbsp; 🏋️‍♀️ 5ft, 2in</p>
                <p>📍 Chennai &nbsp; 🎓 UG</p>
                <a href="#" class="btn-profile">View Profile</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="perfect-match-banner">
            <h1>Find your perfect Match now</h1>
            <p>Discover your soulmate and build a beautiful future together. Start your journey today and find your perfect match with us!</p>
            <div class="buttons">
                <a href="/matrimony/register" class="register-link">
                    <button class="register-now">REGISTER NOW</button>
                </a>
                <button class="support">HELP & SUPPORT</button>
            </div>
        </div>
    </div>
      
@endsection

@section('script')
    

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.card-slider').slick({
                dots: false,
                arrows: true,
                slidesToShow: 4,
                infinite: false,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>

    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.pushState(null, null, location.href);
        };
    </script>
@endsection