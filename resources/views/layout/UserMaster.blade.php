<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('user.css') }}">
    <link rel="stylesheet" href="{{ asset('css1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css1/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css1/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css1/bootstrap.min.css.map') }}">

    <script src="https://code.jquery.com/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
    <script src="https://kit.fontawesome.com/f304de03af.js" crossorigin="anonymous"></script>
    <title>@yield('Title', 'Social_Media')</title>
</head>
<body style="background-color: #1d1c1c">
    
    @include('layout/header')
    <div class="container">
       <?php if(!isset($Nosidebar)){ ?>
    
            <div class="row">
                <div class="col-md-12">

</div>
</div>


<div class="row">
    <div class="col-md-9">
            
        @yield('content')
        
</div>
</div>

<div class="col-md-3">
    
    @include('layout/navbar')
</div>

    </div>
            
    <?php }else{ ?>    

        

        <div class="row">
        <div class="col-md-12">

            @yield('content')
        
    </div>
    
        </div>

        
    <?php } ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $(function() {
    $('.toggleNav').on('click',function() {
        $('.flex-nav ul').toggleClass('open');
    });
    });

//User Profile icon Menu
    function menuToggle(){
        const toggleMenu = document.querySelector('.menu');
        toggleMenu.classList.toggle('active')
    }


    function NotifyToggle(){
        const toggleMenu = document.querySelector('.notify');
        toggleMenu.classList.toggle('active')
    }

//Post Options Menu
    function changeLanguage(language) {
                    var element = document.getElementById("url");
                    element.value = language;
                    element.innerHTML = language;
                }

                function showDropdown() {
                    document.getElementById("myDropdown").classList.toggle("show");
                }

                
    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('markNotification') }}", {
            method: 'POST',
            data: {
                '_token':"{{ csrf_token() }}",
                id
            }
        });
    }

    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));

            request.done(() => {
                $(this).parents('div.alert').remove();
            });
        });

        $('#mark-all').click(function() {
            let request = sendMarkRequest();

            request.done(() => {
                $('div.alert').remove();
            })
        });
    });


//                 $("#img1").on({
//     mouseenter: function () {
//         $("#iov1").css("opacity", "1");
//     },
//     mouseleave: function () {
//         $("#iov1").css("opacity", "0");
//     }
// });
$('#img1').click(function(){

    $('#imgblock1').css("display", "flex");

});
$('#imgblockbc1').click(function(){

    $('#imgblock1').css("display", "none");

});

                
    </script>






</body>
</html>
