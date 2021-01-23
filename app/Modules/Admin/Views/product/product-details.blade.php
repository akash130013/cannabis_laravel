@extends('Admin::includes.layout')

@section('content')
<div class="wrapper">
        <!-- Side menu start here -->
     
        @include('Admin::includes.sidebar')

        <!-- Side menu ends here -->
        <div class="right-panel">

             @include('Admin::includes.header')

            <div class="inner-right-panel">
                <div class="breadcrumb-section">
					<ul class="breadcrumb">
                    <li><a href="{{route('admin.product.listing')}}">Product</a></li>
                        <li class="active">Details</li>
                    </ul>
				</div>
                <section>
                <div class="white_wrapper promo-details">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="heading">
                                <div class="blok_heading">
                                <h2>{{$data->product_name ?? 'N/A'}}</h2>
                                   
                                </div>
                                <!-- <p><a href="javascript:void(0)">Review and ratings</a></p> -->
                            </div>
                        </div>
                    </div>
                    <form action="">
                        <div class="detail-section pd-20">
                            <div class="row">
                                {{-- <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Product ID</label>
                                    <p>{{$data->id ?? ''}}</p>
                                    </div>
                                </div> --}}
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Name</label>
                                        <p>{{ucfirst($data->product_name) ?? '--'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <p>{{ucfirst($data->getCategory->category_name) ?? '--'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No of Stores Selling</label>
                                        <a href="{{route('admin.store.index',['product_id'=>$data->encrypt_id])}}" class="numOf">{{$count['store_product']}}</a>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No of Orders</label>
                                        <p>{{$data->total_placed_order ?? '--'}}</p>
                                        {{-- <a href="{{route('admin.order.index',['product_id'=>$data->encrypt_id])}}" class="numOf">{{$data->total_placed_order ?? '--'}}</a> --}}
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <p>{{ucfirst($data->status) ?? '--'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Packing Available</label>
                                        <p>{{$count['store_package_sum']}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Ratings</label>

                                    <p class="numOf">
                                        <a href="{{route('admin.product.rating',['product_id'=>$data->encrypt_id])}}"> {{!$data->getAvgRating->isEmpty()?$data->getAvgRating->first()->average_rating:0}}
                                        </a>
                                       
                                </p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">THC Percentage</label>
                                        <p>{{$data->thc_per ?? '--'}}%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">CBD Percentage</label>
                                        <p>{{$data->cbd_per ?? '--'}}%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Description</label>
                                        <p class="commn-para">
                                            {{ucfirst($data->product_desc) ?? '--'}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Images</label>
                                        <div>
                                            @foreach ($data->getImage as $item)
                                                <figure class="p-detail-image">
                                                   <img src="{{$item->file_url}}">   
                                                </figure>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <div class="btn-holder text-center clearfix">
                                        
                                        {{-- @if ('active' === $data->status) 
                                           
                                           <button type="button" class="btn success hvr-ripple-out" data-type="product" data-text="Product will be blocked" id="warning-alert" href="javascript:void(0); ">Block</button>
                              
                                            @else
                                                  
                                         <button type="button" class="btn success hvr-ripple-out" data-type="product" data-text="Product will be unblocked" id="info-alert" href="javascript:void(0); ">Unblock</button>

                                            @endif --}}
                                            <a href="{{route('admin.product.listing')}}"> <button type="button" class=" mr10  green-fill-btn">Back</button></a>
                                            
                                            <a href="{{route('admin.product.edit',['id'=>$data->encrypt_id])}}"><button type="button" class="green-fill-btn  mr10">Edit</button></a>


                                    </div>
                                 </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="blockedProduct" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cropper Modal</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
    </div>
@endsection