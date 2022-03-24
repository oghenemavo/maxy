/*
 *  Document   : app.js
 *  Author     : pixelcave
 *  Description: Custom scripts and plugin initializations (available to all pages)
 *
 *  Feel free to remove the plugin initilizations from uiInit() if you would like to
 *  use them only in specific pages. Also, if you remove a js plugin you won't use, make
 *  sure to remove its initialization from uiInit().
 */
 
  
if (!ss){
    var ss = window.ss = {};
}

ss.preloader = '<div style="padding:20px;text-align:center;margin:auto;"><i class="fa fa-spinner fa-spin fa-4x"></i><br/>Please wait...</div>';
ss.selectedEmployees = [];

ss.createSelect = function(options,callback,statusSelect,displayBox,SelectName) {
                $('#'+statusSelect).bsselect(options, function(goal, value) {
                    selected_goal = goal;
                    $('#'+statusSelect+' span').html("<b>"+SelectName+":</b> " + ucfirst(value));
                    $("#"+displayBox).val(goal);
                    
                    callback();

                });
}

ss.getAllUrlParams = function(name, query) {

 return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(query) || [null, ''])[1].replace(/\+/g, '%20')) || null;

}




ss.dateRangerPicker = function (callback, el='#reportrange' ) {
    
    if($(el).length) {
            $(el).daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            }, function(start, end) {

                $(el + ' span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY') + ' ');
                $("#daterange").val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
                callback();

            });
    }

}

ss.dateRangerPickerCustom = function (callback, el='#reportrange' ) {
    
    if($(el).length) {
            $(el).daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            }, function(start, end) {

                $(el + ' span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY') + ' ');
                $("#daterange").val(toTimestamp(start)+ '-' + toTimestamp(end));
                callback();

            });
    }

}

function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
}

ss.loadReports = function(url) {

     window.open(url, "", "width=800,height=600");

}



ss.showModal = function(obj,title,view,data)
{
    console.log('showin modal');
    $('#commonModal .modal-title').text(title);
    $('#commonModal .modal-dialog').removeClass('modal-lg').removeClass('modal-xs').removeClass('modal-md').removeClass('modal-sm').addClass(data.modal_size);
    $('#commonModal .modal-body').html( ss.preloader ); 

    $.get(view, data, function(response){
        $('#commonModal .modal-body').html( response);
    });
}



$(document).ready(function(){

    ss.selectedBulkAction = $('#bulk-option').val();

    $('.modal-header .close');

    $('body').on('click','#modalButton', function(){


        var data =  {};

        if( $(this).attr('data-type') == 'normal' )
        {
            data.modal_size = 'modal-md';
            ss.showModal( $(this), $(this).attr('data-title') , $(this).attr('data-view'), data );
        }
        else if( $(this).attr('data-type') == 'wide' )
        {
            data.modal_size = 'modal-lg';
            ss.showModal( $(this), $(this).attr('data-title') , $(this).attr('data-view'), data );
        }
        else if( $(this).attr('data-type') == 'small' )
        {
            data.modal_size = 'modal-sm';
            ss.showModal( $(this), $(this).attr('data-title') , $(this).attr('data-view'), data );
        }
    });

    $('#commonModal').on('hidden.bs.modal', function () {
        $('#commonModal .modal-title').text("");
        $('#commonModal .modal-body').html( ss.preloader );

        //Make sure all bulk actions are stopped
        $('button').trigger('bulk-action-complete');
    });

    $('#bulk-option').on('change', function(){
        ss.selectedBulkAction = $('#bulk-option').val();
    });

    $('#bulk-select').on('click', function(){
        if($(this).is(':checked')){
            ss.selectedEmployees = ['ALL'];
             $('#apply-bulk-action').removeAttr('disabled');
            $('body #bulk-select-item').prop('checked', true);
        }
        else
        {
            ss.selectedEmployees = [];
            $('#apply-bulk-action').attr('disabled','disabled');
            $('body #bulk-select-item').prop('checked', false);
        }
    });

    $('#apply-bulk-action').on('click', function(){
        if( ss.selectedBulkAction != '' )
        {
            if($('#bulk-select').is(':checked') || $('body #bulk-select-item:checked').length > 0){
                $(this).attr('disabled','disabled').find('#bulk-loader').show();
            }
            else
            {
                $('body #bulk-select-item').prop('checked', false);
            }
        }
        else
        {
            $.bootstrapGrowl('Choose a bulk action', {
              type: 'danger', // (null, 'info', 'error', 'success')
              align: 'center', // ('left', 'right', or 'center')
            });
        }
        
    });

    $('body #bulk-select-item').on('click', function(){
        if($(this).is(':checked')){
            
        }
        else
        {
            $('body #bulk-select').prop('checked', false);
        }

        
        if($('body #bulk-select-item:checked').length)
        {
            ss.selectedEmployees = [];
            $('#apply-bulk-action').removeAttr('disabled');
            $.map( $('body #bulk-select-item:checked'), function( val, i ) {
                ss.selectedEmployees.push( $('body #bulk-select-item:checked').eq(i).attr('ref') );
            });
        }
        else
        {
            $('#apply-bulk-action').attr('disabled','disabled');
            ss.selectedEmployees = [];
        }


    });

    $('body').on('bulk-action-complete', function(){
        $('#apply-bulk-action').removeAttr('disabled').find('#bulk-loader').hide();
    });

    
    //CHECK IF USER IS LOGGED IN
    
    
     
    

    // onclick="ss.showModal('Assess','')"
});


function reloadModal(e){
        
}   

function reloadModal2(e){
        console.log(e.href);
        console.log(e);

    var url = e.href;
    
    $("#general-modal2-content").html('<div style="padding:20px;text-align:center;margin:auto;"><i class="fa fa-spinner fa-spin fa-4x"></i><br/>Please wait...</div>');

    
    $.ajax
    (
        {
           type: "POST",
           url: url,
           data: ({ rnd : Math.random() * 100000}),
           success: function(html)
           {
             $('#general-modal2-content').html(html);
               
           },
           error: function(html){
            $('#general-modal2-content').html(html);
           }
     });

}
