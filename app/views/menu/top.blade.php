<ul class="top-menu">
  <li><a class="fullview"></a></li>
  <li><a class="showmenu"></a></li>
  <li><a href="#" title="" class="messages"><i class="new-message"></i></a></li>
  <li class="dropdown">
    <a class="user-menu" data-toggle="dropdown">
      <img src="{{ asset('assets/themes/floripa/backend/img/userpic.png') }}" alt="">
      <span>{{ $username }} <b class="caret"></b></span>
    </a>
    <ul class="dropdown-menu">
      <li><a href="#" title=""><i class="icon-user"></i>Meu Perfil</a></li>
      <li><a href="{{ route('logout') }}" title=""><i class="icon-remove"></i>Sair</a></li>
    </ul>
  </li>
</ul>
