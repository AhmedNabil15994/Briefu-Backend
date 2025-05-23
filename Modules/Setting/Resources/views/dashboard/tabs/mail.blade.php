<div class="tab-pane fade" id="mail">
    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.mail') }}</h3>
    <div class="col-md-10">
    
        {!! field()->file('images[mail_header]' , __('setting::dashboard.settings.form.mail_header_image') , 
            setting('mail_header') ? asset(setting('mail_header')) : null) !!}
            
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_driver') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_DRIVER]" value="{{setting('env','MAIL_DRIVER')}}" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_encryption') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_ENCRYPTION]" value="{{setting('env','MAIL_ENCRYPTION')}}" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_host') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_HOST]" value="{{setting('env','MAIL_HOST')}}" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_port') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_PORT]" value="{{setting('env','MAIL_PORT')}}" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_from') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_FROM_ADDRESS]" value="{{setting('env','MAIL_FROM_ADDRESS')}}" autocomplete="off" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_name_from') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_FROM_NAME]" value="{{setting('env','MAIL_FROM_NAME')}}" autocomplete="off" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
              {{ __('setting::dashboard.settings.form.mail_username') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_USERNAME]" value="{{setting('env','MAIL_USERNAME')}}" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_password') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_PASSWORD]" value="{{setting('env','MAIL_PASSWORD')}}" autocomplete="off" />
            </div>
        </div>
    </div>
</div>
