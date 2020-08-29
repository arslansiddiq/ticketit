<div class="panel panel-default">
    <div class="panel-body">
        @if(!$u->isAdmin() && !$u->isAgent())
            {!! CollectiveForm::open(['method' => 'POST', 'route' => $setting->grab('main_route').'-comment.store', 'class' => 'form-horizontal']) !!}
        @else
            {!! CollectiveForm::open(['method' => 'POST', 'route' => $setting->grab('main_route').'-comment.store', 'class' => 'form-horizontal comment-form']) !!}
        @endif
        
            {!! CollectiveForm::hidden('ticket_id', $ticket->id ) !!}
            {!! CollectiveForm::hidden('status_change', null ,['class' => 'status_change']) !!}

            <fieldset>
                <legend>{!! trans('ticketit::lang.reply') !!}</legend>
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! CollectiveForm::textarea('content', null, ['class' => 'form-control summernote-editor', 'rows' => "3"]) !!}
                    </div>
                </div>

                @if(!$u->isAdmin() && !$u->isAgent())
                    <div class="text-right col-md-12">
                        {!! CollectiveForm::submit( trans('ticketit::lang.btn-submit'), ['class' => 'btn btn-primary reply-submit']) !!}
                    </div>
                @else
                    <div class="text-right col-md-12">
                        {!! CollectiveForm::submit( trans('ticketit::lang.btn-submit'), ['class' => 'btn btn-primary']) !!}
                    </div>
                @endif
                {{-- <div class="text-right col-md-12">
                    {!! CollectiveForm::submit( trans('ticketit::lang.btn-submit'), ['class' => 'btn btn-primary']) !!}
                </div> --}}

            </fieldset>
        {!! CollectiveForm::close() !!}
    </div>
</div>
