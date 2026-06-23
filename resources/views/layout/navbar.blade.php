 <nav class="navbar navbar-static-top" role="navigation">
     <!-- Sidebar toggle button-->
     <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
         <span class="sr-only">Toggle navigation</span>
     </a>
     <div class="navbar-custom-menu">
         <ul class="nav navbar-nav">
            
             <!-- User Account: style can be found in dropdown.less -->
             <li class="dropdown user user-menu">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <img src="{{ asset('assets/images/login_user.jpeg') }}" class="user-image" alt="User Image">
                     <span class="hidden-xs">{{ Session::get('data.name') }}</span>
                 </a>
                 <ul class="dropdown-menu">
                     <!-- User image -->
                     <li class="user-header">
                         <img src="{{ asset('assets/images/login_user.jpeg') }}" class="img-circle" alt="User Image">
                         <p>
                             {{ Session::get('data.name') }}
                             <small>{{ Session::get('data.role') == 'admin' ? 'Admin Sistem' : 'Guru' }}</small>
                         </p>
                     </li>
                     <!-- Menu Body -->
                  
                     <!-- Menu Footer-->
                     <li class="user-footer">
                        
                         <div class="pull-right">
                             <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                         </div>
                     </li>
                 </ul>
             </li>
         </ul>
     </div>
 </nav>
