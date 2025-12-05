@php
    $toastTypes = [
        'toast_success' => 'success',
        'toast_error' => 'error',
        'toast_warning' => 'warning',
        'toast_info' => 'info',
        'toast_question' => 'question',
    ];

    $toast = null;

    foreach ($toastTypes as $key => $type) {
        if (session()->has($key)) {
            $toast = [
                'type' => $type,
                'message' => session($key)
            ];
            break;
        }
    }
@endphp

@if ($toast)
    <style>
        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
        }

        .colored-toast .swal2-title,
        .colored-toast .swal2-close,
        .colored-toast .swal2-html-container {
            color: white;
        }
    </style>

    <script type="module">
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        });

        Toast.fire({
            icon: '{{ $toast['type'] }}',
            title: @js($toast['message']),
        });
    </script>
@endif
