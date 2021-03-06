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
        <aside class="column is-2 aside has-background-light" style="margin: 12px">
            <nav class=menu><p class=menu-label>General</p>
                <ul class=menu-list>
                    <li>
                        <router-link to="/home" class="page " onclick="sideBar(event)"><span class="icon is-small"><i
                                    class="fas fa-tachometer-alt"></i></span>
                            Dashboard
                        </router-link>
                    </li>
                </ul>
                <p class="menu-label has-text-white has-background-success">Transaction Management</p>
                <ul class=menu-list>
                    <li>
                        <router-link onclick="sideBar(event)" to="/transaction" class="page has-text-success"><span
                                class="icon is-small">
                                <i class="fas fa-paper-plane"></i></span> Send Money
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/report" class="page has-text-success" onclick="sideBar(event)">Transaction
                            Reports
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/search" class="page has-text-success" onclick="sideBar(event)">Transaction
                            Payout
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/history" class="page has-text-success" onclick="sideBar(event)">Transaction
                            History
                        </router-link>
                    </li>
                </ul>
                @can('isAdmin')
                    <p class="menu-label has-background-danger has-text-white">Agents Management</p>
                    <ul class=menu-list>
                        <li>
                            <router-link to="/register" class="page has-text-danger" onclick="sideBar(event)"><span
                                    class="icon is-small"><i
                                        class="fa fa-bar-chart"></i></span> Add Agent
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/member" class="page has-text-danger" onclick="sideBar(event)">Agents
                            </router-link>
                        </li>
                    </ul>

                    <p class="menu-label has-background-grey has-text-white"> Finance Management</p>
                    <ul class=menu-list>
                        <li>
                            <router-link to="/wallet" class="page has-text-grey" onclick="sideBar(event)"><span
                                    class="icon is-small"><i
                                        class="fa fa-bar-chart"></i></span>Agents List
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/report_f" class="page has-text-grey" onclick="sideBar(event)"> Finances
                                Reports
                            </router-link>
                        </li>
                    </ul>

                    <p class="menu-label has-background-primary"> Settings </p>
                    <ul class=menu-list>
                        <li>
                            <router-link to="/setting" class="page has-text-primary" onclick="sideBar(event)"><span
                                    class="icon is-small"><i
                                        class="fa fa-bar-chart"></i></span>General
                            </router-link>
                            <router-link to="/user" class="page has-text-primary" onclick="sideBar(event)"><span
                                    class="icon is-small"><i
                                        class="fa fa-bar-chart"></i></span>Users
                            </router-link>
                            <router-link to="/role" class="page has-text-primary" onclick="sideBar(event)"><span
                                    class="icon is-small"><i
                                        class="fa fa-bar-chart"></i></span>Role & Permissions
                            </router-link>
                        </li>

                    </ul>
                @endcan
            </nav>
        </aside>
        <main class="column main">

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

    function sideBar(event) {
        // Get all element with class tablinks and remove class is-active
        page = document.getElementsByClassName("page");

        // for (i = 0; i < page.length; i++) {
        //     page[i].className = page[i].className.replace("is-active", "");
        //     page[i].className = page[i].className.replace("page", "");
        // }
        event.currentTarget.className = event.currentTarget.className.replace("is-active", "");
        event.currentTarget.className = event.currentTarget.className.replace("has-text", "");
        console.log(event.currentTarget.className);
        event.currentTarget.className += " is-active";
    }


</script>
@auth()
    <script>
        window.user = @json(auth()->user())
    </script>
@endauth
</body>
</html>
