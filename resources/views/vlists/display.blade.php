@php
 if($isEdit)  {
     $connection = json_decode($vlist['connection_details'], true);
 } 
//  dd($connection['database'])
@endphp
<div class="m-login__signup">
	<div class="m-login__head">
		<div class="m-login__desc">Value List  details:</div>
	</div>
<form class="m-login__form m-form" action="{{(!$isEdit)? route('create-vlist') : route('edit-vlist', @$vlist->id)}}" method="post">
		<div class="form-group m-form__group">
			<input class="form-control m-input" type="text" placeholder="Name " id="name" value="{{ @$vlist->name }}" required="" name="name">
		</div>
		<div class="form-group m-form__group">
			
            <label>Description</label>
            <textarea  class="form-control m-input"  id="description" name="description">{{ @$vlist->description }}</textarea>
		</div>
        <div class="form-group m-form__group">			
            <label>Value List Type</label>
            {!! Form::select('type', ['LOCAL', 'REMOTE'], null,
            ['class' =>'form-m-bootstrap-select form-control', 'onclick'=>'displayType()', 'id'=>'vListtype']); !!}
		</div>
        {!! Form::hidden('items', @$item_str, ['id'=>'itemStr']); !!}
        {{-- {{dd($vlist)}} --}}

        @csrf
        <div id="local">
            <hr>
            <h4>Items</h4>


            
            <table class="table" id="itemTable">
                <thead>
                <th>Name</th>
                
                </thead>
                <tbody>
                    @if(@$vlist->type== 'LOCAL')
                        @foreach(@$vlist->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <input type="checkbox" onclick="removeItem('{{ $item->name }}');" name="record" class="delete-row">
                                    <em>Check to remove</em>
                                </td>
                                
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            

            <a  onclick="showPermission()" >Add new item</a>

            <div id="selectPermissionType" class="">
                <div class="form-group m-form__group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="" id="add_field">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="addItem();">Add</button>
                        </div>
                    </div>
                </div>
            </div>


            
            <hr>
            <br/>
            <div class="m-login__form-action">
                <input type="submit" id="m_login_signup_submit" value="@if($isEdit) Update @else Create @endif" 
                class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
            </div>  
        </div>
        <div id="remote" style="display:none">
            <h4>Enter your connection details</h4>
    
                <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Connection Host:</label>
                        <input type="text" class="form-control m-input" id="hostname" name='hostname' value="{{ @$connection['hostname'] }}" >
                    </div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Database type:</label>
                        {!! Form::select('database', [''=>'Choose','MSSQL'=>'MSSQL'], null,  ['class'=>'form-control m-input', 'id'=>'database' ] ) !!}
                        
                    </div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Database username:</label>
                        <input type="" class="form-control m-input" id="username" name="username" value="{{ @$connection['username'] }}" >
                    </div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Database password:</label>
                        <input type="password" class="form-control m-input" id="password" name="password" value="{{ @$connection['password'] }}">
                    </div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Database Name:</label>
                        <input type="text" class="form-control m-input" id="dbname" name="dbname" value="{{ @$connection['dbname'] }}" >
                    </div>
                   
                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">SQL Query:</label>
                        {{-- <input type="text" class="form-control m-input" id="query" name="query"  > --}}
                        <textarea name="statement" id="statement" cols="30" rows="5" class="form-control m-input" rows="10">{{ @$connection['statement'] }}</textarea>
                    </div> 
                    <div class="m-portlet__foot m-portlet__foot--fit">
							<button class="btn btn-primary " id="connect">Connect</button>
					</div>      
            </div>
		
	</form>
</div>

<script type="text/javascript">
    
    $(document).ready(function () {

        $('.select2').select2({dropdownCssClass : 'bigdrop', 'width': '300px'});
        
        @if(!$isEdit)
        var url = "{{ route('create-vlist') }}";
        @else
        var url = "{{ route('edit-vlist', @$vlist->id) }}";
        @endif

    	$("#m_login_signup_submit").click(function(l) {

            if($("#itemStr").val().length === 0 && $("#remote").css('display') == 'none'){

                alert("Please add items to this value list.")
                l.preventDefault();
                return;
            }else if($("#remote").css('display') == 'none'){

                    var t = $(this),
                        r = $(this).closest("form");
                    r.validate({
                        rules: {
                            name: {
                                required: !0
                            },
                            items: {
                                required: !0
                            },
                        }
                    }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                        url: url,
                        success: function(l, s, n, o) {

                            if(l.status == 200){
                                window.location.href = "";
                            }

                        }
                    }));

            }
            
                $("#connect").click(function(){
                    console.log("clicked")
                var name = $("#name").val();
                var description = $("#description").val();
                var hostname = $("#hostname").val();
                var database = $("#database").val();
                var username = $("#username").val();
                var password = $("#password").val();
                var dbname = $("#dbname").val();
                var statement = $("#statement").val();

                $.ajax({
                    type: "post",
                    data: { 'name': name,'description': description,'hostname': hostname,'database':database,'username':username,
                            'password':password, 'name':dbname, 'statement':statement, '_token': '{{ csrf_token() }}' },
                    url: url,
                    success: function(data){
                        console.log(data);
                    }
                });
            });
                });
    });

    function displayType(){
    const type = document.getElementById('vListtype').value
    const local = document.getElementById('local')
    const remote = document.getElementById('remote')
        if(type == 0){
            remote.style.display= 'none'
            local.style.display = 'block'
        }
        else {
            remote.style.display = "block"
            local.style.display = "none"
        }
       
}


    function addItem(){


        var name = $("#add_field").val();
        if(name.length == ""){
            alert("Input the value name");
            return;
        }
        var markup = "<tr><td>" + name + "</td><td><input type='checkbox' onclick='removeItem(\""+name+"\");' name='record' class='delete-row'><em>Check to remove</em></td></tr>";
        $("table tbody").append(markup);
        $("#add_field").val("");

        $("#itemStr").val($("#itemStr").val()+","+name);




    }

    function removeItem(itemName){

        $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });


        $("#itemStr").val($("#itemStr").val().replace(","+itemName, ""));

    }


</script>