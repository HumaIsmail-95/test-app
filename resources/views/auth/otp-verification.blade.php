<x-guest-layout>
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
    @if(session('status') && session('message'))
        <div class="{{ session('status') }}">
            {{ session('message') }}
        </div>
    @endif
@php
$user_id = request('user_id');
@endphp
    <form method="POST" action="{{ route('verifyUser',$user_id) }}">
        @csrf
        <div>
           
            <x-text-input  class="block mt-1 w-full" type="hidden" name="user_id" value="{{$user_id}}"/>
        </div>
        <!-- OTP Address -->
        <div>
            <x-input-label for="otp" :value="__('OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="number" name="otp" :value="old('otp')" required autofocus/>
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Verify OTP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
