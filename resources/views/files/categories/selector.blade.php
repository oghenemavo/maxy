
<div class="form-group m-form__group">
	<label>Category/ Folder</label>
	<div class="input-group">
		<input type="text" disabled="disabled" class="form-control" placeholder="Choose the category/ folder..." id="categoryLabel", value="">
		<input type="hidden" id="{{ $id }}", name="{{ @$name }}" value="{{ $value }}">
		<div class="input-group-append">
			<a href="{{ route('store-folder', ['folder_id'=>2]) }}" title="Edit Category" data-view="{{ route('store-folder', ['folder_id'=>2]) }}"
               data-toggle="modal" data-placement="bottom" title="Choose" data-target="#sel_cat_modal" class="" href="" id="modalButton"
               data-type='wide' data-title="Choose category" >
				<button class="btn btn-primary" type="button">Choose</button>
			</a>
		</div>
	</div>
</div>



    


<script type="text/javascript">
 
    $(document).ready(function () {

    	$("#m_tree_6")
        // listen for event
          .on('select_node.jstree', function (e, data) {
            @if($isEdit)
                data.selected = ["{{$value}}"]
            @endif
          	$("#categoryLabel").val( data.instance.get_node(data.selected[0]).text );
          	$("#{{ $id }}").val( data.selected[0] );
          	console.log( data.instance.get_node(data.selected[0]).text );

          	$('#sel_cat_modal').modal('hide');
          	loadCatFields();


            // var i, j, r = [];
            // for(i = 0, j = data.selected.length; i < j; i++) {
            //    // r.push(data.instance.get_node(data.selected[i]).text);
            //    // if(data.selected[i] != '{{ @$curr_folder_id }}')
            //     // document.location = '{{ route('all-files') }}?fld='+data.selected[i]
            // }
            // $('#event_result').html('Selected: ' + r.join(', '));
          })
          //create the instance
          // .on('loaded.jstree', function() {
          //       $("#m_tree_6").jstree('select_node', '{{ @$curr_folder_id }}');
          // })   
        .jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                }, 
                // so that create works
                "check_callback" : true,
                'data' : {
                    'url' : function (node) {
                      return '{{ route('get-folder-breakdown') }}';
                    },
                    'data' : function (node) {
                      return { 'parent' : node.id };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder m--font-brand"
                },
                "file" : {
                    "icon" : "fa fa-file  m--font-brand"
                }
            },
            "state" : { "key" : "demo3" },
            "plugins" : [ "dnd", "state", "types" ]
        });



  });
  
  function loadCatFields() {
             $("#catFieldDiv").html("Please wait...");
             $.ajax({
                  
                    data: {'d': 'sfd'},
                    dataType: 'html',
                    success: function(res) {
                        $("#catFieldDiv").html(res);

                    },
                    error: function(res) {
                        
                        
                    }
                });  
        } 
</script>


