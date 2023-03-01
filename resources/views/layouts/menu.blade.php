<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if (Auth::user()->role == 'admin')
          <li class="nav-item">
            <a href="{{url('admin_dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @elseif (Auth::user()->role == 'technician')
          <li class="nav-item">
            <a href="{{url('technician_dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @else
          <li class="nav-item">
            <a href="{{url('student_dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @endif

          @can('isAdmin')
          <li class="nav-item">
            <a href="{{url('department-datatable')}}" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Departments
              </p>
            </a>
          </li>
          <li class="nav-item">
           <a href="{{url('ticket-datatable')}}" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Tickets
              </p>
            </a>
          </li>
          <li class="nav-item menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Manage Tickets
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{url('manageticket-datatable')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assign Tickets</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{url('allassignedticket-datatable')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assigned Tickets</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
          <a href="{{url('user-datatable')}}" class="nav-link">
                          <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>

          @endcan


          @can('isTechnician')
          <li class="nav-item">
              <a href="{{url('assignedticket-datatable')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assigned Tickets</p>
                </a>
              </li>
              
          @endcan

          @can('isStudent')
          <li class="nav-item">
          <a href="{{url('myticket-datatable')}}" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                My Tickets
              </p>
            </a>
          </li>
          @endcan

          <li class="nav-item">
           <a href="{{url('profile')}}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
        </ul>
      </nav>