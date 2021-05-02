<header>
    <div class="container">
        <div id="logo-name">
            <a href="/">QuickGrocery</a>
        </div>
        <!-- Nav -->
        @guest
            <div id="header-guest" class="row">
                <div style="width: 50%">
                    <ul>
                        <li class="guest-list"><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <div style="width: 50%">
                    <ul>
                        <li class="guest-list"><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>

            </div>
        @else
            <div id="header-list" class="row">
                <div class="notification-dropdown" style="width: 65%">
                    @if(Auth::user()->role != 'systemadmin')
                    @php $var = new \App\Notification() @endphp
                    <ul>
                        <li><span class="notification-notification">Notification
                                <span class="noti-count">{{$var->notificationCount()}}</span>
                            </span>
                            <ul id="notification-list">
                                @foreach($var->getNotification()->sortByDesc('id') as $notification)
                                    <div class="notification-area">
                                        <h2>{{$notification->type}}</h2>
                                        <p>{{$notification->message}}</p>
                                        <strong style="float: right"><small>{{$notification->created_at->diffForHumans()}}</small></strong>
                                    </div>
                                @endforeach
                                <h5>Your Actions</h5>
                                @foreach(Auth::user()->notifications->sortByDesc('id') as $notification)
                                    <div class="notification-area">
                                        <h2>{{$notification->type}}</h2>
                                        <p>{{$notification->message}}</p>
                                        <strong style="float: right"><small>{{$notification->created_at->diffForHumans()}}</small></strong>
                                    </div>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    @endif
                </div>
                <div class="user-dropdown" style="width: 35%">
                    <ul>
                        <li>{{Auth::user()->name}}
                            <ul>
                                <li><a href="/customer/dashboard"> My Acount </a></li>
                                <li><a href="/logout"> Logout </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        @endguest
    </div>
</header>
<script>
    window.addEventListener("load", function () {
        $('.notification-dropdown').hover(function(e) {

            $.ajax({
                url: "/notification/update",
                method: "GET",
                data: {},
                success:function(data){

                }
            });
        })

        function foo() {
            $(".noti-count").load(" .noti-count");
            $("#notification-list").load(" #notification-list", function (e) {
                $(this).children().unwrap();
            });
            setTimeout(foo, 5000);
        }
        foo();
    })
</script>
