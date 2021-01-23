@extends("Store::product.layout")
@include('Store::product.inner-header')
@include('Store::product.navigationbar')
@section('content')
<!-- Header End -->
<!-- Internal Container -->
@yield('inner-header')
<div class="internal-container product">
   @yield('nav-bar')
   <div class="cb-tabsBody">
      <div class="tab-content">
         <div id="locations" class="container-fluid tab-pane fade p0">
            <div class="locationWrapper">
               <div class="leftSegment">
                  <figure>
                     <img src="assets/images/location-map.jpg" alt=" Location">
                  </figure>
                  <div class="locationsearchWrapper">
                     <div class="form-group">
                        <input type="text" placeholder="Search by Area" class="locationSearch">
                        <button class="btn custom-btn green-fill getstarted">Add Area</button>
                     </div>
                  </div>
               </div>
               <div class="rightSegment">
                  <div class="hdrArea">
                     <div class="searchBarArea">
                        <input type="text" class="inpt_prdct" placeholder="Search by added areas name">
                        <img src="assets/images/search.svg" alt="search">
                     </div>
                     <div class="rightsortArea">
                        <p>Sort by</p>
                        <select>
                           <option>All Areas</option>
                           <option>Active Areas</option>
                           <option>In-Active Areas</option>
                        </select>
                        <img src="assets/images/droparrow.svg" alt="search">
                     </div>
                  </div>
                  <div class="productListBodyWrapper loationArea">
                     <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0">
                           <tr>
                              <th align="center">S.No.</th>
                              <th>Area</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                           <tr>
                              <td>1</td>
                              <td>University City, San Diego, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>2</td>
                              <td>Muirlands, La Jolla, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>3</td>
                              <td>Upper Hermosa, San Diego, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>4</td>
                              <td>La Jolla Hermosa, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>5</td>
                              <td>Stanislaus National Forest, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>6</td>
                              <td>North Clairemont, San Diego, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>7</td>
                              <td>Clairemont, San Diego, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>8</td>
                              <td>Clairemont Mesa West, San Diego, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>9</td>
                              <td>Kearny Mesa, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                           <tr>
                              <td>10</td>
                              <td>Serra Mesa, California, USA</td>
                              <td>Active</td>
                              <td>
                                 <img src="assets/images/delete.svg" alt="delete">
                              </td>
                           </tr>
                        </table>
                     </div>
                     <div class="pagination">
                        <h6>Display 1 of 10</h6>
                        <div class="paginationWrapper">
                           <div class="previous">
                              <img src="assets/images/arrow-left.svg" alt="Left Arrow"> Prev
                           </div>
                           <div class="paginationBullet">
                              <div class="bullet active">1</div>
                              <div class="bullet">2</div>
                              <div class="bullet">3</div>
                              ... 10
                           </div>
                           <div class="next">
                              Next <img src="assets/images/arrow-right.svg" alt="Right Arrow">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="drivers" class="container-fluid tab-pane fade">
            <br>
            <h3>Menu 1</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
         </div>
         <div id="products" class="container-fluid tab-pane active">
            <!-- Form Container -->
            <!-- <div class="form-container"> -->
            <div class="noproductBar">
               <div class="form-container">
                  <div class="product-header">
                     <h2>Products</h2>
                  </div>
                  <div class="product-body">
                     <div class="noprdct-screen">
                        <img src="assets/images/Empty-Product.svg" alt="No Product">
                        <h3>Oops! It’s Empty</h3>
                        <p>Seems like you haven’t added any products.Tap on add button to add your products.</p>
                        <div class="btn-group">
                           <button class="btn custom-btn green-fill getstarted addProduct" data-datac="1">Add Product</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="addnewproduct-screen prdctHeight">
               <div class="form-container">
                  <div class="product-header">
                     <h2>Add New Product</h2>
                     <div class="counter"><span>1</span>/3</div>
                     <div class="progressBorder"></div>
                     <div class="step step1"></div>
                  </div>
                  <div class="addPrdctForm">
                     <figure class="tree-des"><img src="assets/images/sig-tree.png" alt=""></figure>
                     <div class="frm-sec-ins">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="form-group">
                                 <input type="text" class="form-control pl-210 searchproduct" placeholder="Search the product you wish to add">
                                 <img src="{{asset('asset-admin/images/cross.svg')}}" alt="cross" class="cross">
                                 <div class="selectpanel">
                                    <select onchange="this.className=this.options[this.selectedIndex].className" class="selectedIndex">
                                       <option value="all"  class="selectedIndex">All Categories</option>
                                       <option value="category1"  class="selectedIndex">Category 1</option>
                                       <option value="category2"  class="selectedIndex">Category 2</option>
                                       <option value="category3"  class="selectedIndex">Category 3</option>
                                       <option value="category4"  class="selectedIndex">Category 4</option>
                                    </select>
                                    <img src="assets/images/droparrow1.svg" class="dropmenu" alt="drop down menu">
                                 </div>
                              </div>
                              <div class="btn-group">
                                 <button class="btn custom-btn green-fill getstarted addProduct_next" data-datac="1">Next</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="addnewproduct-screen-second prdctHeight">
               <div class="form-container">
                  <div class="product-header">
                     <h2>Add New Product</h2>
                     <div class="counter"><span>2</span>/3</div>
                     <div class="progressBorder"></div>
                     <div class="step step2"></div>
                  </div>
                  <div class="addPrdctForm">
                     <figure class="tree-des"><img src="assets/images/sig-tree.png" alt=""></figure>
                     <div class="frm-sec-ins">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="form-group">
                                 <input type="number" class="form-control pl-210 searchproduct1" placeholder="Enter actual price (in $)">
                                 <input type="number" class="form-control quantity" placeholder="Enter quantity">
                                 <img src="{{asset('asset-admin/images/cross.svg')}}" alt="cross" class="cross">
                                 <img src="assets/images/delete.svg" alt="delete" class="prdctdelete">
                                 <div class="selectpanel">
                                    <select onchange="this.className=this.options[this.selectedIndex].className" class="selectedIndex">
                                       <option value="all"  class="selectedIndex">Quantity</option>
                                       <option value="category1"  class="selectedIndex">Quantity 1</option>
                                       <option value="category2"  class="selectedIndex">Quantity 2</option>
                                       <option value="category3"  class="selectedIndex">Quantity 3</option>
                                       <option value="category4"  class="selectedIndex">Quantity 4</option>
                                    </select>
                                    <img src="assets/images/droparrow1.svg" class="dropmenu" alt="drop down menu">
                                 </div>
                              </div>
                              <p class="add_more">Add More</p>
                              <div class="btn-group">
                                 <button class="btn custom-btn trans-fill getstarted backbtn" data-databackc="1">Back</button>
                                 <button class="btn custom-btn green-fill getstarted addProduct_step2" data-datac="2">View</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="addnewproduct-screen-third prdctHeight">
               <div class="form-container">
                  <div class="product-header">
                     <h2>Product Preview</h2>
                     <div class="counter"><span>3</span>/3</div>
                     <div class="progressBorder"></div>
                     <div class="step step3"></div>
                  </div>
                  <div class="addPrdctForm">
                     <div class="productPreview">
                        <div class="row">
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <div class="prdctHeader">
                                 <h3>Afghani Hawaiian Strain</h3>
                                 <h6>Hybrid</h6>
                                 <p>THC: 21% CBD: 6%</p>
                              </div>
                              <div class="prdctDesp">
                                 <h5>Quantity & Price</h5>
                                 <div class="prdctQuantity">
                                    <div class="product">
                                       <div class="pd-brdr">
                                          <span>2g</span>
                                       </div>
                                       <p>$100.20 (50 pac.)</p>
                                    </div>
                                    <div class="product">
                                       <div class="pd-brdr">
                                          <span>10g</span>
                                       </div>
                                       <p>$100.20 (50 pac.)</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="additionInfo">
                                 <h5>Additional Description</h5>
                                 <div class="form-group">
                                    <textarea cols="30" class="add_description" rows="5" maxlength="500" placeholder="Write here..."></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-4 col-xs-12">
                              <figure class="producttView">
                                 <img src="assets/images/product.jpg" alt="product">
                              </figure>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="btn-group preview">
                                 <button class="btn custom-btn trans-fill getstarted backbtn" data-databackc="2">Back</button>
                                 <button class="btn custom-btn green-fill getstarted finish" data-datac="3">Finish</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- </div> -->
            <!-- Form Container End -->
            <div class="prdctListWrapper">
               <div class="listnotification">
                  <p><img src="assets/images/info - white.svg" alt="Info"> Pending Verification !!. Your store will be visible to the customers once your account is verified</p>
                  <a class="remindlater" href="javascript:void(0)">
                  Remind Me Later
                  </a>
               </div>
               <div class="filterSection">
                  <h4>Filters</h4>
                  <div class="availability">
                     <h6>Availability</h6>
                     <div class="form-group">
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="stock" id="stock" value="1">
                           <label for="stock">Out of Stock <span> (20)</span></label>
                        </div>
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="instock" id="instock" value="1">
                           <label for="instock">In stock <span> (20)</span></label>
                        </div>
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="inactive" id="inactive" value="1">
                           <label for="inactive">In Active <span> (20)</span></label>
                        </div>
                     </div>
                  </div>
                  <div class="availability">
                     <h6>Product Category</h6>
                     <div class="searchMenu">
                        <img src="assets/images/search.svg" alt="search menu">
                     </div>
                     <div class="form-group search">
                        <input type="text" placeholder="Search by category">
                        <img src="{{asset('asset-admin/images/cross.svg')}}" alt="cross">
                     </div>
                     <div class="form-group">
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="concentrate" id="concentrate" value="1">
                           <label for="concentrate">concentrate <span> (20)</span></label>
                        </div>
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="ediblesk" id="ediblesk" value="1">
                           <label for="ediblesk">Ediblesk <span> (20)</span></label>
                        </div>
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="flowers" id="flowers" value="1">
                           <label for="flowers">Flowers <span> (20)</span></label>
                        </div>
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="prerolls" id="prerolls" value="1">
                           <label for="prerolls">Pre-Rolls <span> (20)</span></label>
                        </div>
                        <div class="input-holder clearfix">
                           <input type="checkbox" name="seeds" id="seeds" value="1">
                           <label for="seeds">Seeds <span> (20)</span></label>
                        </div>
                     </div>
                     <p class="see-more">Show More</p>
                     <div class="filter-directory">
                        <div class="FilterDirectory-titleBar">
                           <input type="text" placeholder="Search by category" class="FilterDirectory-searchInput">
                           <ul class="FilterDirectory-indices">
                              <li data-item="#" class="">
                                 <a href="#all">#</a>
                              </li>
                              <li data-item="a" class="">
                                 <a href="#a">A</a>
                              </li>
                              <li data-item="b" class="FilterDirectory-disabled"> <a href="#b">b</a></li>
                              <li data-item="c" class=""> <a href="#c">c</a></li>
                              <li data-item="d" class="FilterDirectory-disabled"> <a href="#d">d</a></li>
                              <li data-item="e" class=""> <a href="#e">e</a></li>
                              <li data-item="f" class=""> <a href="#f">f</a></li>
                              <li data-item="g" class="FilterDirectory-disabled"> <a href="#g">g</a></li>
                              <li data-item="h" class="FilterDirectory-disabled"> <a href="#h">h</a></li>
                              <li data-item="i" class="FilterDirectory-disabled"> <a href="#i">i</a></li>
                              <li data-item="j" class=""> <a href="#j">j</a></li>
                              <li data-item="k" class=""> <a href="#k">k</a></li>
                              <li data-item="l" class=""> <a href="#l">l</a></li>
                              <li data-item="m" class=""> <a href="#m">m</a></li>
                              <li data-item="n" class=""> <a href="#n">n</a></li>
                              <li data-item="o" class="FilterDirectory-disabled"> <a href="#o">o</a></li>
                              <li data-item="p" class=""> <a href="#p">p</a></li>
                              <li data-item="q" class=""> <a href="#q">q</a></li>
                              <li data-item="r" class=""> <a href="#r">r</a></li>
                              <li data-item="s" class=""> <a href="#s">s</a></li>
                              <li data-item="t" class=""> <a href="#t">t</a></li>
                              <li data-item="u" class="FilterDirectory-disabled"> <a href="#u">u</a></li>
                              <li data-item="v" class="FilterDirectory-disabled"> <a href="#v">v</a></li>
                              <li data-item="w" class=""> <a href="#w">w</a></li>
                              <li data-item="x" class=""> <a href="#x">x</a></li>
                              <li data-item="y" class=""> <a href="#y">y</a></li>
                              <li data-item="z" class="">
                                 <a href="#z">z</a>
                              </li>
                           </ul>
                           <span class="FileDirectory-close"></span>
                        </div>
                        <div>
                           <ul class="FilterDirectory-list">
                              <li class="FilterDirectory-listTitle " data-item="#" id="all">#</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="afgani" id="afgani" value="1">
                                    <label for="afgani">Afgani(20)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="a" id="a">A</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="afgani" id="afgani" value="1">
                                    <label for="afgani">Afgani(20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="afgani" id="afgani" value="1">
                                    <label for="afgani">Afgoo (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="afgani" id="afgani" value="1">
                                    <label for="afgani">Alien Dawg (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="afgani" id="afgani" value="1">
                                    <label for="afgani">Aurora Indica (18)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="c" id="c">C</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="concentrates" id="concentrates" value="1">
                                    <label for="concentrates">Concentrates (20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Cannabis-Oil" id="Cannabis-Oil" value="1">
                                    <label for="Cannabis-Oil">Cannabis Oil (16)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="e" id="e">E</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="edibles" id="edibles" value="1">
                                    <label for="edibles">Edibles (20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="endless" id="endless" value="1">
                                    <label for="endless">Endless (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="eran-almog" id="eran-almog" value="1">
                                    <label for="eran-almog">Eran Almog (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="f" id="f">F</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="freezeland" id="freezeland" value="1">
                                    <label for="freezeland">Freezeland (20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="flowers" id="flowers" value="1">
                                    <label for="flowers">Flowers (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="frosty" id="frosty" value="1">
                                    <label for="frosty">Frosty (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="fucking-ncredible" id="fucking-ncredible" value="1">
                                    <label for="fucking-ncredible">Fucking Incredible (18)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="funky-monkey" id="funky-monkey" value="1">
                                    <label for="funky-monkey">Funky Monkey (18)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="j" id="j">J</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="jupiter-kush" id="jupiter-kush" value="1">
                                    <label for="jupiter-kush">Jupiter Kush (20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Jupiter-OG" id="Jupiter-OG" value="1">
                                    <label for="Jupiter-OG">Jupiter OG (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="jagermeister" id="jagermeister" value="1">
                                    <label for="jagermeister">Jagermeister (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="k" id="k">K</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Kandahar" id="Kandahar" value="1">
                                    <label for="Kandahar">Kandahar (20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="King-Louis" id="King-Louis" value="1">
                                    <label for="King-Louis">King Louis (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Kryptonite" id="Kryptonite" value="1">
                                    <label for="Kryptonite">Kryptonite (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Kush-Berry" id="Kush-Berry" value="1">
                                    <label for="Kush-Berry">Kush Berry (18)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="l" id="l">L</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="LA-OG" id="LA-OG" value="1">
                                    <label for="LA-OG">LA OG (20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Lemon-OG" id="Lemon-OG" value="1">
                                    <label for="Lemon-OG">Lemon OG (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Liquid-Butter" id="Liquid-Butter" value="1">
                                    <label for="Liquid-Butter">Liquid Butter (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="m" id="m">M</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Madagascar" id="Madagascar" value="1">
                                    <label for="Madagascar">Madagascar (20)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Mango" id="Mango" value="1">
                                    <label for="Mango">Mango (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Maui-Waui" id="Maui-Waui" value="1">
                                    <label for="Maui-Waui">Maui Waui (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Malawi" id="Malawi" value="1">
                                    <label for="Malawi">Malawi (18)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Moby-Dick" id="Moby-Dick" value="1">
                                    <label for="Moby-Dick">Moby Dick (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Mercury-OG" id="Mercury-OGi" value="1">
                                    <label for="Mercury-OG">Mercury OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="n" id="n">N</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Negra-44" id="Negra-44" value="1">
                                    <label for="Negra-44">Negra 44 (22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Neptune-Kush" id="Neptune-Kush" value="1">
                                    <label for="Neptune-Kush">Neptune Kush (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="p" id="p">P</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="q">Q</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="r" id="r">R</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="s" id="s">S</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="t" id="t">T</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="w" id="w">W</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="x" id="x">X</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="y" id="y">Y</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                              <li class="FilterDirectory-listTitle " data-item="z" id="z">Z</li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Pineapple-Thai" id="Pineapple-Thai" value="1">
                                    <label for="Pineapple-Thai">Pineapple Thai(22)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Platinum-Bubb" id="Platinum-Bubb" value="1">
                                    <label for="Platinum-Bubb">Platinum Bubb (16)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Northern-Lights" id="Northern-Lights" value="1">
                                    <label for="Northern-Lights">Northern Lights (25)</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder clearfix">
                                    <input type="checkbox" name="Nuggetry-OG" id="Nuggetry-OG" value="1">
                                    <label for="Nuggetry-OG">Nuggetry OG (25)</label>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="prdctListSection">
                  <div class="productListHdr">
                     <h6>Products</h6>
                     <div class="rightHdr">
                        <div class="form-group">
                           <input type="text" class="inpt_prdct" placeholder="Search for product">
                           <img src="assets/images/search.svg" alt="search">
                        </div>
                        <div class="btn-group prdlist">
                           <button class="btn custom-btn green-fill getstarted finish">Add Product</button>
                        </div>
                     </div>
                  </div>
                  <div class="productListBodyWrapper">
                     <table cellpadding="0" cellspacing="0">
                        <tr>
                           <th align="center">S.No.</th>
                           <th align="center">Availability</th>
                           <th align="center">Stock level</th>
                           <th align="center">Product Name</th>
                           <th align="center">Product Category</th>
                           <th align="center">Rating</th>
                           <th align="center">Price Range</th>
                           <th align="center">Status</th>
                           <th align="center">Action</th>
                        </tr>
                        <tr>
                           <td>1</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info" data-target="#infoModal"></td>
                        </tr>
                        <tr>
                           <td>2</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>3</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>4</td>
                           <td class="notfilled">Out of Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>5</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>6</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td class="notfilled">Inactive</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>7</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>8</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td class="notfilled">Inactive</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>9</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                        <tr>
                           <td>10</td>
                           <td>In Stock</td>
                           <td>100</td>
                           <td>Afghani Hawaiian...</td>
                           <td>Flowers</td>
                           <td><img src="assets/images/cannabis_leaf.svg" alt="Cannbis Leaf"> 4.3(10 reviews)</td>
                           <td>$ 270.00 - $ 2,200.00</td>
                           <td>Active</td>
                           <td><img src="assets/images/info.svg" alt="Info"></td>
                        </tr>
                     </table>
                     <!-- Modal Starts -->
                     <div class="infoWrapper" id="infoModal">
                        <div class="infomodalbox">
                           <div class="infoHeader">
                              <h4>Current Stock Level</h4>
                              <div class="btn-group">
                                 <button class="btn custom-btn active-fill getstarted backbtn">In-Active</button>
                                 <button class="btn custom-btn green-fill getstarted product_detail_view">View Detail</button>
                              </div>
                           </div>
                           <div class="infoBody">
                              <div class="listitems">
                                 <h6>50</h6>
                                 <p>7 Grams($140.00)</p>
                              </div>
                              <div class="listitems">
                                 <h6>30</h6>
                                 <p>20 Grams($400.00)</p>
                              </div>
                              <div class="listitems">
                                 <h6>20</h6>
                                 <p>50 Grams($900.00)</p>
                              </div>
                           </div>
                           <div class="infoMessage">
                              <h6>Additional Information</h6>
                              <p>Hashish is produced practically everywhere in and around Afghanistan. The best kinds of Hash in Afghanistan originate from the Northern provinces between Hindu Kush and the Russian border (Balkh, Mazar-i-Sharif).</p>
                           </div>
                        </div>
                     </div>
                     <!-- Modal Ends -->
                  </div>
                  <div class="pagination">
                     <h6>Display 1 of 10</h6>
                     <div class="paginationWrapper">
                        <div class="previous">
                           <img src="assets/images/arrow-left.svg" alt="Left Arrow"> Prev
                        </div>
                        <div class="paginationBullet">
                           <div class="bullet active">1</div>
                           <div class="bullet">2</div>
                           <div class="bullet">3</div>
                           ... 10
                        </div>
                        <div class="next">
                           Next <img src="assets/images/arrow-right.svg" alt="Right Arrow">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="productDetailWrapper">
               <div class="form-container">
                  <div class="productDetail">
                     <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                           <figure class="producttView">
                              <img src="assets/images/product.jpg" alt="product">
                           </figure>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                           <div class="prdctHeader">
                              <h3>Afghani Hawaiian Strain</h3>
                              <h6>Hybrid</h6>
                              <p>THC: 21% CBD: 6%</p>
                           </div>
                           <div class="prdctDescp">
                              <div class="prdctLeftName">
                                 <h4>$150 - $ 900</h4>
                                 <p>Price Range</p>
                              </div>
                              <div class="btn-group">
                                 <button class="btn custom-btn active-fill getstarted backbtn">In-Active</button>
                              </div>
                           </div>
                           <div class="prdctReview">
                              <figure>
                                 <img src="assets/images/cannabis_leaf - white.svg"> <span>4.5</span>
                              </figure>
                              <p>236 Reviews</p>
                           </div>
                           <!-- <div class="btn-group">
                              <button class="btn custom-btn active-fill getstarted backbtn">Edit Product</button>
                              </div> -->
                           <div class="row">
                              <div class="col-sm-12">
                                 <button class="btn custom-btn green-fill getstarted editprdDetail p-50">Edit Product</button>
                                 {{--   <a class="ch-shd back" href="javascript:void(0)">Delete Product</a> --}}
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="prdctDesp stocklevel">
                              <h5>Current Stock Level</h5>
                              <div class="prdctQuantity">
                                 <div class="product">
                                    <div class="pd-brdr">
                                       <span>1g</span>
                                    </div>
                                    <p>$12.10 (50 pac.)</p>
                                 </div>
                                 <div class="product">
                                    <div class="pd-brdr">
                                       <span>3.5g</span>
                                    </div>
                                    <p>$40.30 (50 pac.)</p>
                                 </div>
                                 <div class="product">
                                    <div class="pd-brdr">
                                       <span>7g</span>
                                    </div>
                                    <p>$76.55 (50 pac.)</p>
                                 </div>
                                 <div class="product">
                                    <div class="pd-brdr">
                                       <span>15g</span>
                                    </div>
                                    <p>$155.35 (50 pac.)</p>
                                 </div>
                                 <div class="product">
                                    <div class="pd-brdr">
                                       <span>50g</span>
                                    </div>
                                    <p>$400.20 (50 pac.)</p>
                                 </div>
                                 <div class="product">
                                    <div class="pd-brdr">
                                       <span>80g</span>
                                    </div>
                                    <p>$900.25 (50 pac.)</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="addInfo">
                              <h5>Additional Information</h5>
                              <p>Hashish is produced practically everywhere in and around Afghanistan. The best kinds of Hash in Afghanistan originate from theNorthern provinces between Hindu Kush and the Russian border (Balkh, Mazar-i-Sharif).</p>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="reviewPanel">
                              <h5>Reviews</h5>
                              <div class="ratingBox">
                                 <div class="rating">
                                    <div class="ratingWrapper">
                                       <span>5</span> <img src="assets/images/r5.jpg" alt="Rating">
                                    </div>
                                    <div class="ratingWrapper">
                                       <span>4</span> <img src="assets/images/r4.jpg" alt="Rating">
                                    </div>
                                    <div class="ratingWrapper">
                                       <span>3</span> <img src="assets/images/r3.jpg" alt="Rating">
                                    </div>
                                    <div class="ratingWrapper">
                                       <span>2</span> <img src="assets/images/r2.jpg" alt="Rating">
                                    </div>
                                    <div class="ratingWrapper">
                                       <span>1</span> <img src="assets/images/r1.jpg" alt="Rating">
                                    </div>
                                 </div>
                                 <div class="rating">
                                    <div class="ratingstarbox">
                                       <span> 4.5 </span>
                                       <div class="ratingstarImages">
                                          <img src="assets/images/cannabis_leaf.svg" alt="star rating">
                                          <img src="assets/images/cannabis_leaf.svg" alt="star rating">
                                          <img src="assets/images/cannabis_leaf.svg" alt="star rating">
                                          <img src="assets/images/cannabis_leaf.svg" alt="star rating">
                                          <img src="assets/images/cannabis_leaf - deep.svg" alt="star rating">
                                       </div>
                                    </div>
                                    <a>1,335 Reviews</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="reviewList">
                              <div class="reviewListnameWrapper">
                                 <div class="reviewListName">
                                    <h4>Abdul Wahab</h4>
                                    <figure>
                                       <span>4</span> <img src="assets/images/cannabis_leaf - white.svg">
                                    </figure>
                                 </div>
                                 <p>10 July 2019</p>
                              </div>
                              <p class="orderid">Order ID: <span>23</span></p>
                              <div class="descp">
                                 This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around. This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around
                              </div>
                           </div>
                           <div class="reviewList">
                              <div class="reviewListnameWrapper">
                                 <div class="reviewListName">
                                    <h4>Abdul Wahab</h4>
                                    <figure>
                                       <span>4</span> <img src="assets/images/cannabis_leaf - white.svg">
                                    </figure>
                                 </div>
                                 <p>10 July 2019</p>
                              </div>
                              <p class="orderid">Order ID: <span>23</span></p>
                              <div class="descp">
                                 This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around. This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around
                              </div>
                           </div>
                           <div class="reviewList">
                              <div class="reviewListnameWrapper">
                                 <div class="reviewListName">
                                    <h4>Abdul Wahab</h4>
                                    <figure>
                                       <span>4</span> <img src="assets/images/cannabis_leaf - white.svg">
                                    </figure>
                                 </div>
                                 <p>10 July 2019</p>
                              </div>
                              <p class="orderid">Order ID: <span>23</span></p>
                              <div class="descp">
                                 This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around. This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around
                              </div>
                           </div>
                           <div class="reviewList">
                              <div class="reviewListnameWrapper">
                                 <div class="reviewListName">
                                    <h4>Abdul Wahab</h4>
                                    <figure>
                                       <span>4</span> <img src="assets/images/cannabis_leaf - white.svg">
                                    </figure>
                                 </div>
                                 <p>10 July 2019</p>
                              </div>
                              <p class="orderid">Order ID: <span>23</span></p>
                              <div class="descp">
                                 This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around. This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around
                              </div>
                           </div>
                           <div class="reviewList">
                              <div class="reviewListnameWrapper">
                                 <div class="reviewListName">
                                    <h4>Abdul Wahab</h4>
                                    <figure>
                                       <span>4</span> <img src="assets/images/cannabis_leaf - white.svg">
                                    </figure>
                                 </div>
                                 <p>10 July 2019</p>
                              </div>
                              <p class="orderid">Order ID: <span>23</span></p>
                              <div class="descp">
                                 This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around. This product is extremely potent and very cleanly packed. Cheers to spreading happiness all around
                              </div>
                           </div>
                           <div class="btn-group btn_review">
                              <button class="btn custom-btn active-fill getstarted backbtn">See all reviews</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="editproductdetailwrapper">
               <div class="form-container">
                  <div class="editProductWrapper">
                     <div class="product-header">
                        <h2>Edit Product</h2>
                     </div>
                     <div class="editPrdctForm">
                        <div class="productPreview">
                           <div class="row">
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                 <div class="prdctHeader">
                                    <h3>Afghani Hawaiian Strain</h3>
                                    <h6>Hybrid</h6>
                                    <p>THC: 21% CBD: 6%</p>
                                 </div>
                                 <div class="prdctDescp">
                                    <div class="prdctLeftName">
                                       <h4>$150 - $ 900</h4>
                                       <p>Price Range</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                 <figure class="producttView">
                                    <img src="assets/images/product.jpg" alt="product">
                                 </figure>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                 <div class="quantitypricepanel">
                                    <label>Quantity & Price</label>
                                    <div class="form-group">
                                       <input type="text" class="form-control pl-210 searchproduct1" placeholder="Enter actual price (in $)">
                                       <input type="text" class="form-control quantity" placeholder="Enter quantity">
                                       <img src="{{asset('asset-admin/images/cross.svg')}}" alt="cross" class="cross">
                                       <img src="assets/images/delete.svg" alt="delete" class="prdctdelete">
                                       <div class="selectpanel">
                                          <select onchange="this.className=this.options[this.selectedIndex].className" class="selectedIndex">
                                             <option value="all" class="selectedIndex">Quantity</option>
                                             <option value="category1" class="selectedIndex">Quantity 1</option>
                                             <option value="category2" class="selectedIndex">Quantity 2</option>
                                             <option value="category3" class="selectedIndex">Quantity 3</option>
                                             <option value="category4" class="selectedIndex">Quantity 4</option>
                                          </select>
                                          <img src="assets/images/droparrow1.svg" class="dropmenu" alt="drop down menu">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <input type="text" class="form-control pl-210 searchproduct1" placeholder="Enter actual price (in $)">
                                       <input type="text" class="form-control quantity" placeholder="Enter quantity">
                                       <img src="{{asset('asset-admin/images/cross.svg')}}" alt="cross" class="cross">
                                       <img src="assets/images/delete.svg" alt="delete" class="prdctdelete">
                                       <div class="selectpanel">
                                          <select onchange="this.className=this.options[this.selectedIndex].className" class="selectedIndex">
                                             <option value="all" class="selectedIndex">Quantity</option>
                                             <option value="category1" class="selectedIndex">Quantity 1</option>
                                             <option value="category2" class="selectedIndex">Quantity 2</option>
                                             <option value="category3" class="selectedIndex">Quantity 3</option>
                                             <option value="category4" class="selectedIndex">Quantity 4</option>
                                          </select>
                                          <img src="assets/images/droparrow1.svg" class="dropmenu" alt="drop down menu">
                                       </div>
                                    </div>
                                    <p class="add_more">Add More</p>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                 <div class="additionInfo">
                                    <h5>Additional Description</h5>
                                    <div class="form-group">
                                       <textarea cols="30" class="add_description" rows="5" maxlength="500" placeholder="Write here...">Hashish is produced practically everywhere in and around Afghanistan. The best kinds of Hash in 
                                       Afghanistan originate from theNorthern provinces between Hindu Kush and the Russian border 
                                       (Balkh, Mazar-i-Sharif).
                                       </textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="btn-group preview">
                                    <button class="btn custom-btn trans-fill getstarted backbtn">Cancel</button>
                                    <button class="btn custom-btn green-fill getstarted finish">Save</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="orders" class="container-fluid tab-pane fade">
            <br>
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
         </div>
         <div id="earnings" class="container-fluid tab-pane fade">
            <br>
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
         </div>
         <div id="offers" class="container-fluid tab-pane fade">
            <br>
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
         </div>
      </div>
   </div>
</div>
@endsection