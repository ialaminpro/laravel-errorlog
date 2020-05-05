
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="https://getbootstrap.com/docs/3.3/favicon.ico">
        <link rel="canonical" href="https://getbootstrap.com/docs/3.3/examples/starter-template/">

        <title>Error Logos</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="https://getbootstrap.com/docs/3.3/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="https://getbootstrap.com/docs/3.3/examples/starter-template/starter-template.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="https://getbootstrap.com/docs/3.3/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="https://getbootstrap.com/docs/3.3/assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

    <div class="container">


        <h1>Error Logs</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row justify-content-end">
                        <div class="col-md-10">
                            <div id="error_filter" class=" float-right mb-2">
                                <form action="{{url('error-logs')}}" method="get" name="result_filter" id="error_search" class="form-inline  search_section hidden-sm hidden-xs" role="form">
                                    <div id="custom_search_area">
                                        <input style="width: 150px; display: inline-block; margin-right: 10px;" name="search_string" id="custom_search_p" class="form-control" type="text" value="{{request('search_string','')}}" placeholder="Search..">
                                        <select style="width: 150px; display: inline-block; margin-right: 10px;" name="type" id="select_filter" class="form-control">
                                            <option value="" @if(request('type')=='')selected @endif>All</option>
                                            <option value="1" @if(request('type')=='1')selected @endif>Resolved</option>
                                            <option value="0" @if(request('type')=='0')selected @endif>Unresolved</option>
                                        </select>
                                        <div class="search_tools" style="display: inline-block; margin-right: 0px;">
                                            <button type="submit" class="btn btn-success  btn-rounded" data-style="zoom-in" >
                                                <span class="ladda-label"><i class="fa fa-search"></i></span><span class="ladda-spinner"></span>
                                            </button>

                                            <button type="button" class="btn btn-warning reset_button  btn-rounded" data-style="zoom-in">
                                                <span class="ladda-label"><i class="fa fa-refresh"></i></span><span class="ladda-spinner"></span>
                                            </button>
                                        </div>
                                    </div>


                                </form>

                            </div>
                        </div>
                        <div class="col-md-2" style="text-align: right;"><button type="button" id="btn-confirm" class="delete btn btn-danger" name="btn"><i class="fa fa-trash"></i>  Delete All  </button></div>

                    </div>
                    <br>

                    <div class="table-responsive mt-20">
                        <table class="table table-bordered " id="error_log_table" role="grid" aria-describedby="error_log_table_info">
                            <thead>
                            <tr role="row" class="btn-info">
                                <th class=" text_center" tabindex="0"  aria-controls="error_log_table">Action</th>

                                <th class=" text_center" tabindex="0"  aria-controls="error_log_table">Created On </th>

                                <th class=" text_center" tabindex="0"  aria-controls="error_log_table">Exception</th>

                                <th class=" text_center" tabindex="0"  aria-controls="error_log_table">Resolved</th>

                                <th class=" text_center" tabindex="0"  aria-controls="error_log_table">Filename</th>

                                <th class=" text_center" tabindex="0"  aria-controls="error_log_table">Page URL</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($error_logs as $error_log)
                                <tr id="tr-{{ $error_log->id }}">
                                    <td class="vertical_center">
                                        <button data-toggle="modal" data-target="#view-deails-{{ $error_log->id }}" title="View Error Details" style="margin-bottom: 3px;" class="btn btn-xs btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button title="Unresolve" data-logid="{{$error_log->id}}" data-isresolved="1" style="margin-bottom: 3px;" id="un_resolve_button" class="btn btn-xs btn-warning resolve-button @if($error_log->is_resolved!=1) active @endif">
                                            <i class="fa fa-warning"></i> <!-- will change from js; same for the icon -->
                                        </button>

                                        <button title="Resolve" data-logid="{{$error_log->id}}" data-isresolved="" style="margin-bottom: 3px;" id="resolve_button" class="btn btn-xs btn-success resolve-button @if($error_log->is_resolved==1) active @endif">
                                            <i class="fa fa-check"></i> <!-- will change from js; same for the icon -->
                                        </button>

                                        <button title="Delete" style="margin-bottom: 3px;" class="btn btn-xs btn-danger delete-button" data-logid="{{ $error_log->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                    <td class="vertical_center">
                                        <span class="hidden">{{ strtotime($error_log->created_at) }}</span>
                                        {{ date('M d, Y', strtotime($error_log->created_at)) }}

                                    </td>

                                    <td class="vertical_center">
                                                    <span data-toggle="modal" data-target="#view-deails-{{ $error_log->id }}">
                                                        {{substr($error_log->exception_message, 0, 26)}}...
                                                    </span>

                                        <div class="modal fade" id="view-deails-{{ $error_log->id }}" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                        <h4 class="modal-title">Error Details</h4>
                                                    </div>
                                                    <div class="modal-body text-justify">
                                                        @if($error_log->screenshot)
                                                            <img class="img-responsive" src="{{ $error_log->screenshot }}">
                                                            <br>
                                                        @endif
                                                        <p>
                                                            <strong>Error Occured at</strong>: {{ date('M d, Y h:i:s a', strtotime($error_log->created_at)) }}

                                                        </p>
                                                        <p>
                                                            <strong>Error link</strong>: {{ $error_log->page_url }}

                                                        </p>


                                                        <p>
                                                            <strong>File Path </strong>: {{ $error_log->file_path }}
                                                        </p>

                                                        <p>
                                                            <strong>Line No </strong>: {{ $error_log->line_number }}
                                                        </p>

                                                        <p>
                                                            <strong>Method Name </strong>: {{ $error_log->method_name }}
                                                        </p>

                                                        <p>
                                                            <strong>Arguments </strong>: {{ $error_log->arguments }}
                                                        </p>

                                                        <p>
                                                            <strong>Object  </strong>: {{ $error_log->object }}
                                                        </p>

                                                        <p>
                                                            <strong>Type </strong>: {{ $error_log->type }}
                                                        </p>

                                                        <p>
                                                            <strong>Postfix/Domain </strong>: {{ $error_log->prefix }} | {{ $error_log->domain }}
                                                        </p>

                                                        <p>
                                                            <strong> Error Details:</strong>
                                                            <br/>
                                                            <code id="error-log-message-{{ $error_log->id }}">{{ $error_log->exception_message }}</code>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="vertical_center">
                                        @if($error_log->is_resolved==1) Resolved @else Unresolve @endif
                                        {{--                                            <span class="is-resolved-text">...</span>--}}
                                        {{--                                            <span class="hidden is-resolved-text-hidden">y-resolved-loading</span>--}}
                                    </td>
                                    <td class="vertical_center">
                                        <span class="word-break">{{ basename($error_log->file_path) }}</span>
                                    </td>
                                    <td class="vertical_center">
                                                    <span class="word-break"><a href="{{ $error_log->page_url  }}" title="{{ $error_log->page_url }}">
                                                        {{ $error_log->page_url }}
                                                    </a></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" id="sample_1_2_info" role="status" aria-live="polite"></div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_2_paginate">
                                <ul class="pagination" style="visibility: visible;">
                                    {{$error_logs->links()}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div><!-- /.container -->

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="warning_modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">Are you sure? You want to delete all records.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
                    <button type="button" class="btn btn-danger" id="modal-btn-si">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/3.3/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/3.3/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://getbootstrap.com/docs/3.3/assets/js/ie10-viewport-bug-workaround.js"></script>
    <script>
        var table_id = "error_log_table"; // keep this DRY for the future. Keep id here without the preceding # as we might use native selector amytime in the future.

        $(document).ready(function() {

            var modalConfirm = function(callback){

                $("#btn-confirm").on("click", function(){
                    $("#warning_modal").modal('show');
                });

                $("#modal-btn-si").on("click", function(){
                    $("#warning_modal").modal('hide');
                    callback(true);

                });

                $("#modal-btn-no").on("click", function(){
                    $("#warning_modal").modal('hide');
                    callback(false);

                });
            };

            modalConfirm(function(confirm){
                if(confirm){
                    $("#warning_modal").modal('hide');
                    delete_all_error_log();
                }else{

                }
            });

            $(document).on('click','.fa-refresh',function(){
                //window.location.href="{{url('error-logs')}}";
            });

            $(document).on('click','.delete-button',function(){
                //var table = $("#" + table_id).DataTable();

                var log_id = $(this).data('logid');


                $.ajax({
                    url: "{{url('error-logs/delete')}}/" + log_id,
                }).done(function() {
                    var $tr = $("#tr-" + log_id);
                    $("#tr-" + log_id).remove();
                    //table.row($tr).remove();
                    //table.draw(false);
                    alert('Successfully deleted');
                }).fail(function () {
                    alert('Could Not Delete: ' + log_id);
                });
            });

            // resolve log
            $(document).on('click','.resolve-button',function(){

                var button = $(this);
                var title = $(this).attr('title');
                var log_id = button.data('logid');

                $.ajax({
                    url: "{{url('error-logs/toggle-resolve')}}/" + log_id,
                }).done(function(data) {
                    if(data.status == 200){
                        alert(data.reason);
                    }
                    //action_resolve_toggle($button);
                    if(title=='Unresolve'){
                        button.parents('.vertical_center').find('#un_resolve_button').addClass('d-none');
                        button.parents('.vertical_center').find('#resolve_button').removeClass('d-none');
                    }
                    else{
                        button.parents('.vertical_center').find('#un_resolve_button').removeClass('d-none');
                        button.parents('.vertical_center').find('#resolve_button').addClass('d-none');
                    }
                }).fail(function () {
                    alert('Not Resolved: ' + log_id);
                });
            });


            // initialize search
            $("#custom_search_p").on( 'keyup', function () {
            });

            $('#select_filter').change(function(){
                $('#error_search').submit();

            });
        });



        function delete_all_error_log(){

            var url = "{{ url('error-logs/delete_all') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {'_token':'{{ csrf_token() }}'},
                async: false,
                success: function (data) {
                    if(data.status == 200){
                        alert(data.reason);
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }
                    else{
                    }
                }
            });
        }

        $(document).on('click','.reset_button',function(){
            location.reload();
        })


    </script>
    </body>
</html>
