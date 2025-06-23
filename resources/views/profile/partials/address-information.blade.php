<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Alamat') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Informasi alamat Anda.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if($user->alamat)
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->alamat->provinsi ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->alamat->kota ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->alamat->kecamatan ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->alamat->desa ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->alamat->alamat_lengkap ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->alamat->kode_pos ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            Informasi Alamat Belum Lengkap
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>
                                Data alamat Anda belum diisi. Silakan lengkapi informasi alamat untuk melanjutkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section> 