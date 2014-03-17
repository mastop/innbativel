<div class="error-page">
      <span class="reason">403</span>
    <div class="error-content">
          <span class="reason-title">- Oops, Ajax! -</span>

        <!-- Search widget -->
        <form class="search" action="#">
          <div class="autocomplete-append">
            <input type="text" placeholder="search website..." id="autocomplete" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
            <input type="submit" class="btn btn-info" value="Buscar">
          </div>
        </form>
        <!-- /search widget -->

          <div class="row-fluid error-buttons">
              <a href="{{ url('admin') }}" title="" class="btn btn-info span6">Ir à página administrativa</a>
              <a href="{{ url('/') }}" title="" class="btn btn-success span6">Visitar a Página Principal</a>
          </div>
      </div>
  </div>
