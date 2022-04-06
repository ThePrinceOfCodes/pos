<div class="sidebar">
    <div class="sidebar-wrapper">
        <ul class="nav">
            @hasanyrole('Developer|Admin')
            <li>
                <a data-toggle="collapse" href="#" {{ $section == 'branches' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-badge"></i>
                    <span class="nav-link-text">Branch</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class=" {{ $section == 'branches' ? 'aria-expanded=true' : '' }}" id="branches">
                    <ul class="nav pl-4">
                        @foreach ($branches as $branch)
                        <li @if ($pageSlug=='dashboard' ) class="active" @endif>
                            <a href="{{ route('home')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ $branch->name }}</p>
                            </a>
                        </li>
                        @endforeach

                        @hasrole('Developer')
                        <li @if ($pageSlug=='branches-create' ) class="active " @endif>
                            <a href="{{ route('branches.create')  }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p>New Branch</p>
                            </a>
                        </li>
                        @endhasrole
                    </ul>
                </div>
            </li>

            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @endhasanyrole
            @hasanyrole('Manager|Admin|Cashier|Developer')
            <li>
                <a data-toggle="collapse" href="#transactions" {{ $section == 'transactions' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-bank" ></i>
                    <span class="nav-link-text">Transactions</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'transactions' ? 'show' : '' }}" id="transactions">
                    <ul class="nav pl-4">

                        @role('Admin|Manager|Developer')
                        <li @if ($pageSlug == 'tstats') class="active " @endif>
                            <a href="{{ route('transactions.stats')  }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Statistics</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'transactions') class="active " @endif>
                            <a href="{{ route('transactions.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>All</p>
                            </a>
                        </li>
                        @endrole
                        @role('Cashier|Admin|Manager|Developer')
                        <li @if ($pageSlug == 'sales') class="active " @endif>
                            <a href="{{ route('sales.index')  }}">
                                <i class="tim-icons icon-bag-16"></i>
                                <p>Sales</p>
                            </a>
                        </li>
                        @endrole
                        @hasanyrole('Admin|Manager|Developer')
                        <li @if ($pageSlug == 'expenses') class="active " @endif>
                            <a href="{{ route('transactions.type', ['type' => 'expense'])  }}">
                                <i class="tim-icons icon-coins"></i>
                                <p>Expenses</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'incomes') class="active " @endif>
                            <a href="{{ route('transactions.type', ['type' => 'income'])  }}">
                                <i class="tim-icons icon-credit-card"></i>
                                <p>Income</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'transfers') class="active " @endif>
                            <a href="{{ route('transfer.index')  }}">
                                <i class="tim-icons icon-send"></i>
                                <p>Transfers</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'payments') class="active " @endif>
                            <a href="{{ route('transactions.type', ['type' => 'payment'])  }}">
                                <i class="tim-icons icon-money-coins"></i>
                                <p>Payments</p>
                            </a>
                        </li>
                        @endhasanyrole
                    </ul>
                </div>
            </li>
            @endhasanyrole

            @hasanyrole('Manager|Store Keeper|Admin|Developer')
            <li>
                <a data-toggle="collapse" href="#inventory" {{ $section == 'inventory' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-app"></i>
                    <span class="nav-link-text">Inventory</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'inventory' ? 'show' : '' }}" id="inventory">
                    <ul class="nav pl-4">
                        @hasanyrole('Admin|Manager|Developer|Store Keeper')
                        <li @if ($pageSlug == 'istats') class="active " @endif>
                            <a href="{{ route('inventory.stats') }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Statistics</p>
                            </a>
                        </li>


                        <li @if ($pageSlug == 'products') class="active " @endif>
                            <a href="{{ route('products.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'categories') class="active " @endif>
                            <a href="{{ route('categories.index') }}">
                                <i class="tim-icons icon-tag"></i>
                                <p>Categoríes</p>
                            </a>
                        </li>
                        @endhasanyrole
                        <li @if ($pageSlug == 'receipts') class="active " @endif>
                            <a href="{{ route('receipts.index') }}">
                                <i class="tim-icons icon-paper"></i>
                                <p>Receipts/Store</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'stock') class="active " @endif>
                            <a href="{{ route('stock.index') }}">
                                <i class="tim-icons icon-paper"></i>
                                <p>Stock</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endhasanyrole
            @hasrole('Admin|Developer')
            <li @if ($pageSlug == 'clients') class="active " @endif>
                <a href="{{ route('clients.index') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Clients</p>
                </a>
            </li>

            <li @if ($pageSlug == 'providers') class="active " @endif>
                <a href="{{ route('providers.index') }}">
                    <i class="tim-icons icon-delivery-fast"></i>
                    <p>Providers</p>
                </a>
            </li>

            @endhasrole
            @hasanyrole('Admin|Manager|Developer')
            @hasrole('Admin|Developer')
            <li @if ($pageSlug == 'methods') class="active " @endif>
                <a href="{{ route('methods.index') }}">
                    <i class="tim-icons icon-wallet-43"></i>
                    <p>Methods and Accounts</p>
                </a>
            </li>

            @hasrole('Developer')
            <li @if ($pageSlug == 'reports') class="active " @endif>
                <a href="{{ route('methods.index') }}">
                    <i class="tim-icons icon-money-coins"></i>
                    <p>Reports</p>
                </a>
            </li>
            @endhasrole
            @endhasrole

            <li>
                <a data-toggle="collapse" href="#users" {{ $section == 'users' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-badge" ></i>
                    <span class="nav-link-text">Users</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'users' ? 'aria-expanded=true' : '' }}" id="users">
                    <ul class="nav pl-4">

                        @hasanyrole('Admin|Manager|Developer')
                        <li @if ($pageSlug == 'users-list') class="active " @endif>
                            <a href="{{ route('users.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                        @endhasanyrole
                    </ul>
                </div>
            </li>
            @endhasanyrole
        </ul>
    </div>
</div>
