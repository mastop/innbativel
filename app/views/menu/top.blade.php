<ul class="top-menu">
  <li><a class="fullview"></a></li>
  <li><a class="showmenu"></a></li>
  <li><a href="#" title="" class="messages"><i class="new-message"></i></a></li>
  <li class="dropdown">
    <a class="user-menu" data-toggle="dropdown">
      <span>{{ $username }} <b class="caret"></b></span>
    </a>
    <ul class="dropdown-menu">
      @if(Auth::user()->is('parceiro'))
      <li><a href="{{ route('painel.account.edit') }}" title=""><i class="icon-user"></i>Minha conta</a></li>
      <li><a href="{{ route('painel.password.edit') }}" title=""><i class="icon-lock"></i>Alterar senha</a></li>
      @else
      <li><a href="{{ route('minha-conta') }}" title=""><i class="icon-user"></i>Minha conta</a></li>
      @endif
      <li><a href="{{ route('logout') }}" title=""><i class="icon-remove"></i>Sair</a></li>
    </ul>
  </li>
</ul>
