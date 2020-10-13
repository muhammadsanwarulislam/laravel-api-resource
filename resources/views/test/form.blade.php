<!-- Form Start -->
<div class="row">
    <div class="col-6">
        <div class="form-group">
            @php
            $field_name = 'title';
            $field_lable = 'Title';
            $field_placeholder = $field_lable;
            $required = "";
            @endphp

            {{ html()->label($field_lable, $field_name) }} 
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            @php
            $field_name = 'description';
            $field_lable = 'Description';
            $field_placeholder = $field_lable;
            $required = "";
            @endphp

            {{ html()->label($field_lable, $field_name) }} 
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>

</div>
<!-- Form End -->