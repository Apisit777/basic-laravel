<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <!-- Styles -->
    <style>
    </style>
</head>

<div class="relative flex min-h-screen items-top bg-[#E7EDEF] dark:bg-[#202020] flex justify-center items-center">
    <div class="absolute top-20 w-10/12">
        <div class='w-10/12'>
            <div class="modal-body block-content">
                <form action="" {{ url('saveimportfile') }} method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="pg_users" id="pg_users">
                    <input type="submit" value="Upload" name="submit">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" data-auto-replace-svg="nest"></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
</script>
