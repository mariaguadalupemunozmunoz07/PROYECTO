<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perfil
        </h2>
    </x-slot>

    <style>
        .perfil-rosa label,
        .perfil-rosa label span,
        .perfil-rosa h2 {
            color: #be185d !important;
        }
        .perfil-rosa label {
            font-weight: 500;
        }
        .perfil-rosa a {
            color: #be185d !important;
        }
        .perfil-rosa button[type="submit"]:not(.bg-red-600) {
            background-color: #fbcfe8 !important;
            color: #be185d !important;
            border: 1px solid #f9a8d4 !important;
            border-radius: 8px;
            font-weight: 700;
        }
        .perfil-rosa button[type="submit"]:not(.bg-red-600):hover {
            background-color: #f9a8d4 !important;
        }
    </style>

    <div class="py-12 perfil-rosa">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>