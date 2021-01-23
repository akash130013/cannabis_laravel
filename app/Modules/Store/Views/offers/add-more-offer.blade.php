<div class="form_wrapper">
    <div class="form-group quantity-input-field">
        <div class="text-field-wrapper">
            <div class="detect-icon detect-icon-lt">
                <select class="select_drop select_option_offer">
                    @if($data)
                     @foreach($data as $key => $val)
                        <option value="{{$val->quant_units}}" data-unit="{{$val->unit}}">{{$val->quant_units}} {{$val->unit}}</option>
                     @endforeach
                    @endif
                </select>
                <img src="{{asset('asset-store/images/droparrow-w.svg')}}" class="dropmenu" alt="drop down menu" />
            </div>
            <input type="text" name="price[]" onkeypress="validate(event)" class="form-control pl-230 add-product" placeholder="Enter offer price (In $)">
        </div>
    </div>
    <div class="form-group">
        <div class="text-field-wrapper">
            <input type="text" name="offerprice" onkeypress="validate(event)" class="form-control offered-price" placeholder="Offer Price (In $)">
        </div>
    </div>
    <div>
        <span class="delete-icon">
            <img src="{{asset('asset-store/images/delete.svg')}}"  title="Delete"/></span>
    </div>
</div>