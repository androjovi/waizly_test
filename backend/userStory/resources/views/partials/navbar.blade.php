@auth
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ route('product.show') }}">myProductStory</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      @if(auth()->user()->role == 2)
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('product.show') }}">Buy Product <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('order.show') }}">My Orders</a>
      </li>
      @endif
    </ul>
    <span class="navbar-text">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" disabled>Hello {{ auth()->user()->name }}.</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('profile.show') }}">My Profile</a>
      </li>
      @if(auth()->user()->role == 1)
      <li class="nav-item active">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Manage Product
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('product.create') }}">Adding Product</a>
            <a class="dropdown-item" href="{{ route('product.showListProduct') }}">List Product</a>
          </div>
        </div>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
      </li>
    </ul>
    </span>
  </div>
</nav>
@endauth