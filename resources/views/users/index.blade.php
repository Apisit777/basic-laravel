<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <!-- Styles -->
    <style>
    .hide-success .active{
        transition: all 5s;
        /* transition-timing-function: 5s ease-in;
        transition: 5s; */
        visibility: visible;
        opacity: 1;
    }
    .hide-success .active{
        transform: translateY(-130%);
        transition-timing-function: ease-in;
        transition: 1s;
        visibility: hidden;
        opacity: 0;
    }
    .closebtn {
        position: absolute;
        top: 7px;
        right: 10px;
        color: rgb(92, 92, 92);
        /* font-weight: bold; */
        float: right;
        font-size: 15px;
        line-height: 20px;
        cursor: pointer;
    }
    </style>
</head>
@if($errors->any())
    <div class="" style="position: absolute; right: 0; z-index: 100">
        <div class="alert alert-danger active" id="messageError" style="display: flex; flex-wrap: wrap; align-items: center;">
            <i class="fa fa-exclamation-circle" style="font-size: 20px"></i>
            &nbsp;{{ implode('', $errors->all(':message')) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fa fa-times closebtn" aria-hidden="true"></i>
        </div>
    </div>
@endif

<div class="hide-success" style="position: absolute; right: 0; z-index: 100">
    <div class="alert alert-success @if(!$message = Session::get('success')) active @endif" id="messageSuccess" style="display: flex; flex-wrap: wrap; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </svg>
        &nbsp;{{ $message }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="fa fa-times closebtn" aria-hidden="true"></i>
    </div>
</div>

<div class="relative flex min-h-screen items-top bg-[#E7EDEF] dark:bg-[#202020] flex justify-center items-center">
    <div class="absolute top-20 w-10/12">
        <div class="relative text-md mb-10 w-5/6 p-7 mb-20 rounded-md bg-[#202020]/[0.80] mx-auto flex justify-center shadow-md shadow-red-500">
            <div class="flex justify-center items-center bg-[#101010]/[.60] w-auto py-2 rounded-sm my-30 mx-auto text-center text-white absolute -top-16 shadow-md shadow-red-500">
                <h1 class="text-lg text-gray-900 dark:text-white p-2">Add Or Remove Multiple Input Fields In Laravel</h1>
            </div>

            <div class='w-10/12'>
                {{-- <div class="flex justify-center items-center p-5 bg-[#101010]/[.60] w-auto py-2 rounded-sm my-30 mx-auto text-center text-white absolute right-5 -top-5 shadow-md shadow-red-500">
                    <h1 class="text-gray-900 dark:text-white">Post Method API</h1>
                </div> --}}
                {{-- <div class="pb-5">
                    <div class="flex items-center text-gray-900 dark:text-white">
                        <span class="text-gray-900 dark:text-white text-sm">Name</span>
                    </div>
                    <input class="w-11/12" type="text" name="name"  v-model="name" placeholder="Name">
                </div> --}}
                <form action="/post" method="POST">
                    @csrf
                    <table class="table table-bordered" id="table">
                        <tr>
                            <th class="text-white dark:text-white text-sm">Name</th>
                            <th class="text-white dark:text-white text-sm">Action</th>
                        </tr>
                        <tr>
                            <td><input class="w-11/12 text-gray-900 text-sm form-control" type="text" name="inputs[0][name]" placeholder="Name"></td>
                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                        </tr>
                    </table>
                    <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-lg hover:bg-blue-900 focus:outline-none">
                        Add New User
                    </button>
                </form>
            </div>
        </div>

        @php
            echo "<div class='text-white dark:text-white text-sm'>" . $_SERVER['HTTP_USER_AGENT']; "</div>";
            echo "<br>";
            echo "<div class='text-white dark:text-white text-sm'> PHP (v" . phpversion(); ")  </div>";
        @endphp
        <br>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        <br><br><br><br>

        <div class="relative text-md mb-10 w-5/6 p-7 rounded-md bg-[#202020]/[0.80] mx-auto flex justify-center shadow-md shadow-red-500">
            <div class="flex justify-center items-center bg-[#101010]/[.60] w-auto py-2 rounded-sm my-30 mx-auto text-center text-white absolute -top-16 shadow-md shadow-red-500">
                <h1 class="text-lg text-gray-900 dark:text-white p-2"> Add Cars </h1>
            </div>
            <div class='w-10/12'>
                <div class="modal-body block-content">
                    <form id="formbrand">
                        <div class="row" style="position: relative;">
                            <div class="col-12">
                                {{-- (ยี่ห้ อรถ) --}}
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label d-block text-white dark:text-white text-sm"> ยี่ห้อรถยนต์<span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control" id="id_brand" name="name" onkeyup="checkNameBrand()">
                                    </div>
                                    <div class="col-auto" style="position: absolute; right: 2%; top: 67%;">
                                        <span id="username_loading" class="spinner-border spinner-border-sm text-primary"></span>
                                        <i class="fa fa-check-circle text-success" id="correct_username" style="font-size: 15px;"></i>
                                        {{-- <i class="fa fa-times-circle text-danger" id="username_alert" style="font-size: 20px;"></i> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-5">

                        <button
                            type="button"
                            data-te-ripple-init
                            class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            Button
                        </button>

                        <hr class="mt-5">
                        <div class="modal-footer block-content">
                            <button type="submit" id="submitButton" class="btn btn-info text-white dark:text-white" modal-bs-toggle="">Save</button>
                            <button type="button" class="btn btn-danger me-1" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" data-auto-replace-svg="nest"></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
    // jQuery.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    let i = 0;
    $('#add').click( () => {
        ++i;
        $('#table').append(
            `<tr>
                <td>
                    <input class="w-11/12 text-gray-900 text-sm form-control" type="text" name="inputs[`+ i +`][name]" placeholder="Name">
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-table-row">Remove</button>
                </td>
            </tr>`);
    });
    console.log("Index: ", ++i)
    $(document).on('click', '.remove-table-row', function() {
        $(this).parents('tr').remove();
    });

    const dlayMessage = 3000;

    setTimeout(function() {
        $('#messageSuccess').addClass('d-none')
        $('#messageError').addClass('d-none')
    },dlayMessage)

    // event.preventDefault();

    jQuery('#username_loading').hide();
    jQuery("#username_alert").hide();
    jQuery("#correct_username").hide();

    function checkNameBrand() {
        const edit_id = jQuery('#edit_id').val();
        const name = jQuery('#id_brand').val();

        jQuery.ajax({
            method: "POST",
            url: '{{ route('checknamebrand') }}',
            data: {
                    _token: "{{ csrf_token() }}",
                    edit_id, name
                },
            dataType: 'json',
            beforeSend: function () {
                jQuery("#submitButton").attr("disabled", true);
                jQuery('#username_loading').show();
                jQuery("#correct_username").hide();
                jQuery("#username_alert").hide();
            },
            success: function (checknamebrand) {
                jQuery('#username_loading').hide();
                jQuery("#correct_username").hide();

                if (name == '') {
                    jQuery("#submitButton").attr("disabled", false);
                    jQuery("#correct_username").hide();
                    jQuery("#username_alert").hide();
                    jQuery("#id_brand").removeClass("is-invalid");
                } else if (checknamebrand == true) {
                    jQuery("#submitButton").attr("disabled", false);
                    jQuery("#username_alert").hide();
                    jQuery("#id_brand").removeClass("is-invalid");
                    jQuery("#correct_username").show();
                } else {
                    jQuery("#username_alert").show();
                    jQuery("#id_brand").addClass("is-invalid");
                    jQuery("#correct_username").hide();
                }
            },
            error: function (params) {
            }
        });
    }
</script>
