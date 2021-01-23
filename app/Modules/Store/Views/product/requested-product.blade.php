@extends("Store::layouts.master")
@section('content')
<!-- Header End -->

<form action="{{route('store.product.dashboard')}}" method="GET" id="formFilterId" name="filterName">

<div class="custom_container">
   <div class="tab_wrapper_seprate">
         <!-- menu-->
         <div class="head-nav tab_wrapper">
            <ul>
            <li><a href="{{route('store.product.dashboard')}}">Products</a></li>
               <li><a href="javascript:void(0)" class="active">Requested Products</a></li>
            </ul>
         </div>
         <!-- menu close-->
      </div>
</div>

   <div class="requested_product">
      @include('Store::layouts.pending-alert')
      <div class="wrap-row-full">
       
         <div class="custom_container">
            <div class="white_wrapper">
               <div class="flex-row flex-flow-mob align-items-center">
                  
                  <div class="flex-col-sm-4 flex-col-xs-6">
                     <h2 class="title-heading">Requested Products</h2>
                  </div>
                  
               </div>
            </div>
            <div class="white_wrapper">
               <div class="table-responsive">
                  <table id="example" class="list-table table table-striped table-bordered" cellspacing="0"
                     width="100%">
                     <thead>
                        <tr>
                           <th>S.No.</th>
                           
                           <th>Product Name</th>
                           <th>Category</th>
                           <th>THC%</th>
                           <th>CBD%</th>
                           <th>Created At</th>
                           <th>Status</th>
                           <th>Description</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i=$pageinate['from'];
                        $j=0;
                        @endphp
                        @forelse($data as $row)
                          
                        <tr>
                           <td>{{$i++}}</td>
                           <td>
                            <span class="td-text-wrap">{{$row->product_name ?? 'N/A'}}</span>
                           </td>
                           <td>
                            <span class="td-text-wrap">{{$row->category->category_name ?? 'N/A'}}</span>                                    
                           </td>
                           <td>{{$row->thc ?? 'N/A'}}</td>
                           <td>{{$row->cbd ?? 'N/A'}}</td>
                         
                           <td>{{\App\Helpers\CommonHelper::convertFormat($row->created_at,'Y/m/d') ?? 'N/A'}}</td>
                           <td>
                              @if($row->status == config('constants.STATUS.PENDING'))
                                <span class="td-alert">Pending</span>
                              @else
                                 <span class="td-success">{{ ucfirst($row->status) }}</span>
                              @endif
                           </td>
                           
                           <td class="user_info">
                              <span class="info_icon">
                              <img src="{{asset('asset-store/images/info.svg')}}">
                              </span>
                              <div class="user_info_window product_desc">
                                 <div class="inner_wrap">
                                  
                                    <div class="add_info">
                                       <span class="title">Additional Information</span>
                                       <p>{{$row->product_desc ?? 'N/A'}}</p>
                                    </div>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        @php  $j=$j+1  @endphp
                        @empty
                        <td colspan="8">No Product Found</td>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
            <!--Pagenation-->
            <div class="flex-row">
               <div class="flex-col-sm-12 text-center">
                  <div class="pagenation">
                     @if(!empty($data))
                     {{$data->links()}}
                     @endif
                  </div>
               </div>
            </div>
            <!--Pagenation Close-->
         </div>
      </div>
   </div>
   <input type="hidden" name="status" value="{{isset($query['status']) ? $query['status']:1}}" id="status">
   
</form>
<input type="hidden" id="url" value="{{route('store.list.status')}}">
<input type="hidden" id="pageUrl" value="{{route('store.product.dashboard')}}">
@push('script')
<script src="{{asset('asset-store/js/commonFunction.js')}}"></script>
<script src="{{asset('asset-store/js/Easy-jQuery-Client-side-List-Filtering-Plugin-list-search/js/list-search-min.js')}}"></script>
<script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
<script src="{{asset('asset-store/js/product.js')}}"></script>
<script src="{{asset('asset-store/js/request.js')}}"></script>
<script>
   $('.ui.search')
       .search({
           type: 'category',
           apiSettings: {
               url: "{{secure_url(route('store.product.list.search'))}}"+'?q={query}',
               onResponse: function (Response) {
                   
                   var
                       response = {
                           results: {}
                       }
                   ;
                   // translate GitHub API response to work with search
   
                   $.each(Response, function (index, item) {
   
                       if (typeof item.category != "undefined") {
   
                           var
                               language = item.category || 'Unknown';
                           maxResults = 30
                           ;
                           if (index >= maxResults) {
                               return false;
                           }
                           // create new language category
                           if (response.results[language] === undefined) {
                               response.results[language] = {
                                   name: language,
                                   results: []
                               };
                           }
                           // add result to category
   
                           response.results[language].results.push({
                               title: item.title,
                           });
   
   
                       }
   
                   });
   
   
                   return response;
               }
           },
           onSelect: function (result, response) {
              
               $("#searchElementProduct").val(result.title);
               $("#formFilterId").submit();
           }
       });
   
   
   $('body').on('keyup', '#search-box', function () {
   
       var searchString = $(this).val();
       var eleID = $(this).attr('data-id');
   
       $("#" + eleID + " li").each(function (index, value) {
           currentName = $(value).text()
           if (currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
               $(value).show();
           } else {
               $(value).hide();
           }
   
       });
   
   
   });
   
   
</script>
@endpush
@endsection