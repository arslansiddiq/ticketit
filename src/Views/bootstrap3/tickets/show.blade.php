@extends($master)
@section('page', trans('ticketit::lang.show-ticket-title') . trans('ticketit::lang.colon') . $ticket->subject)
@section('content')
        @include('ticketit::shared.header')
        @include('ticketit::tickets.partials.ticket_body')
        <br>
        <h2>{{ trans('ticketit::lang.comments') }}</h2>
        @include('ticketit::tickets.partials.comments')
        {{-- pagination --}}
        {!! $comments->render() !!}
        @include('ticketit::tickets.partials.comment_form')
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $( ".deleteit" ).click(function( event ) {
                event.preventDefault();
                if (confirm("{!! trans('ticketit::lang.show-ticket-js-delete') !!}" + $(this).attr("node") + " ?"))
                {
                    var form = $(this).attr("form");
                    $("#" + form).submit();
                }

            });
            $('#category_id').change(function(){
                var loadpage = "{!! route($setting->grab('main_route').'agentselectlist') !!}/" + $(this).val() + "/{{ $ticket->id }}";
                $('#agent_id').load(loadpage);
            });
            $('#confirmDelete').on('show.bs.modal', function (e) {
                $message = $(e.relatedTarget).attr('data-message');
                $(this).find('.modal-body p').text($message);
                $title = $(e.relatedTarget).attr('data-title');
                $(this).find('.modal-title').text($title);

                // Pass form reference to modal for submission on yes/ok
                var form = $(e.relatedTarget).closest('form');
                $(this).find('.modal-footer #confirm').data('form', form);
            });

            <!-- Form confirm (yes/ok) handler, submits form -->
            $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
                $(this).data('form').submit();
            });
        });
    </script>
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
