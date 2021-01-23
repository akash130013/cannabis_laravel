@extends('User::dashboard.layout')
@include('User::dashboard.innertab')

@section('content')
<div class="internal-container product">
        @yield('inner-tab')
        <div class="explore-products">
            <!-- Form Container -->
            <div class="form-container">
                <div class="container">
                    <div class="explore-wrapper">
                        <h4>Explore 420 Kingdom</h4>
                        <div class="exploreWrapList exploreCategory slider multiple-items">
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-1.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Flower</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-2.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Edibles</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-3.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Pre-Rolls</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-4.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Vape</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-5.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Concentrates</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-6.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Cartridge</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-1.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Flower</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-2.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Edibles</p>
                                </div>
                            </div>
                            <div>
                                <div class="list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/cat-3.png')}}" alt="Explore Category">
                                    </figure>
                                    <p>Pre-Rolls</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Trending Products start -->
                    <div class="explore-wrapper">
                        <div class="d-flex justify-content-between">
                            <h4 class="m0">Trending Products</h4>
                            <p class="m0 view-txt">View More
                                <img src="{{asset('asset-user/images/explore/arrow-right.svg')}}" alt="Right Arrow" />
                            </p>
                        </div>
                        <div class="exploreWrapList exploreTrending slider  multiple-items">
                            <div>
                                <div class="product-list active list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/product-1.png')}}" alt="Product Category"/>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="ct-whislist">
                                            <path fill="none" d="M0 0h24v24H0z"/>
                                            <path d="M21.179 12.794l.013.014L12 22l-9.192-9.192.013-.014A6.5 6.5 0 0 1 12 3.64a6.5 6.5 0 0 1 9.179 9.154z" />
                                        </svg>
                                        <!-- <img src="{{asset('asset-user/images/explore/heart-fill.svg')}}" alt="wishlist icon" class="wishlist-icon"/> -->
                                    </figure>
                                    <div class="product-detail">
                                        <div class="d-flex justify-content-between">
                                            <p class="product-name">Floracal Rose</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap rate-bg">
                                                    <img src="{{asset('asset-user/images/explore/rate-icon.png')}}" alt="Rating Icon">
                                                    <span class="fwsb">4.5</span>
                                                </div>
                                                <div>
                                                    <span class="fwm">36</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="fwm product-brand">Pure Kush | Flower</p>
                                        <p class="fwb product-price">$345 - $440</p>
                                    </div>
                                    <div class="vendor-details">
                                        <div class="d-flex align-items-center">
                                            <div class="logo d-flex align-items-center">
                                                <img src="{{asset('asset-user/images/explore/logo-1.png')}}" />
                                            </div>
                                            <p class="fwm vendor-name">By Clear Naturals</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="product-list list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/product-1.png')}}" alt="Product Category"/>
                                        <img src="{{asset('asset-user/images/explore/heart-fill.svg')}}" alt="wishlist icon" class="wishlist-icon"/>
                                    </figure>
                                    <div class="product-detail">
                                        <div class="d-flex justify-content-between">
                                            <p class="product-name">Floracal Rose</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap rate-bg">
                                                    <img src="{{asset('asset-user/images/explore/rate-icon.png')}}" alt="Rating Icon">
                                                    <span class="fwsb">4.5</span>
                                                </div>
                                                <div>
                                                    <span class="fwm">36</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="fwm product-brand">Pure Kush | Flower</p>
                                        <p class="fwb product-price">$345 - $440</p>
                                    </div>
                                    <div class="vendor-details">
                                        <div class="d-flex align-items-center">
                                            <div class="logo d-flex align-items-center">
                                                <img src="{{asset('asset-user/images/explore/logo-1.png')}}" />
                                            </div>
                                            <p class="fwm vendor-name">By Clear Naturals</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="product-list list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/product-1.png')}}" alt="Product Category"/>
                                        <img src="{{asset('asset-user/images/explore/heart-fill.svg')}}" alt="wishlist icon" class="wishlist-icon"/>
                                    </figure>
                                    <div class="product-detail">
                                        <div class="d-flex justify-content-between">
                                            <p class="product-name">Floracal Rose</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap rate-bg">
                                                    <img src="{{asset('asset-user/images/explore/rate-icon.png')}}" alt="Rating Icon">
                                                    <span class="fwsb">4.5</span>
                                                </div>
                                                <div>
                                                    <span class="fwm">36</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="fwm product-brand">Pure Kush | Flower</p>
                                        <p class="fwb product-price">$345 - $440</p>
                                    </div>
                                    <div class="vendor-details">
                                        <div class="d-flex align-items-center">
                                            <div class="logo d-flex align-items-center">
                                                <img src="{{asset('asset-user/images/explore/logo-1.png')}}" />
                                            </div>
                                            <p class="fwm vendor-name">By Clear Naturals</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="product-list list">
                                    <figure>
                                        <img src="{{asset('asset-user/images/explore/product-1.png')}}" alt="Product Category"/>
                                        <img src="{{asset('asset-user/images/explore/heart-fill.svg')}}" alt="wishlist icon" class="wishlist-icon"/>
                                    </figure>
                                    <div class="product-detail">
                                        <div class="d-flex justify-content-between">
                                            <p class="product-name">Floracal Rose</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap rate-bg">
                                                    <img src="{{asset('asset-user/images/explore/rate-icon.png')}}" alt="Rating Icon">
                                                    <span class="fwsb">4.5</span>
                                                </div>
                                                <div>
                                                    <span class="fwm">36</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="fwm product-brand">Pure Kush | Flower</p>
                                        <p class="fwb product-price">$345 - $440</p>
                                    </div>
                                    <div class="vendor-details">
                                        <div class="d-flex align-items-center">
                                            <div class="logo d-flex align-items-center">
                                                <img src="{{asset('asset-user/images/explore/logo-1.png')}}" />
                                            </div>
                                            <p class="fwm vendor-name">By Clear Naturals</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Trending Products end -->
                </div>
            </div>
            <!-- Form Container End -->
        </div>
    </div>


@section('pagescript')


@endsection


@endsection