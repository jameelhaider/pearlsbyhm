@extends('layouts.app')
@section('title', 'Change Password - '.site_name())

@section('content')
    <div class="container py-4 px-3">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                 <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
            </ol>
        </nav>

        {{-- Page Title --}}
        <div class="text-center mb-3">
            <h4 class="fw-bold" style="font-family: Arimo, sans-serif; letter-spacing: 1px;">
                CHANGE YOUR PASSWORD
            </h4>
            <p class="text-muted mt-2" style="font-family: Arimo, sans-serif;">
                Please enter your current password to set a new one.
            </p>
        </div>

        {{-- Form --}}
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <form method="POST" action="{{ route('change.password.save') }}">
                    @csrf

                    {{-- Current Password --}}
                    <div class="mb-3">
                        <label for="current_password" class="form-label custom-font">
                            Current Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" id="current_password" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            placeholder="Enter current password" required>
                        @error('current_password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="mb-3">
                        <label for="new_password" class="form-label custom-font">
                            New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" id="new_password" name="new_password"
                            class="form-control @error('new_password') is-invalid @enderror"
                            placeholder="Enter new password" required>
                        @error('new_password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label custom-font">
                            Confirm New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="form-control @error('new_password_confirmation') is-invalid @enderror"
                            placeholder="Re-enter new password" required>
                        @error('new_password_confirmation')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="text-center">
                        <button type="submit" class="btn-solid-black w-100 mt-2">
                            CHANGE PASSWORD
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
