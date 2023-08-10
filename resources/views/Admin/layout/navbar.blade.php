


<div class="container-fluid" id="main">

    <div class="row row-offcanvas row-offcanvas-left">

        
        <div class="col-md-3 col-lg-2 sidebar-offcanvas" id="sidebar" role="navigation">

            <img src="" alt="">
        
    
        <ul class="nav flex-column pl-1">
            <li class="nav-item" style="margin-bottom: 5px">
            <img src="{{ url('img.png') }}" alt="" class="rounded-circle" style="width: 50px;height:50px;">
            Abod
            <hr>
        </li>
            
        
            <li class="nav-item">
                <?php 
                if(!isset($search)){
                ?>
                <input type="search" id="search" name="search" style="border-radius:5px;" placeholder="Search Here...">
            <?php 
            }
            ?>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('Dashboard') }}">Dashboard</a></li>
            
        <li class="nav-item"><a class="nav-link" href="{{ route('all.users') }}">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('all.comments') }}">Comments</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('all.reports') }}">Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('all.posts') }}">Posts</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.logout') }}">Logout</a></li>
        
        </ul>
        </div>
        
