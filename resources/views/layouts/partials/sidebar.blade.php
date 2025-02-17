  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link collapsed" href="index.php">
                  <i class="bi bi-grid"></i>
                  <span>Tableau de bord</span>
              </a>
          </li><!-- End Tableau de bord Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#projets-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>projets</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="projets-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="projets-list-group.php">
                          <i class="bi bi-circle"></i><span>List group</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End projets Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#task-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>task</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="task-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="task-list-group.php">
                          <i class="bi bi-circle"></i><span>List group</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End task Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>users</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="users-list-group.php">
                          <i class="bi bi-circle"></i><span>List group</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End users Nav -->



          <li class="nav-heading">Pages</li>

          <li class="nav-item">
              <a class="nav-link collapsed" href="{{ route('profile') }}">
                  <i class="bi bi-person"></i>
                  <span>Profile</span>
              </a>
          </li><!-- End Profile Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="pages-faq.php">
                  <i class="bi bi-question-circle"></i>
                  <span>F.A.Q</span>
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
