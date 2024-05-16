@extends('layouts.admin')
@section('content')
    <p></p>
    {{-- <img src="{{ asset('assets/img/comming_soon.jpg') }}" alt=""> --}}
@endsection
@push('script-page')
    <script>
        // Select the element with the class 'page-content'
        var pageContentDiv = document.querySelector('.page-content');

        // Set the background image and properties
        pageContentDiv.style.width = "100%";
        pageContentDiv.style.height = "250px";
        pageContentDiv.style.backgroundImage = "url({{ asset('assets/img/comming_soon.jpg') }})";
        pageContentDiv.style.backgroundRepeat = 'no-repeat';
        pageContentDiv.style.backgroundSize = 'cover'; // or 'contain' based on your preference
        pageContentDiv.style.backgroundPosition = 'center'; // Optional: Center the image
    </script>
@endpush
