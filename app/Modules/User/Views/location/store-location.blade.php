@extends("Store::product.layout")
@include('Store::product.inner-header')
@include('Store::product.navigationbar');

@section('content')

<!-- Header End -->
<!-- Internal Container -->
@yield('inner-header')

<div class="internal-container product">


    @yield('nav-bar')


    <div class="cb-tabsBody">
        <div class="tab-content">
            <div id="locations" class="container-fluid tab-pane active">
                <div class="locationWrapper">
                    <div class="leftSegment">
                        <figure>
                            <div id="map_canvas">
                            </div>
                        </figure>
                        <div class="locationsearchWrapper">
                            <div class="form-group">
                                <input type="text" name="address" id="address" placeholder="Search by zip code" class="locationSearch">
                                <button class="btn custom-btn green-fill getstarted" id="searchMapButton">Search</button>
                                <button class="btn custom-btn green-fill getstarted" id="submit_store_location">Add Area</button>
                                
                            </div>
                        </div>
                    </div>


                    <form action="{{route('submit.store.delivery.location.list')}}" id="submit_hidden_params" method="post">

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="street_number" value="" id="street_number">
                        <input type="hidden" name="locality" value="" id="locality">
                        <input type="hidden" name="postal_code" value="" id="postal_code">
                        <input type="hidden" name="country" value="" id="country">
                        <input type="hidden" name="state" value="" id="administrative_area_level_1">
                        <input type="hidden" name="lat" value="" id="lat">
                        <input type="hidden" name="lng" value="" id="lng">
                        <input type="hidden" name="address" value="" id="hiddenaddress">

                    </form>


                    <div class="rightSegment">

                    <form action="{{route('store.location.list')}}" id="submit_form_location"  method="get">
                        <div class="hdrArea">
                            <div class="searchBarArea">
                                <input type="text" class="inpt_prdct" id="searchInput" value="{{Request::get('search')}}" name="search" placeholder="Search by added areas name">
                                @if(Request::has('search'))
                                    <a href="{{route('store.location.list')}}"><img src="{{asset('asset-store/images/cross.svg')}}" class="closeProductMenu" alt="cross"></a>
                                @endif
                                <img src="{{asset('asset-store/images/search.svg')}}" id="searchInputButton" alt="search">
                            </div>
                            <div class="rightsortArea">
                                <p>Sort by</p>
                                <select id="select_box_area" name="status">
                                    <option @if(Request::get('status') == "") selected @endif value="">All Areas</option>
                                    <option @if(Request::get('status') == "active") selected @endif value="active">Active Areas</option>
                                    <option @if(Request::get('status') == "blocked") selected @endif value="blocked">In-Active Areas</option>
                                </select>
                                <img src="{{asset('asset-store/images/droparrow.svg')}}" alt="search">
                            </div>
                        </div>
                    </form>


                        <div class="productListBodyWrapper loationArea">
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <th align="center">S.No.</th>
                                    <th>Area</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                @if($deliveryaddress->isNotEmpty())
                                        <?php $i = ($deliveryaddress->currentpage() - 1) * $deliveryaddress->perpage() + 1; ?>
                                        @foreach($deliveryaddress as $key => $val)

                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$val->formatted_address}}</td>
                                            <td>
                                                
                                            <!-- {{ucfirst($val->status)}} -->


                                            <label class="switch">
                                            @if($val->status == "active")
                                                <input type="checkbox" data-val="{{$val->id}}" class="change-status" checked>
                                            @else
                                                <input type="checkbox" data-val="{{$val->id}}" class="change-status"> 
                                            @endif 
                                            <span class="slider round"></span>
                                            </label>


                                            </td>
                                            
                                            <td>
                                                <a href="{{route('remove.store.delivery.location')}}?params={{$val->id}}">
                                                    <img class="removeImage_{{$val->id}}" src="{{ asset('asset-store/images/delete.svg')}}" >
                                                </a>
                                            </td>
                                        </tr>


                                        @endforeach


                                @else
                                    <tr><td><span class="text-center no-data-found">No data found</span></td></tr>

                                @endif




                            </table>
                            </div>
                            {{ $deliveryaddress->links() }}

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>



@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="https://libs.cartocdn.com/carto.js/v4.1.11/carto.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>  
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCyWoAibRItIGdGMHjolWUyl-58EC4WIsQ"></script>
<script type="text/javascript" src="{{asset('asset-store/js/maps/info.js')}}"></script>
<script type="text/javascript" src="{{asset('asset-store/js/maps/g3s.js')}}"></script>
<script type="text/javascript" src="{{asset('asset-store/js/maps/overlay.js')}}"></script>
<script src="{{asset('asset-store/js/maps.service.zipcode.js')}}"></script>
<script src="{{asset('asset-store/js/add-store-location.js')}}"></script>


@endsection





@endsection