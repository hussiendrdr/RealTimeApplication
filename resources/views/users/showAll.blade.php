@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <div class="card-body">
                                <ul id="users">

                                </ul>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        fetch('/api/users')
            .then(response => response.json())
            .then(data => {
                const usersElement = document.getElementById('users');
                // Now we have our data, we can use a forEach loop to display it
                data.forEach(user => {
                    let element = document.createElement('li');

                                element.setAttribute('id', user.id);
                                element.innerText = user.name;

                                usersElement.appendChild(element);                });
            })
            .catch(error => console.error('Error:', error));


{{--        @push('scripts')--}}
{{--        <script>--}}
{{--        window.axios.get('/api/users')--}}
{{--        .then((response) => {--}}
{{--            const usersElement = document.getElementById('users');--}}

{{--            let users = response.data;--}}

{{--            users.forEach((user, index) => {--}}
{{--            let element = document.createElement('li');--}}

{{--            element.setAttribute('id', user.id);--}}
{{--            element.innerText = user.name;--}}

{{--            usersElement.appendChild(element);--}}
{{--        });--}}
{{--        });--}}
{{--    </script>--}}

{{--



{{--                });--}}
        </script>
    <script type="module">
        Echo.channel('users')
            .listen('UserCreated', (e) => {
                const usersElement = document.getElementById('users');

                let element = document.createElement('li');

                element.setAttribute('id', e.user.id);
                element.innerText = e.user.name;

                usersElement.appendChild(element);
            })
            .listen('UserUpdated', (e) => {
                const element = document.getElementById(e.user.id);
                element.innerText = e.user.name;
            })
            .listen('UserDeleted', (e) => {
                const element = document.getElementById(e.user.id);
                element.parentNode.removeChild(element);
            });
    </script>

    @endpush
