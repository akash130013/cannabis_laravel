@extends('Store::layouts.master')
@section('content')
<style>
   .txt_description {padding-left: 40px;color: #949298}
   .notification-title a { color: #0a0a0a; }
</style>
<!-- pase your code here -->
<div class=" custom_container">
   @include('Store::layouts.pending-alert')
   <div class="white_wrapper">
      <div class="notifications">
         <h2 class="title-heading">Notifications</h2>
         <div class="notification-list">
            <ul class="container-infinte">
               @if(count($notifications)>0)
               @foreach($notifications as $val)
               <li class="notification-bell">
                  <p class="notification-title">
                     @if($val->payload['order_type'] == \App\Enums\StoreNotificationType::OrderTypePending)
                     <a href="{{route('store.order.list',['type'=>$val->payload['order_type']])}}">{{$val->title}}</a>
                     @else
                     <a href="{{route('store.order.list',['type'=>$val->payload['order_type'], 'keyword' => $val->payload['order_uid']])}}">{{$val->title}}</a>
                     @endif
                  </p>
                  <span>{{ $val->created_at->diffForHumans()}}</span>
                  <div class="txt_description">{{ $val->description }}</div>
               </li>
               @endforeach
               @else
               <div class="custom_container">
                  <p class="commn_para text-center">No Notification found </p>
               </div>
               @endif
            </ul>
         </div>
      </div>
   </div>
</div>
<!-- hidden field for scrolling next page -->
<input type="hidden" class="pagination__next" href="{{$notifications->nextPageUrl()}}">
@push('script')
<script src="{{asset('asset-store/js/infinite.scroll.min.js')}}"></script>
<script>
   $('.container-infinte').infiniteScroll({
       // options
       path: '.pagination__next',
       append: '.notification-bell',
       history: false,
   });
</script>
@endpush
@endsection