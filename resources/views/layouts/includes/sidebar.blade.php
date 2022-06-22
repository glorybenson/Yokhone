<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"> <span></span>
                </li>
                @if (in_array(1, Auth::user()->roles) || in_array(2, Auth::user()->roles))
                    <li class="{{ request()->is('dashboard') ? 'active active-now' : '' }}">
                        <a href="{{ route('dashboard') }}"><i class="feather-home"></i>
                            <span class="shape1"></span><span class="shape2"></span>
                            <span>{{ __('Dashboard') }}</span></a>
                    </li>
                @endif
                @if (in_array(1, Auth::user()->roles) || in_array(2, Auth::user()->roles))
                    <li
                        class="{{ request()->is('home') || request()->is('edit-user/*') || request()->is('create-user') ? 'active active-now' : '' }}">
                        <a href="{{ route('home') }}"><i class="feather-home"></i>
                            <span class="shape1"></span><span class="shape2"></span>
                            <span>{{ __('Users') }}</span></a>
                    </li>
                @endif

                @if (in_array(1, Auth::user()->roles) || in_array(3, Auth::user()->roles))
                    <li
                        class="{{ request()->is('clients') || request()->is('edit-client/*') || request()->is('create-client') ? 'active active-now' : '' }}">
                        <a href="{{ route('clients') }}"><i class="feather-lock"></i>
                            <span class="shape1"></span><span class="shape2"></span>
                            <span> {{ __('Clients') }}</span></a>
                    </li>
                @endif

                @if (in_array(1, Auth::user()->roles) || in_array(4, Auth::user()->roles))
                    <li
                        class="{{ request()->is('farms') || request()->is('edit-farm/*') || request()->is('create-farm') || request()->is('trees') || request()->is('edit-tree/*') || request()->is('create-tree') || request()->is('crops') || request()->is('edit-crop/*') || request()->is('create-crop') ? 'active active-now' : '' }}">
                        <a href="#"><i class="feather-user-plus"></i>
                            <span class="shape1"></span><span class="shape2"></span> <span>{{ __('Farm') }}</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('farms') || request()->is('edit-farm/*') || request()->is('create-farm') ? 'active' : '' }}"
                                    href="{{ route('farms') }}">{{ __('Farm') }}</a></li>
                            <li><a class="{{ request()->is('trees') || request()->is('edit-tree/*') || request()->is('create-tree') ? 'active' : '' }}"
                                    href="{{ route('trees') }}">{{ __('Trees') }}</a></li>
                            <li><a class="{{ request()->is('crops') || request()->is('edit-crop/*') || request()->is('create-crop') ? 'active' : '' }}"
                                    href="{{ route('crops') }}">{{ __('Crops') }}</a></li>
                        </ul>
                    </li>
                @endif


                @if (in_array(1, Auth::user()->roles) || in_array(5, Auth::user()->roles))
                    <li
                        class="{{ request()->is('employees') || request()->is('view-employees-salary/*') || request()->is('view-employees-record/*') || request()->is('view-employees-payment/*') || request()->is('view-employee/*') || request()->is('edit-employee/*') || request()->is('create-employee') ? 'active active-now' : '' }}">
                        <a href="{{ route('employees') }}"><i class="feather-lock"></i>
                            <span class="shape1"></span><span class="shape2"></span>
                            <span> {{ __('Employees') }}</span></a>
                    </li>

                    <!-- <li class="{{ request()->is('employees') || request()->is('view-employees-salary/*') || request()->is('view-employee/*') || request()->is('edit-employee/*') || request()->is('create-employee') ? 'active active-now' : '' }}">
                    <a href="#"><i class="feather-user"></i>
                        <span class="shape1"></span><span class="shape2"></span>
                        <span> Employees</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ request()->is('employees') || request()->is('view-employees-salary/*') || request()->is('view-employee/*') || request()->is('edit-employee/*') || request()->is('create-employee') ? 'active active-now' : '' }}" href="{{ route('expenses') }}">Employees</a></li>
                        <li><a class="{{ request()->is('employees') || request()->is('view-employees-salary/*') || request()->is('view-employee/*') || request()->is('edit-employee/*') || request()->is('create-employee') ? 'active active-now' : '' }}" href="{{ route('expenses') }}">Employee Record</a></li>
                        <li><a class="{{ request()->is('invoices') || request()->is('create-invoice') || request()->is('edit-invoice/*') ? 'active active-now' : '' }}" href="{{ route('invoices') }}">Payment</a></li>
                    </ul>
                </li> -->
                @endif


                @if (in_array(1, Auth::user()->roles) || in_array(6, Auth::user()->roles))
                    <li
                        class="{{ request()->is('invoices') || request()->is('create-invoice') || request()->is('edit-invoice/*') || request()->is('expenses') || request()->is('create-expense') || request()->is('edit-expense/*') ? 'active active-now' : '' }}">
                        <a href="#"><i class="feather-user"></i>
                            <span class="shape1"></span><span class="shape2"></span>
                            <span> {{ __('Finance') }}</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('expenses') || request()->is('create-expense') || request()->is('edit-expense/*')
                                ? 'active active-now'
                                : '' }}"
                                    href="{{ route('expenses') }}">{{ __('Expenses') }}</a>
                            </li>
                            <li><a class="{{ request()->is('invoices') || request()->is('create-invoice') || request()->is('edit-invoice/*')
                                ? 'active active-now'
                                : '' }}"
                                    href="{{ route('invoices') }}">{{ __('Invoices') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if (in_array(1, Auth::user()->roles))
                    <li class="{{ request()->is('report-salaries') ? 'active active-now' : '' }}">
                        <a href="#"><i class="feather-user"></i>
                            <span class="shape1"></span><span class="shape2"></span>
                            <span> {{ __('Reports') }}</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="">{{ __('Expenses') }}</a></li>
                            <li><a href="">{{ __('Incomes') }}</a></li>
                            <li><a href="">{{ __('Employees') }}</a></li>
                            <li><a href="{{ route('salary') }}">{{ __('Salaries') }}</a></li>
                            <li><a href="">{{ __('Farms') }}</a></li>
                            <li><a href="">{{ __('Trees') }}</a></li>
                            <li><a href="">{{ __('Clients') }}</a></li>
                            <li><a href="">{{ __('Login history') }}</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
