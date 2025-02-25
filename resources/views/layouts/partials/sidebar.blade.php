  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link collapsed" href="index.php">
                  <i class="bi bi-grid"></i>
                  <span>Tableau de bord</span>
              </a>
          </li><!-- End Tableau de bord Nav -->




          <li class="nav-heading">Pages</li>

          <li class="nav-item">
              <a class="nav-link collapsed" href="{{ route('profile') }}">
                  <i class="bi bi-person"></i>
                  <span>Profile</span>
              </a>
          </li><!-- End Profile Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="{{ route('projects.index') }}">
                  <i class="bi bi-question-circle"></i>
                  <span>Projet</span>
              </a>
          </li><!-- End F.A.Q Page Nav -->

          @if (Auth::check())
              <!-- Si l'utilisateur est connecté, afficher le lien de déconnexion -->
              <li class="nav-item">
                  <a class="nav-link collapsed" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="bi bi-box-arrow-right"></i>
                      <span>Logout</span>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </li><!-- End Logout Nav -->
          @else
              <!-- Si l'utilisateur n'est pas connecté, afficher les liens d'inscription et de connexion -->
              <li class="nav-item">
                  <a class="nav-link collapsed" href="{{ route('register') }}">
                      <i class="bi bi-card-list"></i>
                      <span>Register</span>
                  </a>
              </li><!-- End Register Page Nav -->

              <li class="nav-item">
                  <a class="nav-link collapsed" href="{{ route('login') }}">
                      <i class="bi bi-box-arrow-in-right"></i>
                      <span>Login</span>
                  </a>
              </li><!-- End Login Page Nav -->
          @endif



      </ul>

  </aside><!-- End Sidebar-->
