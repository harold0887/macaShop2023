@push('js')
@if(session('success'))
<script>
    swal("¡Buen trabajo!", "{{session('success')}}", "success");
</script>
@endif


@if(session('success-auto-close'))
<script>
    alertFloat();

    function alertFloat() {
        type = ["info", "danger", "success", "warning", "rose", "primary"];

        color = Math.floor(Math.random() * 6 + 1);

        $.notify({
            icon: "check_circle",
            message: "{{session('success-auto-close')}}",
        }, {
            type: type[color],
            timer: 3000,
            placement: {
                from: "top",
                align: "right",
            },
        });
    }
</script>
@endif


@if (session('error'))
<script>
    swal("¡error!", "{{session('error')}}", "error");
</script>
@endif

@if (session('status'))
<script>
    swal("¡Buen trabajo!", "{{session('status')}}", "success");
</script>
@endif




@endpush