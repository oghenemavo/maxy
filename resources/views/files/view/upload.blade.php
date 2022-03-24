<style type="text/css">
    #e1 {
    width: 500px;       
}
.bigdrop{
    width: 600px !important;

}
</style>
<div class="m-login__signup">
    
    {!! Form::open(['route' => 'upload-file', 'files' => true, 'class'=>'m-login__form m-form']) !!}
        {!! Form::hidden('fileId', $file->id) !!}
        <div class="form-group m-form__group">
            <div class="m-login__desc">Main File name:</div>
            <input class="form-control m-input" type="text" readonly="readonly" disabled='disabled' placeholder="Name" value="{{ @$file->name }}" required="" name="name">
        </div>
        {{-- <div class="form-group m-form__group">
            <div class="m-login__desc">New File name:</div>
            <input type="text" name="name" id="" class="form-control" required>
        </div>  --}}
        <div class="form-group m-form__group">
            <div class="m-login__desc">Upload file:</div>
            {!! Form::file("newfiles[]", ['class'=>'form-control', 'required', 'multiple']) !!}
               
        </div>

        @csrf

        <div class="m-login__form-action">
            <input type="submit" id="m_login_signup_submit" value="Upload" class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
            <!-- <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel</button> -->
        </div>
    </form>
</div>