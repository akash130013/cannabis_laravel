    <!-- loaction filters -->
    <div class="search-filter-section">
               
        <div class="filter-form-section white_wrapper  pd-20 animated">
            <div class="filter-form">
            <div class="sidebar-header">
                        <span class="close_filter">
                            <img src="{{asset('asset-admin/images/cross.svg')}}" alt="close">
                        </span>
                        <label>Filter</label>
                    </div>
                <div class="row">
                   
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Date of Order</label>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control filter" placeholder="From" id="startDate">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control filter" placeholder="To" id="endDate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Price</label>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" onkeypress="return isNumber(event)" class="form-control filter" placeholder="Min" id="minAmount">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" onkeypress="return isNumber(event)" class="form-control filter" placeholder="Max" id="endDate">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select data-text="Status" class="form-label filter filter-select" name="status" id="status">
                                <option value="" selected>All</option>
                                <option value="order_placed">Order Placed</option>
                                <option value="order_verified">Order Verified</option>
                                <option value="driver_assigned">Driver Assigned</option>
                                <option value="on_delivery">On Delivery</option>
                                <option value="delivered">Delivered</option>
                                <option value="amount_received">Amount Received</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb0">
                            <div class="btn-holder clearfix text-center">
                                <button type="button" id='applyFilter' class="mr10 green-fill-btn green-border-btn">Reset</button>
                                <button type="button" class="green-fill-btn close_filter" id="applyDistributorOrderFilter">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
            <table class="outlet-table table" id="order_table">
            </table>
        </div>
    </div>
{{-- </div> --}}
