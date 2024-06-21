@extends('template.template_view')


@section('content')
    <section class="py-5">
        <div class="container px-5">
            <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                            class="bi bi-link-45deg"></i></div>
                    <h1 class="fw-bolder">Short Link</h1>
                    <p class="lead fw-normal text-muted mb-0"></p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-12 col-xl-12">
                        <form enctype="multipart/form-data" name="frm_shortened" id="frm_shortened" method="post">
                            <table id="table" data-toggle="table" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Full Name</th>
                                        <th>Original URL</th>
                                        <th>Short URL</th>
                                        <th>Create Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_data"></tbody>
                            </table>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.0/bootstrap-table.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.0/bootstrap-table.js"></script>


    <script type="text/javascript">
        function delete_shortenedURLs(id) {
            swal.fire({
                title: '',
                text: 'Confirm delete data.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then(function(result) {

                if (result.isConfirmed) {

                    url = "{{ url('delete_shortenedURLs') }}";
                    var formData = {
                        id: id
                    };

                    form_ajax_customdata(url, formData, function(data) {

                        if (data.status) {
                            alert_success('Delete success.');
                            load_data();
                        }
                        return false;
                    });
                }
            });

            return false;
        }

        function load_data() {
            url = "{{ url('load_view_shortenedURLs') }}";
            form_ajax(url, "frm_shortened", 'post', function(data) {

                if (data.status) {
                    $("#tb_data").html(data.datahtml);
                }
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            load_data();
        });
    </script>
@endsection
