@extends('template.template_view')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <!-- Contact form-->
            <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                            class="bi bi-link-45deg"></i></div>
                    <h1 class="fw-bolder">URL Shortener</h1>
                    <p class="lead fw-normal text-muted mb-0"></p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">

                        {{-- autocomplete="off" --}}
                        <form enctype="multipart/form-data" name="frm_shortened" id="frm_shortened"
                            onsubmit="return onclick_shorten();" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="original_url" name="original_url"
                                    placeholder="Enter URL here . . ." type="text" />
                                <label for="original_url">URL</label>
                                <span id="msg" class="text-danger"></span>
                            </div>


                            <div class="text-center"><button class="btn btn-primary btn-lg" id="btn_shorten"
                                    type="submit">Shorten URL</button>
                                <button class="btn btn-warning btn-lg" id="btn_clear" type="button">Clear</button>
                            </div>



                            <div role="alert" class="alert alert-info shadow-lg mt-3 div_shorten_url"
                                style="display: none">
                                <div class="d-flex">
                                    <div class="mr-auto"><span>

                                            <a href="" target="_blank" class="alert-link" id="shorten_link">
                                                <span id="shorten_url">shorten_url</span></a>
                                        </span>

                                    </div>
                                    <div style="right: 5px; position: absolute;"> <button type="button"
                                            class="btn btn-primary d-none d-sm-none d-md-inline" id="copy-btn"
                                            onclick="copyText('shorten_url');">
                                            <i aria-hidden="true" class="fa fa-copy"></i>
                                            Copy Link </button></div>
                                </div>

                                <div>
                                    <span class="d-md-inline">
                                        <span class="d-none d-lg-inline" id="txt_oiginal_url">oiginal_url</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        const clearButton = $("#btn_clear");
        clearButton.on("click", (event) => {
            event.preventDefault();
            $('#frm_shortened input').val('');
            $('.div_shorten_url').hide();
        });

        function onclick_shorten() {
            url = "{{ url('create_shortened_url') }}";
            console.log(url);
            form_ajax(url, "frm_shortened", 'post', function(data) {
                console.log(data);
                if (data.status) {
                    txt_oiginal_url
                    $('#txt_oiginal_url').html(data.original_url);

                    var shorten_url = data.shorten_url;
                    $('#shorten_url').text(shorten_url);
                    $('#shorten_link').attr('href', shorten_url);

                    $('#msg').html('');
                    $('.div_shorten_url').show();

                } else {
                    if (data.redirect_url != '') {
                        window.location.href = data.redirect_url;
                    } else {
                        $('#msg').html(data.msg);
                        $('.div_shorten_url').hide();
                    }
                }
                return false;
            });

            return false;
        }

        function copyText(element) {
            var $copyText = document.getElementById(element).innerText;
            navigator.clipboard.writeText($copyText).then(function() {}, function() {
                button.style.cssText = "background-color: var(--red);";
                button.innerText = 'Error';
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
@endsection
