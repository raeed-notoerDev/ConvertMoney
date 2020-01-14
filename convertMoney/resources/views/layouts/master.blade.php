<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset("lity/dist/lity.css")}}" rel="stylesheet">
</head>
<body>
<div class=wrapper id="app">
    <header-component></header-component>
    <div class=columns>
        <aside class="column is-2 aside has-background-light">
            <nav class=menu><p class=menu-label>General</p>
                <ul class=menu-list>
                    <li>
                        <router-link to="/home" class=is-active><span class="icon is-small"><i
                                    class="fas fa-tachometer-alt"></i></span>
                            Dashboard
                        </router-link>
                    </li>
                </ul>
                <p class="menu-label has-text-success">Transaction Management</p>
                <ul class=menu-list>
                    <li>
                        <router-link to="/transaction"><span class="icon is-small">
                                <i class="fas fa-paper-plane"></i></span> Send Money
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/report">Transaction Reports</router-link>
                    </li>
                    <li>
                        <router-link to="/search">Transaction Receiver</router-link>
                    </li>
                    <li>
                        <router-link to="/history">Transaction History</router-link>
                    </li>
                </ul>
                <p class="menu-label has-text-danger">Members Management</p>
                <ul class=menu-list>
                    <li>
                        <router-link to="/register"><span class="icon is-small"><i
                                    class="fa fa-bar-chart"></i></span> Add Members
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/member">Members</router-link>
                    </li>
                </ul>
                <p class="menu-label has-text-info"> Finance Management</p>
                <ul class=menu-list>
                    <li>
                        <router-link to="/wallet"><span class="icon is-small"><i
                                    class="fa fa-bar-chart"></i></span>Agents List
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/report_f"> Finances Reports</router-link>
                    </li>
                </ul>
                <p class="menu-label has-text-primary"> Settings </p>
                <ul class=menu-list>
                    <li>
                        <router-link to="/setting"><span class="icon is-small"><i
                                    class="fa fa-bar-chart"></i></span>General
                        </router-link>
                    </li>

                </ul>

            </nav>
        </aside>
        <main class="column main">
            <div class="media " style="margin-top: 40px;margin-left: 40px ">
                <figure class="logo media-left" style="  display: none;">
                    <div class="image is-128x128">
                        <img src="/images/1578051142.png"/>
                    </div>
                </figure>
                <div class="media-content logo-container" style="  display: none;">
                    <div class="content">
                        <p class="title">Company Name</p>
                        <p class="subtitle">Description </p>
                    </div>
                </div>
            </div>
            <router-view></router-view>
        </main>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.7.3/feather.min.js"></script>
<script src="{{asset("lity/vendor/jquery.js")}}" defer></script>
<script src="{{ asset("lity/dist/lity.js")}}" defer></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script>
    $(document).ready(function () {
        feather.replace();
        $(".is-save").on("click", function () {
            $(this).addClass("is-loading");
            setTimeout(function () {
                $(".is-save")
                    .removeClass("is-loading")
                    .addClass("is-disabled");
                $(".form-wrapper, .success-block").toggleClass("is-hidden");
            }, 1000);
            setTimeout(function () {
                $(".success-block").addClass("is-active");
            }, 1500);

            setTimeout(function () {
                $(".reset").removeClass("is-hidden");
            }, 2000);
            //
        });
        $(".reset").on("click", function () {
            $(this).addClass("is-hidden");
            $(".is-save").removeClass("is-disabled");
            $(".form-wrapper, .success-block").toggleClass("is-hidden");
            $(".success-block").removeClass("is-active");
        });
    });

    function openTab(event, tabId) {
        // Get all element with class tabcontent and hide them

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        // Get all element with class tablinks and remove class is-active
        tablinks = document.getElementsByClassName("tablinks");

        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace("is-active", "");
        }


        tabLink = document.getElementsByClassName("tab-link");

        for (i = 0; i < tabLink.length; i++) {
            tabLink[i].className = tabLink[i].className.replace("is-static", "");
            tabLink[i].className = tabLink[i].className.replace(" is-info", "");
        }



        if (tabId === 'sender') {
            document.getElementById('send').className += ' is-info';
            document.getElementById('info').className += ' is-static';
            document.getElementById('receive').className += ' is-static';
        } else if (tabId === 'receiver') {
            document.getElementById('receive').className += ' is-info';
            document.getElementById('send').className += ' is-static';
            document.getElementById('info').className += ' is-static';
        } else if (tabId === 'transaction-information') {
            document.getElementById('info').className += ' is-info';
            document.getElementById('receive').className += ' is-static';
            document.getElementById('send').className += ' is-static';
        }
        // Show current tab and add is-active to that tab
        document.getElementById(tabId).style.display = 'block';
        event.currentTarget.className += " is-active";

    }


</script>
</body>
</html>
