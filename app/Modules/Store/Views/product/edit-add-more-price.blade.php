<div class="form-group">
    <input type="number" maxlength="10" name="price[price][]" onkeypress="validate(event)" value="" class="pl-210 searchproduct1" placeholder="Enter actual price (in $)">
    <input type="number" maxlength="5" name="price[offered][]" onkeypress="validate(event)" value="" class="quantity hidden" placeholder="Enter offered price">
    <input type="number" maxlength="5" name="price[packet][]" onkeypress="validate(event)" value="" class="quantity" placeholder="Enter quantity">

    <img src="{{asset('asset-store/images/delete.svg')}}" alt="delete" class="prdctdelete" title="Delete">

    @if($productArr)
            <input type="hidden" id="hidden_unit_{{$hash}}" name="price[unit][]" value="{{$productArr[0]->unit}}">
            <input type="hidden" id="hidden_unit_quant_{{$hash}}" name="price[quant_unit][]" value="{{$productArr[0]->quant_units}}">
    @endif

    <div class="selectpanel">
        <select id="quantity_data" name="price[choice][]" class="selectedIndex sel-quant select_drop">
            @foreach($productArr as $key => $v)

            <option

                data-hidden-quant = "hidden_unit_quant_{{$hash}}"

                data-hidden-unit = "hidden_unit_{{$hash}}"

                value="{{$v->unit}}" data-unit="{{$v->unit}}" data-quant_unit = "{{$v->quant_units}}" class="selectedIndex">{{$v->quant_units.' '.$v->unit}}</option>

            @endforeach

        </select>
        <img src="{{asset('asset-store/images/droparrow1.svg')}}" class="dropmenu" alt="drop down menu">
    </div>
</div>
