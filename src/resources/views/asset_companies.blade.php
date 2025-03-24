@extends('base')

@section('content')
    @livewire('company-manager')
@endsection
@section('config')
    <script>
        $(document).ready(function() {
            $('#companyTable').DataTable({
                pageLength: 10
            });
        });
    </script>
@endsection
