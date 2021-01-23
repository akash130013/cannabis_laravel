@extends('Store::layouts.master')


@section('content')
 <!-- Header End -->
        <!-- Internal Container -->
        <span class="profile-menu">
            <img src="/asset-store/images/menu-line.svg" alt="profile menu">
        </span>
      <div class="full_custom_container profile-view">
                  @include('Store::layouts.pending-alert')
            <div class="wrap-row-full">
                  
             @include('Store::profile.profile-sidebar')
                  <!--Profile Detail Col-->
                  <div class="right-col-space change-password">
                        <div class="white_wrapper">
                              <div class="col-space">
                                    {!!$data->slug!!}
                              </div>
                        </div>
                        <div class="col-space">
                              {!!$data->content!!}
                        </div>
                  </div>
                  <!--Profile Detail Col-->
            </div>
      
      </div>
@endsection