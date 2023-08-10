<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="{{ asset('admin.css') }}">
    <meta charset="utf-8">
    <base target="_self">
    <meta name="description" content="A Bootstrap 4 admin dashboard theme that will get you started. The sidebar toggles off-canvas on smaller screens. This example also include large stat blocks, modal and cards. The top navbar is controlled by a separate hamburger toggle button."
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" value="notranslate">
    <link rel="shortcut icon" href="/images/cp_ico.png">
  
  
    <!--stylesheets / link tags loaded here-->
  
  
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
  
    <script src="https://code.jquery.com/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
    <script src="https://kit.fontawesome.com/f304de03af.js" crossorigin="anonymous"></script>
    <title>@yield('Title', 'Social_Media')</title>
</head>




<body>

    @include('Admin.layout/navbar')
    

            @yield('content')

            
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
            
            <script>
  // sandbox disable popups
  if (window.self !== window.top && window.name != "view1") {
      window.alert = function() {
        /*disable alert*/
      };
      window.confirm = function() {
        /*disable confirm*/
      };
      window.prompt = function() {
        /*disable prompt*/
      };
      window.open = function() {
        /*disable open*/
      };
    }
    
    // prevent href=# click jump
    document.addEventListener(
      "DOMContentLoaded",
      function() {
        var links = document.getElementsByTagName("A");
        for (var i = 0; i < links.length; i++) {
          if (links[i].href.indexOf("#") != -1) {
            links[i].addEventListener("click", function(e) {
              console.debug("prevent href=# click");
              if (this.hash) {
                if (this.hash == "#") {
                  e.preventDefault();
                  return false;
                } else {
                  /*
                      var el = document.getElementById(this.hash.replace(/#/, ""));
                      if (el) {
                        el.scrollIntoView(true);
                      }
                      */
                }
              }
              return false;
            });
          }
        }
      },
      false
    );

    $(document).ready(function() {
            $("#search").keyup(function() {
                var filter = $(this).val(),
                    count = 0;
                $(".table tr").each(function() {
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).fadeOut();
                    } else {
                        $(this).show();
                        count++;
                    }
                });

                var numberItems = count;
                $("#result-count").text("Number of Results = " + count);
            });
        });

                $(document).ready(function() {
                $("[data-toggle=offcanvas]").click(function() {
                    $(".row-offcanvas").toggleClass("active");
                });
                });
                </script>
            




</body>
</html>