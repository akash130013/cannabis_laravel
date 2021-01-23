@section('nav-bar')
<div class="cb-tabsHdr">
                <!-- Form Container -->
                <div class="form-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ ((in_array(request()->route()->getName(),['store.location.list'])) ? 'active' : '') }}" href="{{route('store.location.list')}}">Locations</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#drivers">Drivers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ((in_array(request()->route()->getName(),['store.product.dashboard','store.product.add-page','show.product.detail','store.edit.product'])) ? 'active' : '') }}"  href="{{route('store.product.dashboard')}}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#orders">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#earnings">Earnings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#offers">Offers</a>
                        </li>
                    </ul>
                </div>
                <!-- Form Container End -->
</div>
@endsection