@extends('Admin::includes.layout')

@section('content')
<div class="wrapper">
        
        @include('Admin::includes.sidebar')

        <!-- Side menu ends here -->
        <div class="right-panel">

             @include('Admin::includes.header')

             <div class="inner-right-panel">
                    <div class="breadcrumb-section">
                            <ul class="breadcrumb">
                            <li><a href="{{route('admin.category.index')}}">Category</a></li>
                                <li class="active">Details</li>
                            </ul>
                        </div>
                    <!-- product details start-->
                    <div class="white_wrapper product-details">
    
                        <!--block heading -->
                        <div class="blok_heading product-heading">
                            <h2>{{$data->category_name ?? 'N/A'}}</h2>
                        </div>
                        <!--block heading -->
    
                        <div class="pd-20">
                            <!-- table start -->
    
                            <!-- row repeat -->
                            <div class="flex-row row-space">
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Category Name</label>
                                    <span class="label-data">{{$data->category_name ?? 'N/A'}}</span>
                                </div>
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Created At</label>
                                    <span class="label-data">{{\App\Helpers\CommonHelper::convertFormat($data->created_at,'M d, Y')}}</span>
                                </div>
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Category Description</label>
                                    <span class="label-data td-scroll">{{$data->category_desc ?? 'N/A'}}</span>
                                </div>
                            </div>
                            <!-- row repeat -->
    
                            <!-- row repeat -->
                            <div class="flex-row row-space">
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Status</label>
                                    <span class="label-data">{{ucfirst($data->status) ?? ''}}</span>
                                </div>
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Image</label>
                                    <span class="label-data">
                                        <figure class="categ_img">
                                                @if ($data->image_url)
                                                <img src="{{$data->image_url}}">  
                                                @else
                                                   N/A 
                                                @endif
                                        </figure>
                                    </span>
                                </div>
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Thumbnail Image</label>
                                    <span class="label-data">
                                            @if ($data->thumb_url)
                                            <img src="{{$data->thumb_url}}">  
                                            @else
                                               N/A 
                                            @endif  
                                    </span>
                                </div>
                            </div>
                            <!-- row repeat -->
                        </div>
    
    
    
                        <!-- Buttons -->
                        <div class="btn-space text-center">
                                <a href="{{route('admin.category.index')}}"><button class="green-fill-btn green-border-btn mr10 ">Back</button></a>
                            <a href="{{route('admin.category.edit',['id'=>$data->encrypt_id])}}">  <button class="green-fill-btn">Edit</button></a>
                        </div>
                        <!-- Buttons -->
                    </div>
                    <!-- product details end-->
    
                </div>
        </div>
    </div>
   
@endsection