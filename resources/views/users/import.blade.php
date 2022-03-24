<style type="text/css">
    #e1 {
    width: 500px;       
}
.bigdrop{
    width: 600px !important;

}
</style>
<div class="m-login__signup">
	{{-- <div class="m-login__head">

		<div class="m-login__desc"><h3>Import Users:</h3></div>
	</div> --}}
	<form class="m-login__form m-form" action="{{ route('import-user') }}" method="post" enctype="multipart/form-data">
        <div class="form-group m-form__group">
            <label for="uploadUsers">Upload Users details:</label>
            <small>Please Note, Excel sheet should have First Name, Last Name, Staff Id, Email as column</small>
            {!! Form::file('file', ['class'=>'form-control']) !!}
        </div>
        
        <div class="m-portlet__foot m-portlet__foot--fit">
            <button class="btn btn-primary " id="upload" type="submit">Upload</button>
        </div>
        @csrf
	</form>
</div>

