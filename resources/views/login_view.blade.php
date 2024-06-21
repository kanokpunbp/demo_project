@extends('template.template_view')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <!-- Contact form-->
            <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                            class="bi bi-key"></i></div>
                    <h1 class="fw-bolder">Login</h1>
                    
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">

                        <form enctype="multipart/form-data" name="frm_login" id="frm_login" autocomplete="off"
                            onsubmit="return onclick_login();" method="post">
                        
                            <div class="form-floating mb-3">
                                <input class="form-control" id="txt_username" name="txt_username" type="text" />
                                <label for="txt_username">Username/Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="txt_password" name="txt_password" type="password" />
                                <label for="txt_password">Password</label>
                            </div>

                            <span id="submitErrorMessage" class="text-center text-danger mb-3"></sapn>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" id="btn_login" type="submit">Login</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function validation_data() {

            var checkiSerror = false;  
            checkiSerror = validateField(checkiSerror, '#txt_username', 'Please Input Username/Email');
            checkiSerror = validateField(checkiSerror, '#txt_password', 'Please Input Password');

            if (checkiSerror == true) {
                $('.error').first().focus();
                $([document.documentElement, document.body]).animate({
                    scrollTop: parseInt($(".error").offset().top) - 150
                }, 1000);
                return false;
            } else {
                return true;
            }

        }


        function onclick_login() {

            if (validation_data()) {
                url = "{{ url('ajax_login') }}";

                form_ajax(url, "frm_login", 'post', function(data) {
                    if (data.status) {
                        setTimeout(function() {
                            window.location = "{{ url('/') }}"
                        }, 1000);
                    } else {
                        $('#submitErrorMessage').html(data.msg);
                        return false;
                    }
                });
            }

            return false;
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
