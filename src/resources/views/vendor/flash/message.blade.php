@foreach (session('flash_notification', collect())->toArray() as $message)
    @push('scripts')
        @if($message['level'] == 'danger'){
            {{$message['level'] = 'error'}}
        @endif
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "debug": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
            }
            toastr["{{$message['level']}}"]("{{$message['message']}}")
        </script>
    @endpush
@endforeach
{{ session()->forget('flash_notification') }}

