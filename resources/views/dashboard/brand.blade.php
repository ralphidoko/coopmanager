    @php
        $is_admin = Auth::user()->is_admin;
    @endphp

    @if($is_admin == true)
        <a href="{{url('/dashboard/admin/adminHome')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>I</b>C</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="font-size: 40px; font-weight: bold;"><b style="color:darkred;font-weight: bold">ISO</b>CooP<sup style="font-size: 12px;color:darkred">TM</sup></span>
        </a>
    @elseif($is_admin == false)
        <a href="{{url('/dashboard/home')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>I</b>C</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="font-size: 40px; font-weight: bold;"><b style="color:darkred;font-weight: bold">ISO</b>CooP<sup style="font-size: 12px;color:darkred">TM</sup></span>
        </a>
    @endif

