<style type="text/css">
    #e1 {
    width: 500px;       
}
.bigdrop{
    width: 600px !important;

}
</style>
<div class="m-login__signup">
    
    {!! Form::open(['route' => 'checkin-file', 'files' => true, 'class'=>'m-login__form m-form']) !!}
        {!! Form::hidden('fileId', $file->id) !!}
        <div class="form-group m-form__group">
            <div class="m-login__desc">File name:</div>
            <input class="form-control m-input" type="text" readonly="readonly" disabled='disabled' placeholder="Name" value="{{ @$file->name }}" required="" name="name">
        </div>
        <div class="form-group m-form__group">
            <div class="m-login__desc">Upload file:</div>
            {!! Form::file("checkinfile", ['class'=>'form-control', 'required']) !!}
            
            
        </div>
        <div class="form-group m-form__group">
            <div class="m-login__desc">Current version:</div>
            {!! Form::text('curr_version', number_format(@$file->current_version), ['class'=>'form-control', 'readonly'=>'readonly', 'disabled'=>'disabled'])    !!}
        </div>
        <div class="form-group m-form__group">
            <div class="m-login__desc">New version:</div>
            {!! Form::text('new_version', number_format(@$file->current_version+1), ['class'=>'form-control', 'readonly'=>'readonly', 'disabled'=>'disabled'])    !!}
        </div>

        <div class="form-group m-form__group">
            <div class="m-login__desc">Comments:</div>
            {!! Form::textarea('comments', null, ['class'=>'form-control'])    !!}
        </div>
        @csrf

        
        

        <div class="m-login__form-action">
            <input type="submit" id="m_login_signup_submit" value="Check In" class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
            <!-- <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel</button> -->
        </div>
    </form>
</div>