@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')


@section('content')

@yield('nav-bar')
      <!--section list filter-->
      <section class="inner_centerpanel">
         <div class="custom_container">
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-6 flex-col-xs-6">
                  <h2 class="title-heading m-t-b-30">Loyalty Points</h2>
               </div>
            </div>
            <div class="account_wrapper">
               <div class="points_wrapper">
                  <div class="flex-row">
                     <div class="flex-col-sm-8 flex-col-xs-8">
                        <p class="txt_common">Loyalty Points</p>
                        <h2 class="txt_points">{{empty($loyaltyList['response']['data']['data']) ? '0.00' : number_format($loyaltyList['response']['data']['data'][0]['net_amount'],2)}} points</h2>
                        <p class="txt_invite">Invite your friends to earn credits. For every registration through your
                           referral code you
                           will be receiving 1 credits. </p>
                     </div>
                     <div class="flex-col-sm-4 flex-col-xs-4 points_right_wrapper">
                        <p class="txt_common">Referral Code</p>
                     <p class="txt_ref_code">{{Auth::guard("users")->user()->user_referral_code ?? 'N/A'}}</p>
                        <div class="share_wrapper">
                           <p class="txt_common">Share via</p>
                           {{-- <div class="sharethis-inline-share-buttons"></div> --}}
                           <a href="javascrpit:void(0)" class="share_link" data-toggle="modal" data-target="#share_it"><span class="share"></span></a>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-6 flex-col-xs-6">
                  <a href="javascript:void(0)" id="points_info">
                     <h2 class="title-heading m-t-b-30 info_icon">Loyalty Points History</h2>
                  </a>
               </div>
            </div>
            <div class="account_wrapper">
               <div class="white_wrapper points_history">
                  <div class="title_wrapper">
                     <p class="txt_title">Activity</p>
                     <span class="txt_title added_points">Points Added</span>
                  </div>
                  <ul id="scroller">

                        @if(!empty($loyaltyList['response']['data']['data']))
                        @foreach ($loyaltyList['response']['data']['data'] as $item)
                             <li class="item">
                             <p>{{$item['reason'] ?? 'N/A'}}</p>

                             @if($item['operation']=='credit')
                             <span class="plus_points">
                                    +  {{$item['operated_amount'] ?? '0'}}
                             </span>
                             @endif

                             @if($item['operation']=='debit')
                             <span class="minus_points">
                              -  {{$item['operated_amount'] ?? '0'}}
                           </span>
                              @endif

                             </li>
                       @endforeach

                       <div class="scroller-status">
                           <div class="infinite-scroll-request loader-ellips">
                      </div>
                        <p class="infinite-scroll-last"></p>
                        <p class="infinite-scroll-error"></p>

                       @endif


                        <div class="pagination">
                              @if(!empty($loyaltyList['response']['data']['nextPage']))
                                 <a href="{{route('user.loyality-point.listing').'?page='.$loyaltyList['response']['data']['nextPage']}}" class="next"></a>
                              @endif
                        </div>

                  </ul>

               </div>
            </div>
         </div>
      </section>
      <!--section list filter close-->
      <!--footer-->

   <!-- Points Information Start -->

   <div class="order-detail-sidebar points_info_sidebar">
      <div class="inner_wrap">
         <div class="detail-sidebar">
            <div class="sidebar-header">
               <div class="wrapper">
                  <span>
                     <img src="{{asset('asset-user-web/images/close-line.svg')}}" alt="close" />
                  </span>
                  <label>Loyalty Points Information</label>
               </div>
            </div>
            <div class="title_wrapper info_title">
               <p class="txt_title">Loyalty Point</p>
               <span class="txt_title">Price</span>
            </div>
         </div>
         <hr>

         <div class="detail-sidebar">
            <ul>
                  @if(!empty($loyaltyPoint['response']['data']['data']))
                  @foreach ($loyaltyPoint['response']['data']['data'] as $item)
                      <li>
                      <p>{{$item['exchange_package'] ?? 'N/A'}}</p>
                      <span class="txt_price">{{$item['exchange_rate'] ?? 0}} .00</span>
                      </li>
                @endforeach
                @else
                <li>
                     <p>No Point found</p>
                     <span class="txt_price">$0.00</span>
                     </li>
                @endif
            </ul>
         </div>

         <!-- order-detail sidebar -->
      </div>
   </div>

   <div class="modal fade logout" id="share_it" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="login_form">
               <div class="modal-header">
                  <h4 class="modal-title">Share</h4>

                  <button type="button" class="close modal-close" data-dismiss="modal">
                  <img src="https://cannabisdev.appskeeper.com/asset-store/images/close-card.svg"></button>
               </div>

               <div class="modal-body">
                  <div class="modal-padding">
                  <div class="text-field-wrapper mob_location_srch">
                     <input type="text"  id="url" value="{{Auth::guard("users")->user()->user_referral_code ?? 'N/A'}}" readonly>
                       <span class="detect-icon" id="copy-text" data-id="url"><i class="fa fa-clone"></i></span>
                  </div>
                
                     <div class="product_share m-t-30">
                        <ul>


                           <li>
                                 {{-- <a href="'https://www.facebook.com/sharer/sharer.php?u='+pageFullUrl+ '&title='+ pageTitle" target="_blank"><img src="http://i.stack.imgur.com/rffGp.png" /></a> --}}
                                 <a href="http://www.facebook.com/sharer/sharer.php?u={{url('/').'&query='.Auth::guard("users")->user()->user_referral_code ?? ''}}" target="_blank">
                                 {{-- <a href="https://www.facebook.com/sharer/sharer.php?u={{Auth::guard("users")->user()->user_referral_code ?? 'N/A'}}" target="_blank" class="underDev"> --}}
                                    <img src="{{asset('asset-user-web/images/facebook-fill.svg')}}">
                                 </a>
                              </li>


                              <li>
                                 <a href="https://twitter.com/intent/tweet?text=Hi, This is my cannabis referal code {{Auth::guard("users")->user()->user_referral_code ?? 'N/A'}}" target="_blank">
                                    <img src="{{asset('asset-user-web/images/twitter-fill.svg')}}">
                                 </a>
                              </li>
                        </ul>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>






   <!-- Points Information Start -->
   <input type="hidden" name="search_type" value="1">

   @endsection

   @section('pagescript')
   <script src="{{asset('asset-user/js/loyalty-point.js')}}"></script>
   <script>
      $(document).ready(function () {
         $("#points_info").click(function (e) {
            e.stopPropagation();
            $(".order-detail-sidebar").addClass("active");
            $("body").css({ overflow: "hidden" });
         });

         $(".wrapper img").click(function () {
            $(".order-detail-sidebar").removeClass("active");
            $("body").css({ overflow: "auto" });
         });
             $("body").click(function (event) {

                 if (!$(event.target).is(".order-detail-sidebar , .order-detail-sidebar *")) {

                $(".order-detail-sidebar").removeClass("active");
                $("body").css({ overflow: "auto" });}
             });
      });


$(document).on('click', '#copy-text', function () {
    let id = $(this).data('id');
    copyText(id);
})





function copyText(id) {
    /* Get the text field */
    var copyText = document.getElementById(id);

    /* Select the text field */
    copyText.select();

    /* Copy the text inside the text field */
    document.execCommand("copy");
    swal({
        text: localMsg.link_copied,
        button: localMsg.ok,
    }).then(() => {
        $('.loader').css('display', 'flex')
        window.location.reload();
    })

}


$("body").click(function (event) {

   if (!$(event.target).is(".order-detail-sidebar , .order-detail-sidebar *")) {

      $(".order-detail-sidebar").removeClass("active");
      $("body").css({ overflow: "auto" });}
   });
   </script>

   @endsection
