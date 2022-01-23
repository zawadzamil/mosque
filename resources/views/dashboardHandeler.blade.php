<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Islamic Association</title>
    <link rel="stylesheet" href="{{asset('public/display/css/display.css')}}">
    <!--Tailwind CSS-->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Link-->
    <link href="https://www.dafontfree.net/embed/cm9kamEtcm9kamEmZGF0YS80OS9yLzM0NzE2L1JvZGphLnR0Zg" rel="stylesheet"
          type="text/css" />

    <!--Bangla Font-->
    <link href="https://fonts.maateen.me/mukti/font.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnFV_4JjaFZV8CugKwESQNr8DJ-mTpTbg"></script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.js"></script>




</head>

<body class="bg-gray-200">
<!--Clock-->
<div class="clock-section">
    <div class="clock text-center">
            <span id="time" class="  font-bold  ">

            </span>
        <span id = "dateBottom" ></span>
    </div>





</div>

<!--Clock End-->







<div class="min-h-screen  item-center text-center">
    <!--Toggle Switch-->
    <div class="sign"> <a href="{{route('login')}}">
            <button class='w-20 bg-gray-700 text-white p-2 mt-4 rounded-lg' style="position: relative"> Log In</button>

        </a>
        <a href="{{url('select-mosques')}}">
        <button class='w-40 bg-gray-700 text-white p-2 mt-4 rounded-lg' style="position: relative"> Show Mosques</button>
        </a>

        <button class='w-16 bg-yellow-800 text-white p-2 mt-4 rounded-lg ' id="fullScreen" style="position: relative">[ ]</button>
        <button class='w-16 bg-orange-800 text-white p-2 mt-4 rounded-lg ' id="exitFScreeen" style="position: relative">> <</button>


    </div>

    <!--End Toggle Switch-->
    <div class="flex-1 max-w-8xl ">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2  gap-1 grid-flow-row pb-4 ">
            <!--Table Section-->
            <div class="   rounded-lg ml-12 mt-2  ">
                <!--English Table-->
                <table class="table-auto  sm:w-full text-cente  " id="eng-table" style="text-align: center;">
                    <thead class="bg-gray-800 ">
                    <tr>
                        <th >Prayer</th>
                        <th>Start</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Fazar</td>
                        <td id="f-start">06:25 AM</td>

                    </tr>
                    <tr>
                        <td>Dhuhr</td>
                        <td id="d-start">01:00 PM</td>

                    </tr>
                    <tr>
                        <td>Asr</td>
                        <td id="a-start">03:30 PM</td>

                    </tr>
                    <tr>
                        <td>Maghrib</td>
                        <td id="m-start">05:15 PM</td>

                    </tr>
                    <tr>
                        <td>Isha</td>
                        <td id="i-start">06:20 PM</td>

                    </tr>
                    <tr>
                        <td>Jummah</td>
                        <td id="j-start">12:45 PM</td>

                    </tr>
                    </tbody>

                </table>
                <!--End English Table-->






            </div>
            <!--End Table Section-->

            <!--Image Slider -->
            <div class=" rounded-lg text-center px-10 ">
                <div class="imgbox ">

                    <img class="mySlides"  src="public/display/assets/images/m1.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m2.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m3.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m4.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m5.jpg">
                </div>

            </div>
            <!--End Image Slider -->

        </div>
        <!--Mosque Name Section-->
        <div class="  title-main text-center mb-2">
            <a href="">
                <p> <span class="shadow-xl text-4xl arabic  px-8 rounded-lg" id="name">Islamic Association of Saskatchewan</span>

                </p>
            </a>

        </div>
        <!--End Mosque Name Section-->


        <!--Text Slider Section-->
        <div class="grid  grid-cols-1 slider-text shadow-2xl rounded-lg grid-flow-row   " id="slider">

            <div class="scrolling">
                <h3 >Lorem ipsum dolor sit amet, consectetur </h3>

            </div>

        </div>
        <!--End Text Slider Section-->

    </div>
</div>





<script src="{{asset('public/display/js/display.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/af.min.js" integrity="sha512-xqLRtzampIqoDxDRyklcYk0fYDa7axgiSjTmyJFuzcK8vh1NDzqVPxcjIAvjb4t04u+rKMssANhgamUSnU71Uw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>

</html>
