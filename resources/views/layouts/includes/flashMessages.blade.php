@if(Session::has('success') || Session::has('danger'))
<script>
	@if(Session::has('success'))
    	toastr.success("{{ Session::get('success') }}");
    @elseif(Session::has('danger'))
    	toastr.error("{{ Session::get('danger') }}");
    @endif
</script>
@endif

@if($errors->any())
    <script>
        toastr.error("Hatalar var.");
    </script>
@endif


