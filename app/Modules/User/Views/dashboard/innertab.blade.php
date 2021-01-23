@section('inner-tab')
<div class="cb-tabsHdr">
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#stores">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#deals">Deals</a>
                    </li>
                </ul>
                <div class="product-search">
                    <div class="form-group">
                        <input type="text" class="inpt_prdct" placeholder="Search Product & Store">
                        <img src="{{asset('asset-user/images/search.svg')}}" alt="search">
                        <img src="{{asset('asset-user/images/cross.svg')}}" alt="clear" class="field-close">
                    </div>
                </div>
            </div>
        </div>
@endsection