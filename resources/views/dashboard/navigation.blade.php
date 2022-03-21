@php
    $checkUserVerificationStatus = \App\Member::where('user_id',Auth::id())->first();
@endphp
@section('sidebar')
    <aside class="main-sidebar isDisabled" style="font-size: large ! important; background-color: #fff; color: #0b2e13;">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        @if(Auth::user()->passport_url != null)
                        <img src="{{asset('/storage/'. Auth::user()->passport_url)}}" class="img-circle">
                        @endif
                        @if(Auth::check())
                            <a href="#"><i class="fa fa-circle text-success" style="font-size: 8px ! important;"></i> Online</a>
                        @endif
                    </div>
                </div>
            @php
                $name = Route::currentRouteName(); //echo $name;
            @endphp
            <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu" data-widget="tree" >
                    <li class="active treeview menu-open">
                        <a href="#">
                            <i class="fa fa-dashboard"></i> <span>My Dashboard</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            @if($name !=='home')
                                <ul class="treeview-menu">
                                    <li><a href="{{url('/dashboard/home')}}"><i class="fa fa-home"></i>Dashboard</a></li>
                                </ul>
                            @endif
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-money"></i>
                            <span>My Loan Activities</span>
                            <span class="pull-right-container">
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('/application/loanApplication/')}}"><i class="fa fa-pencil-square"></i>Apply for Loan</a></li>
                            <li><a href="{{url('/application/loanList/')}}"><i class="fa fa-eye"></i>View all Loans</a></li>
                            <li><a href="{{url('/application/loanList/')}}"><i class="fa fa-eye"></i>Offset Loan Balance</a></li>
                            <li><a href="{{url('/archive/loanHistory/')}}"><i class="fa fa-eye"></i>My Loan Archive</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-bank"></i>
                            <span>My Account Activities</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('/savings/savingStandingOrder')}}"><i class="fa fa-circle-o"></i>Saving Authorization</a></li>
                            <li><a href="{{url('/savings/savingAuthorizationList')}}"><i class="fa fa-circle-o"></i>View all Authorizations</a></li>
                            <li><a href="{{url('/withdrawals/makeWithdrawal')}}"><i class="fa fa-circle-o"></i>Make Withdrawal</a></li>
                            <li><a href="{{url('/withdrawals/withdrawalTransactions')}}"><i class="fa fa-circle-o"></i>View Saving Transactions</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-exchange"></i>
                            <span>My Transactions</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('/transactions/myTransactions')}}"><i class="fa fa-eye"></i>View all Transactions</a></li>
                        </ul>
                    </li>
                    {{--<li class="treeview">
                      <a href="#">
                          <i class="fa fa-edit"></i> <span>Comments & Reviews</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="{{url('/comments/comment')}}"><i class="fa fa-edit"></i>Drop a Comment</a></li>
                      </ul>
                    </li>--}}
                  {{--<li class="treeview">
                      <a href="#">
                          <i class="fa fa-mars-double"></i> <span>Election/Polling Center</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="{{url('/elections/electionCenter')}}"><i class="fa fa-edit"></i>Visit Election Center</a></li>
                      </ul>
                  </li>--}}
                  <li class="treeview">
                      <a href="#">
                          <i class="fa fa-edit"></i> <span>My Reports</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="{{url('reports/user/userReportTemplate')}}"><i class="fa fa-edit"></i>All Reports With Filter</a></li>
                          <li><a href="{{url('reports/user/accountStatement')}}"><i class="fa fa-edit"></i>Print Account Statement</a></li>
                          <li><a href="{{url('reports/user/loanStatement')}}"><i class="fa fa-edit"></i>Print Loan Statement</a></li>
                          <li><a href="{{url('reports/user/transactionStatement')}}"><i class="fa fa-edit"></i>Print Transactions</a></li>
                          <li><a href="{{url('reports/user/dividends')}}"><i class="fa fa-edit"></i>Print Dividends</a></li>
                      </ul>
                  </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    @if($checkUserVerificationStatus->approval_count != 2)
        @php
            echo '<style type="text/css">
                .isDisabled {
                    color: currentColor;
                    cursor: not-allowed;
                    display: inline-block;
                    opacity: 0.5;
                    text-decoration: none;
                    pointer-events: none;
                }
            </style>';
        @endphp
    @endif
    @if($checkUserVerificationStatus->certification != 1)
    @php
        echo '<style type="text/css">
            .isDisabled {
                color: currentColor;
                cursor: not-allowed;
                display: inline-block;
                opacity: 0.5;
                text-decoration: none;
                pointer-events: none;
            }
        </style>';
    @endphp
    @endif

@endsection
