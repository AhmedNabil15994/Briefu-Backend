<div class="form-group">
    <label class="col-md-2">
        {{__('company::dashboard.companies.form.prices')}}
    </label>
    @php $selected_price_id = isset($selected_price_id) ? $selected_price_id : null; @endphp
    <div class="col-md-9">
        <select name="level_id" class="form-control select2" id="level_id" data-name="level_id">
            <option value=""></option>
            @foreach ($prices as $id => $price)
                <option value="{{$id}}" {{$selected_price_id == $id ? 'selected' : ''}}>
                    {{ $price }}
                </option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>
