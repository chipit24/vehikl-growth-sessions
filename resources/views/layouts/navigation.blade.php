<nav class="bg-purple-500 p-6">
    <div class="container flex items-center  mx-auto justify-between flex-wrap">
        <div class="flex items-center flex-shrink-0 mr-6 text-white hover:text-orange-200">
            <span class="material-icons text-4xl px-4">
                group_work
            </span>
            <a href="{{ route('home') }}"
               class="font-semibold text-3xl">{{ config('app.name', 'Social Mob') }}</a>
        </div>
        <div class="block lg:hidden">
            <button
                class="flex items-center px-3 py-2 border rounded text-white border-white hover:text-orange-200 hover:border-orange-200"
                onclick="document.getElementById('nav-links').classList.toggle('hidden')"
                @click="isExpanded = !isExpanded">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>
                        Menu
                    </title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                </svg>
            </button>
        </div>
        <div class="w-full hidden lg:flex justify-end lg:items-center lg:w-auto text-center" id="nav-links">
            <div class="text-xl">
                @guest
                    <a href="{{route('oauth.login.redirect')}}"
                       class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-200 mr-6">
                        Login with Github
                    </a>
                    <a href="{{ route('login') }}"
                       class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-200 mr-6">
                        Login with SocialMob
                    </a>
                    <a href="{{ route('register') }}"
                       class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-200">
                        Register
                    </a>
                @endguest
                @auth
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-200">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
