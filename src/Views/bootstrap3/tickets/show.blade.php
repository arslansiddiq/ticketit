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
{{-- {!! json_encode($status_lists) !!} --}}
    <script>
        $('document').ready(function(){
            var subcategories = {!! json_encode($subcategories) !!};
            let val = $('.cat option:selected').val();

            if(typeof(subcategories[val]) !== 'undefined' && subcategories[val] !== '' && subcategories[val] !== null){
                $('.subcat').html(generateDropdown(val,subcategories));
            }else{
                $('.subcat').html('');
            }

            // Form Submit Handling
            $(".comment-form").submit(function( event ) {
              event.preventDefault();
              let sel_el = generateStatusesSelectBox();
              Swal.fire({
                      title: 'Do you want to change the status of this ticket?',
                      html: sel_el +
                          "<br><br><div class='row col-lg-12' style='margin-top: 20px;'>" +
                          '<button type="button" role="button" tabindex="0" class="btn btn-danger skip-pop">' + 'Skip' + '</button>' +
                          '<button type="button" role="button" tabindex="0" class="btn btn-primary submit-pop">' + 'Submit' + '</button></div>',
                      showCancelButton: false,
                      showConfirmButton: false
                  });
            });
            $(document).on('click', '.submit-pop', function(e) {
                e.preventDefault();
                let value = $('.selected_status option:selected').val();
                console.log(value);
                $('.status_change').val(value);
                console.log('Submit clicked!!!!!!');
                $(".comment-form").off().submit();
                Swal.close();
            });
            $(document).on('click', '.skip-pop', function(e) {
                e.preventDefault();
                $('.status_change').val(null);
                console.log('Submit clicked!!!!!!');
                $(".comment-form").off().submit();
                Swal.close();
            });
            
        });

        function selectCategory(ev){
            var subcategories = {!! json_encode($subcategories) !!};
            if(typeof(subcategories[ev]) !== 'undefined' && subcategories[ev] !== '' && subcategories[ev] !== null){
                $('.subcat').html(generateDropdown(ev,subcategories));
            }else{
                $('.subcat').html('');
            }
        }

        // generate Dropdown Element HTML
        function generateDropdown(id,subcategories)
        {
            var seleted_ = "{{ $selected_subcategory }}"
            var options = ''
            subcategories[id].forEach(function(item, index){
                if(seleted_ == item.id){
                    options += '<option selected="selected" value="'+item.id+'">'+item.name+'</option>'
                }else{
                    options += '<option value="'+item.id+'">'+item.name+'</option>'
                }
            });
            let el =   '<label for="subcategory" class="col-lg-6 control-label">Sub Category: </label>'
                el +=       '<div class="col-lg-6">';
                el +=           '<select class="form-control" required="required" name="subcategory_id">';
                el +=               '<option selected="selected" value="">Please Select</option>';
                el +=              options;

                el +=           '</select>';
                el +=       '</div>';
            return el;
        }

        function generateStatusesSelectBox(){
            var statuses = {!! json_encode($status_lists) !!}
            var options = ''
            Object.keys(statuses).forEach(key => {
                options += '<option value="'+key+'">'+statuses[key]+'</option>'
            });
            let el =   '<label for="status-popup" class="col-lg-12 control-label">Select Status: </label>'
                el +=       '<div class="col-lg-12">';
                el +=           '<select class="form-control selected_status" name="selected_status">';
                el +=               '<option selected="selected" value="">Please Select</option>';
                el +=              options;
                el +=           '</select>';
                el +=       '</div>';
            return el;
        }
        // Reply Submit if user is agent or Super Admin
    </script>
@append
