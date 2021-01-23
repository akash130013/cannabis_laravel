

 
{{-- <aside class="sidebar-menu">
            <div class="sidebar-menu-inner">
                <div class="user-short-detail">
					<figure>
						<a href="javascript:void(0)">
                            <img src="{{ asset('asset-admin/images/cannabis_leaf1.svg')}}" alt="User Thumb">
                        </a>
					</figure>
                    <span class="logged-user">Admin</span>
                </div>
                
                <div class="vertical-nav">
                    <ul>
                        <li class="has-sub-menu">
                            <a href="javascript:void(0)" class="">
                                <span class="dashboard-icon comn-icon"></span>
                                <span class="nav-txt">Dashboard</span>
                            </a>
                        </li>
                        <li class="has-sub-menu">
                                <a href="{{route('admin.user.index')}}" class="@if(in_array(Request::route()->getName(),['admin.user.index','admin.user.show'])) active @endif">
                                <span class="category-icon comn-icon"></span>
                                <span class="nav-txt">User</span>
                            </a>
                        </li> 
                        <li class="has-sub-menu">
                            <a href="{{route('admin.notification.index')}}" class="@if(in_array(Request::route()->getName(),['admin.notification.index','admin.notification.show','admin.notification.add'])) active @endif">
                            <span class="category-icon comn-icon"></span>
                            <span class="nav-txt">Notification</span>
                            </a>
                        </li> 
                        <li class="has-sub-menu">
                            <a href="{{route('admin.distributor.index')}}" class="@if(in_array(Request::route()->getName(),['admin.distributor.index','admin.distributor.show'])) active @endif">
                            <span class="category-icon comn-icon"></span>
                            <span class="nav-txt">Driver Management</span>
                            </a>
                        </li> 
                        <li class="has-sub-menu">
                            <a href="{{route('admin.category.index')}}" class="@if(in_array(Request::route()->getName(),['admin.category.index','admin.category.create','admin.category.edit','admin.category.show'])) active @endif">
                            <span class="category-icon comn-icon"></span>
                            <span class="nav-txt">Category</span>
                            </a>
                        </li> 
                        <li class="has-sub-menu">
                                <a href="{{route('admin.product.listing')}}" class="@if(in_array(Request::route()->getName(),['admin.product.edit','admin.dashboard','admin.show.add.product','admin.product.listing','product.show','admin.product.request','admin.product.request.edit','admin.product.rating'])) active @endif">
                                  <span class="product-icon comn-icon"></span>
                                  <span class="nav-txt">Product</span>
                              </a>
                        </li>
                        <li class="has-sub-menu">
                            <a href="{{route('admin.promocode.index')}}" class="@if(in_array(Request::route()->getName(),['admin.promocode.index','admin.promocode.show','admin.promocode.create'])) active @endif">
                              <span class="product-icon comn-icon"></span>
                              <span class="nav-txt">Promocodes</span>
                          </a>
                        </li>
                        <li class="has-sub-menu">
                            <a href="/admin/order?orderType=pending" class="@if(in_array(Request::route()->getName(),['admin.order.index','admin.order.show'])) active @endif">
                                <span class="product-icon comn-icon"></span>
                                <span class="nav-txt">Orders</span>
                            </a>
                        </li>
                        <li class="has-sub-menu">
                            <a href="{{route('admin.store.index')}}" class="@if(in_array(Request::route()->getName(),['admin.store.index','admin.store.request','admin.store.show','admin.store.open.settlement'])) active @endif">
                              <span class="product-icon comn-icon"></span>
                              <span class="nav-txt">Store & Settlement</span>
                          </a> 
                        </li>
                        
                          

                          <li class="has-sub-menu">
                                <a href="{{route('admin.show.import')}}" class="@if(in_array(Request::route()->getName(),['admin.show.import','admin.edit.delivery.address'])) active @endif">
                                  <span class="product-icon comn-icon"></span>
                                  <span class="nav-txt">Add Delivery</span>
                              </a>
                          </li>
                          <li class="has-sub-menu">
                            <a href="{{route('admin.cms.index')}}" class="@if(in_array(Request::route()->getName(),['admin.cms.index','admin.cms.edit'])) active @endif">
                              <span class="product-icon comn-icon"></span>
                              <span class="nav-txt">CMS</span>
                          </a>
                      </li>
                          

                    </ul>
                </div>
            </div>
        </aside> --}}






        <aside class="mySidebar">
                <div class="left-section">
                    <!-- User Section Start -->
                    <div class="user-profile">
                        <!-- <figure>
                            {{-- <img src="{{ Auth::guard('admin')->user()->avatar ?? config('constants.DEAFULT_IMAGE.PROFILE') }}" alt="userImage" class="user-img"> --}}
                        </figure> -->
                        <!-- <div class="username">
                            @if(Auth::guard('admin')->user())
                            <p> {{ Auth::guard('admin')->user()->name }}</p>
                            @endif
                            {{-- <p>Super Admin</p> --}}
                        </div> -->
                    </div>
                    <!-- User Section End -->
                      <!-- nav side bar Start -->
                      <nav>
                            <ul>
                                <li class="@if(in_array(Request::route()->getName(),['admin.dashboard'])) active @endif">
                                    <a href="{{route('admin.dashboard')}}" title="Dashboard">
                                        <span class="dashboard-icon"></span>
                                        <label class="nav-txt">Dashboard</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.user.index','admin.user.show'])) active @endif">
                                    <a href="{{route('admin.user.index')}}" title="User Management">
                                        <span class="user-icon"></span>
                                        <label class="nav-txt">User Management</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.store.index','admin.store.request','admin.store.show','admin.store.open.settlement'])) active @endif">
                                    <a href="{{route('admin.store.index')}}" title="Stores &amp; Settlement">
                                        <span class="store-icon"></span>
                                        <label class="nav-txt">Stores &amp; Settlement</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.distributor.index','admin.distributor.show'])) active @endif">
                                    <a href="{{route('admin.distributor.index')}}" title="Drivers Management">
                                        <span class="driver-icon"></span>
                                        <label class="nav-txt">Drivers Management</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.show.import','admin.edit.delivery.address'])) active @endif">
                                    <a href="{{route('admin.show.import')}}"  title="Location Management">
                                        <span class="location-icon"></span>
                                        <label class="nav-txt">Location Management</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.category.index','admin.category.create','admin.category.edit','admin.category.show'])) active @endif">
                                    <a href="{{route('admin.category.index')}}"  title="Categories">
                                        <span class="category-icon"></span>
                                        <label class="nav-txt">Category Management</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.product.edit','admin.show.add.product','admin.product.listing','product.show','admin.product.request','admin.product.request.edit','admin.product.rating'])) active @endif">
                                    <a href="{{route('admin.product.listing')}}"  title="Products">
                                        <span class="product-icon"></span>
                                        <label class="nav-txt">Product Management</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.promocode.index','admin.promocode.show','admin.promocode.create'])) active @endif">
                                    <a href="{{route('admin.promocode.index')}}"  title="Promocodes">
                                        <span class="promocode-icon"></span>
                                        <label class="nav-txt">Promocodes</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.order.index','admin.order.show'])) active @endif">
                                    <a href="{{route('admin.order.index',['orderType'=>'pending'])}}" title="Orders Management">
                                        <span class="order-icon"></span>
                                        <label class="nav-txt">Orders Management</label>
                                    </a>
                                </li>
                                <li  class="@if(in_array(Request::route()->getName(),['admin.notification.index','admin.notification.show','admin.notification.add'])) active @endif">
                                    <a href="{{route('admin.notification.index')}}" title="Notifications">
                                        <span class="notify-icon"></span>
                                        <label class="nav-txt">Notification Management</label>
                                    </a>
                                </li>
                                
                                <li class="@if(in_array(Request::route()->getName(),['admin.cms.index','admin.cms.edit'])) active @endif">
                                    <a href="{{route('admin.cms.index')}}"  title="C.M.S.">
                                        <span class="cms-icon"></span>
                                        <label class="nav-txt">CMS Management</label>
                                    </a>
                                </li>
                                <li class="@if(in_array(Request::route()->getName(),['admin.contact.index'])) active @endif">
                                    <a href="{{route('admin.contact.index')}}"  title="Contact">
                                        <span class="phone-icon"></span>
                                        <label class="nav-txt">Contact Management</label>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- nav side bar End -->
                </div>
            </aside>