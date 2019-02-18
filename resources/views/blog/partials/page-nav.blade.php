{{-- navigation --}}
<nav class="navbar navbar-expand-lg navbar-light fixed-top"  id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/">{{config('blog.name')}}</a>
        <button class="navbar-toggler navbar-toggler-light " type="button" data-toggle="collapse" data-targer="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle Navigation">
        <i class="fa fa-bars"></i>
        </button>
        {{-- Collect the nav links, forms, and other content for toggling --}}
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">首页</a>
                </li>
            </ul>
        </div>
    </div>
</nav>