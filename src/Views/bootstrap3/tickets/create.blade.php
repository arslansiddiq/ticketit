@extends($master)
@section('page', trans('ticketit::lang.create-ticket-title'))

@section('content')
@include('ticketit::shared.header')
    <div class="well bs-component">
        {{-- {!! dd($subcategories) !!} --}}

        {!! CollectiveForm::open([
                        'route'=>$setting->grab('main_route').'.store',
                        'method' => 'POST',
                        'class' => 'form-horizontal'
                        ]) !!}
            <legend>{!! trans('ticketit::lang.create-new-ticket') !!}</legend>
            <div class="form-group">
                {!! CollectiveForm::label('subject', trans('ticketit::lang.subject') . trans('ticketit::lang.colon'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! CollectiveForm::text('subject', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    <span class="help-block">{!! trans('ticketit::lang.create-ticket-brief-issue') !!}</span>
                </div>
            </div>
            <div class="form-group">
                {!! CollectiveForm::label('content', trans('ticketit::lang.description') . trans('ticketit::lang.colon'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! CollectiveForm::textarea('content', null, ['class' => 'form-control summernote-editor', 'rows' => '5', 'required' => 'required']) !!}
                    <span class="help-block">{!! trans('ticketit::lang.create-ticket-describe-issue') !!}</span>
                </div>
            </div>
            <div class="form-inline row">
                <div class="form-group col-lg-4">
                    {!! CollectiveForm::label('priority', trans('ticketit::lang.priority') . trans('ticketit::lang.colon'), ['class' => 'col-lg-6 control-label']) !!}
                    <div class="col-lg-6">
                        {!! CollectiveForm::select('priority_id', $priorities, null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-lg-4">
                    {!! CollectiveForm::label('category', trans('ticketit::lang.category') . trans('ticketit::lang.colon'), ['class' => 'col-lg-6 control-label']) !!}
                    <div class="col-lg-6">
                        {!! CollectiveForm::select('category_id', $categories, null, ['class' => 'form-control cat', 'required' => 'required', 'onchange' => 'selectCategory(this.value)']) !!}
                    </div>
                </div>
                <div class="form-group col-lg-4 subcat">
                    {!! CollectiveForm::label('category', trans('ticketit::lang.subcategory') . trans('ticketit::lang.colon'), ['class' => 'col-lg-6 control-label']) !!}
                    <div class="col-lg-6">
                        {!! CollectiveForm::select('subcategory_id', $categories, null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                {!! CollectiveForm::hidden('agent_id', 'auto') !!}
                @if (Request::is($setting->grab('main_route_path')."/crm-ticket"))
                    {!! CollectiveForm::hidden('ticket_for', 'superadmin') !!}
                @endif
            </div>
            <br>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    {!! link_to_route($setting->grab('main_route').'.index', trans('ticketit::lang.btn-back'), null, ['class' => 'btn btn-default']) !!}
                    {!! CollectiveForm::submit(trans('ticketit::lang.btn-submit'), ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        {!! CollectiveForm::close() !!}
    </div>
@endsection

@section('footer')
    @include('ticketit::tickets.partials.summernote')

    <script>
        $('document').ready(function(){
            var subcategories = {!! json_encode($subcategories) !!};
            console.log(subcategories);
            let val = $('.cat option:selected').val();

            var options = ''
            subcategories[val].forEach(function(item, index){
                options += '<option value="'+item.id+'">'+item.name+'</option>'
            });
             
            let el =   '<label for="subcategory" class="col-lg-6 control-label">Sub Category: </label>'
                el +=       '<div class="col-lg-6">';
                el +=           '<select class="form-control" required="required" name="subcategory_id">';

                el +=               options;

                el +=           '</select>';
                el +=       '</div>';
                                
            $('.subcat').html(el);
        });

        function selectCategory(ev){
            console.log(ev);
            var subcategories = {!! json_encode($subcategories) !!};
            if(subcategories[ev]){
                var options = ''
                subcategories[ev].forEach(function(item, index){
                    options += '<option value="'+item.id+'">'+item.name+'</option>'
                });
                let el =   '<label for="subcategory" class="col-lg-6 control-label">Sub Category: </label>'
                    el +=       '<div class="col-lg-6">';
                    el +=           '<select class="form-control" required="required" name="subcategory_id">';

                    el +=              options;

                    el +=           '</select>';
                    el +=       '</div>';
                                    
                $('.subcat').html(el);
            }else{
                $('.subcat').html('');
            }
        }
    </script>
@append