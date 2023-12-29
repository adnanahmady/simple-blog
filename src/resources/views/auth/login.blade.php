@php use App\Http\Requests\Web\Auth\LoginRequest; @endphp

@extends('layout.app')

@section('content')
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-100 selection:bg-red-500 selection:text-white">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="p-10 dark:bg-gray-300 rounded mt-10 sm:mx-auto sm:w-full sm:max-w-sm shadow-2xl border-1">
                <form action="{{ route('web.login.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST')
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6">Email address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3">
                        </div>
                        @if($errors->has(LoginRequest::EMAIL))
                            <div class="mt-2">
                                @foreach($errors->get(LoginRequest::EMAIL) as $error)
                                    <span class="text-red-700">{{ $error }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                   required
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3">
                        </div>
                        @if($errors->has(LoginRequest::PASSWORD))
                            <div class="mt-2">
                                @foreach($errors->get(LoginRequest::PASSWORD) as $error)
                                    <span class="text-red-700">{{ $error }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit"
                                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
