<h5>{{ __('Фильтр') }}</h5>

<div class="form-group" style="display: none;">
    <label>Text</label>
    <div class="row">
        <div class="col-6">
            <input type="text" class="form-control" placeholder="Enter ...">
        </div>
        <div class="col-6">
            <input type="text" class="form-control" placeholder="Enter ...">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input class="custom-control-input fbo-filter" name="fbo" type="checkbox" id="customCheckbox-fbo" value="1" onclick="table.draw()">
        <label for="customCheckbox-fbo" class="custom-control-label">{{ __('FBO OZON') }}</label>
    </div>
</div>


