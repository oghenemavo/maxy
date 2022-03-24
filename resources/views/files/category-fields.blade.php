@php
// This helps to disbale metadata when the metadata is not at a step of the workflow
    if($folder->workflow){
         if($file->step) {
            //  dd($file->step);
             $stepId = $file->step->rank;
             $stepId = $stepId-1;
            }
        else {
            $stepId = 0;
            }
             $currentStep = $folder->workflow->steps[$stepId];
            //  dd($currentStep);
            foreach($currentStep->metadata as $md) {
                $stepMD[] = $md->id;              
           
            // dd($stepMD);
            // foreach($file->step->assignees as $assignee) {
            //     if(Auth::user()->id == $assignee->recipient_id){
            //         $disabled= '';
            //     }
            //     else $disabled = true;
            // }
            
         }
         
        //  $stepMD = [];
    } 
    // dd( $stepMD);  
@endphp

<div class="form-group row">
    <label for="example-text-input" class="col-4 col-form-label">Workflow</label>
    <div class="col-8">
        {!! Form::text('workflow', ($folder->workflow) ? $folder->workflow->name : "None attached", ['class' =>'form-control', 'disabled'=>'disabled']) !!}
    </div>
</div>

@if($folder->workflow)
    <div class="form-group row">
        <label for="example-text-input" class="col-4 col-form-label">Workflow step</label>
        <div class="col-8">
            {!! Form::text('workflow', ($file->step) ? $file->step->name : $folder->workflow->steps()->first()->name , ['class' =>'form-control', 'disabled'=>'disabled']) !!}
        </div>
    </div>
@endif


<hr/>

<div class="m-form__heading">
    <h3 class="m-form__heading-title">Metadata:</h3>
</div>


 <div class="form-group row">
    <label for="example-text-input" class="col-2 col-form-label">File Name</label>
    <div class="col-4">
        {!! Form::text('name', @$file->name, ['class' =>'form-control' , 'readonly'=>'readonly']) !!}
    </div>
</div>
<div class="row">

@foreach($folder->fields as $field)
 <div class="col-md-6">
@php
$filledField = $file->fields()->where('id', $field->id)->first();
$value = ($filledField) ? $filledField->pivot->value : '';
$isMetadataEnabled = $folder->workflow == null  || in_array($field->id, $stepMD);
@endphp

    <div class="form-group row">
        <label for="recipient-name" class="col-4 col-form-label">{{ $field->name }}</label>
        <div class="col-8">

             @if($field->type == "Text")
                {!! Form::text('fld_'.$field->id, $value, ($isMetadataEnabled) ? ['class' =>'form-control'] : ['class' =>'form-control', 'readonly'=>'readonly'] )  !!}


            @elseif($field->type == "Number")            
                {!! Form::number('fld_'.$field->id, $value, ($isMetadataEnabled) ? ['class' =>'form-control'] : ['class' =>'form-control', 'readonly'=>'readonly'] ) !!}

            @elseif($field->type == "Decimal")
                {!! Form::number('fld_'.$field->id, $value, ($isMetadataEnabled) ? ['class' =>'form-control','step' => '0.01'] : ['class' =>'form-control', 'readonly'=>'readonly','step' => '0.01']) !!}

            @elseif($field->type == "Boolean")
                {!! Form::select('fld_'.$field->id, [ 'Yes' => 'Yes', 'No' => 'No'], $value, ($isMetadataEnabled) ? [ 'placeholder' => 'Choose', 'class' =>'form-control'] : [ 'placeholder' => 'Choose', 'class' =>'form-control readonly']) !!}

            @elseif($field->type == "Time")
                {!! Form::time('fld_'.$field->id, Carbon\Carbon::now()->format('H:i') , ($isMetadataEnabled) ? ['class' =>'form-control'] : ['class' =>'form-control', 'readonly'=>'readonly'])!!}

            @elseif($field->type == "Date")
                {!! Form::date('fld_'.$field->id, Carbon\Carbon::now()->format('Y-m-d') , ($isMetadataEnabled) ? ['class' =>'form-control'] : ['class' =>'form-control', 'readonly'=>'readonly'])!!}

            @elseif($field->type == "Timestamp")
                {!! Form::text('fld_'.$field->id, null , ($isMetadataEnabled) ? ['class' =>'form-control','readonly'=>'readonly'] : ['class' =>'form-control','readonly'=>'readonly', 'readonly'=>'readonly'])!!}


            @elseif($field->type == "Long Text")
                {!! Form::textarea('fld_'.$field->id, $value, ($isMetadataEnabled) ? ['class' =>'form-control','rows' => 3] : ['class' =>'form-control', 'readonly'=>'readonly','rows' => 3]) !!}
            
                @elseif(in_array($field->type, ["Dropdown"]))
                {!! Form::select('fld_'.$field->id, prepDropdownItemsFromValueList($field->list), $value, ($isMetadataEnabled) ? ['class' => 'form-control select2'] : ['class' =>'form-control select2', 'readonly']) !!}


            @elseif(in_array($field->type, [ 'Multiple selection']))
                <select name={!!'fld_'.$field->id.'[]'!!} class="form-control select2" ($isMetadataEnabled) ?  readonly: "" multiple="multiple">
                    @foreach(prepDropdownItemsFromValueList($field->list) as $field)
                        <option value="{{ $field }}" {{ in_array($field, explode(",", $value) ) ? 'selected' : '' }} >
                            {{ $field }}
                        </option>
                    @endforeach
                </select>

            @endif

        
    </div>
    </div>
</div>
@endforeach
</div>

<script type="text/javascript">
    $('.select2').select2({dropdownCssClass : 'bigdrop', theme: "classic", width: 'resolve' });
    $('.select3').prop("disabled", true);
    
</script>
