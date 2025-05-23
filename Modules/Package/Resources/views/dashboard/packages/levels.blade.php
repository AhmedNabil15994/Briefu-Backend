<div class="get-levels-form" style="display:none">

    <div class="levels-form-html">
        <div class="form-group">
            <label class="col-md-2">
                {{__('package::dashboard.packages.form.sort')}}
            </label>
            <div class="col-md-9">
                <input type="text" name="sort[]" class="form-control" data-name="sort">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group price">
            <label class="col-md-2">
                {{__('package::dashboard.packages.form.price')}}
            </label>
            <div class="col-md-9">
                <input type="text" name="price[]" class="form-control" data-name="price">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{__('package::dashboard.packages.form.job_posts')}}
            </label>
            <div class="col-md-9">
                <input type="text" name="job_posts[]" class="form-control" data-name="job_posts">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{__('package::dashboard.packages.form.months')}}
            </label>
            <div class="col-md-9">
                <input type="text" name="months[]" class="form-control" data-name="months">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{__('package::dashboard.packages.form.video_cv')}}
            </label>
            <div class="col-md-9">
                <input type="checkbox" class="ischecked" name="video_cv[]" value="1" onclick="AcceptVideoCv()">
                <input type="hidden" class="isUnchecked" name="video_cv[]" value="0" checked>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{__('package::dashboard.packages.form.company_in_home')}}
            </label>
            <div class="col-md-9">
                <input type="checkbox" class="ischecked" name="company_in_home[]" value="1" onclick="CompanyInHome()">
                <input type="hidden" class="isUnchecked" name="company_in_home[]" value="0" checked>
            </div>
        </div>

        <div class="form-group">
            <span class="input-group-btn">
                <a class="btn btn-danger delete-levels">
                    <i class="fa fa-trash"></i>
                </a>
            </span>
        </div>
    </div>

</div>
