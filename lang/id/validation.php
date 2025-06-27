<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Data :attribute harus diterima.',
    'accepted_if' => 'Data :attribute harus diterima ketika :other adalah :value.',
    'active_url' => 'Data :attribute bukan URL yang valid.',
    'after' => 'Data :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Data :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Data :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Data :attribute hanya boleh berisi huruf, angka, strip, dan underscore.',
    'alpha_num' => 'Data :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Data :attribute harus berupa array.',
    'ascii' => 'Data :attribute hanya boleh berisi karakter ASCII.',
    'before' => 'Data :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Data :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Data :attribute harus memiliki :min sampai :max item.',
        'file' => 'Data :attribute harus berukuran antara :min sampai :max kilobita.',
        'numeric' => 'Data :attribute harus bernilai antara :min sampai :max.',
        'string' => 'Data :attribute harus berisi antara :min sampai :max karakter.',
    ],
    'boolean' => 'Data :attribute harus bernilai true atau false.',
    'can' => 'Data :attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi data :attribute tidak cocok.',
    'current_password' => 'Password salah.',
    'date' => 'Data :attribute bukan tanggal yang valid.',
    'date_equals' => 'Data :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Data :attribute tidak cocok dengan format :format.',
    'decimal' => 'Data :attribute harus memiliki :decimal tempat desimal.',
    'declined' => 'Data :attribute harus ditolak.',
    'declined_if' => 'Data :attribute harus ditolak ketika :other adalah :value.',
    'different' => 'Data :attribute dan :other harus berbeda.',
    'digits' => 'Data :attribute harus :digits digit.',
    'digits_between' => 'Data :attribute harus antara :min sampai :max digit.',
    'dimensions' => 'Data :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Data :attribute memiliki nilai duplikat.',
    'doesnt_end_with' => 'Data :attribute tidak boleh diakhiri dengan: :values.',
    'doesnt_start_with' => 'Data :attribute tidak boleh dimulai dengan: :values.',
    'email' => 'Data :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Data :attribute harus diakhiri dengan: :values.',
    'enum' => 'Data :attribute yang dipilih tidak valid.',
    'exists' => 'Data :attribute yang dipilih tidak valid.',
    'extensions' => 'Data :attribute harus memiliki ekstensi: :values.',
    'file' => 'Data :attribute harus berupa file.',
    'filled' => 'Data :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Data :attribute harus memiliki lebih dari :value item.',
        'file' => 'Data :attribute harus berukuran lebih dari :value kilobita.',
        'numeric' => 'Data :attribute harus lebih besar dari :value.',
        'string' => 'Data :attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Data :attribute harus memiliki :value item atau lebih.',
        'file' => 'Data :attribute harus berukuran :value kilobita atau lebih.',
        'numeric' => 'Data :attribute harus lebih besar atau sama dengan :value.',
        'string' => 'Data :attribute harus :value karakter atau lebih.',
    ],
    'hex_color' => 'Data :attribute harus berupa kode warna hex yang valid.',
    'image' => 'Data :attribute harus berupa gambar.',
    'in' => 'Data :attribute yang dipilih tidak valid.',
    'in_array' => 'Data :attribute tidak ada di dalam :other.',
    'integer' => 'Data :attribute harus berupa bilangan bulat.',
    'ip' => 'Data :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Data :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Data :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Data :attribute harus berupa JSON string yang valid.',
    'lowercase' => 'Data :attribute harus menggunakan huruf kecil.',
    'lt' => [
        'array' => 'Data :attribute harus memiliki kurang dari :value item.',
        'file' => 'Data :attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => 'Data :attribute harus kurang dari :value.',
        'string' => 'Data :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Data :attribute tidak boleh memiliki lebih dari :value item.',
        'file' => 'Data :attribute harus berukuran :value kilobita atau kurang.',
        'numeric' => 'Data :attribute harus kurang dari atau sama dengan :value.',
        'string' => 'Data :attribute harus :value karakter atau kurang.',
    ],
    'mac_address' => 'Data :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Data :attribute tidak boleh memiliki lebih dari :max item.',
        'file' => 'Data :attribute tidak boleh berukuran lebih dari :max kilobita.',
        'numeric' => 'Data :attribute tidak boleh lebih besar dari :max.',
        'string' => 'Data :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => 'Data :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => 'Data :attribute harus berupa file bertipe: :values.',
    'mimetypes' => 'Data :attribute harus berupa file bertipe: :values.',
    'min' => [
        'array' => 'Data :attribute harus memiliki minimal :min item.',
        'file' => 'Data :attribute harus berukuran minimal :min kilobita.',
        'numeric' => 'Data :attribute harus minimal :min.',
        'string' => 'Data :attribute harus minimal :min karakter.',
    ],
    'min_digits' => 'Data :attribute harus memiliki minimal :min digit.',
    'missing' => 'Data :attribute harus hilang.',
    'missing_if' => 'Data :attribute harus hilang ketika :other adalah :value.',
    'missing_unless' => 'Data :attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => 'Data :attribute harus hilang ketika :values ada.',
    'missing_with_all' => 'Data :attribute harus hilang ketika :values ada.',
    'multiple_of' => 'Data :attribute harus kelipatan dari :value.',
    'not_in' => 'Data :attribute yang dipilih tidak valid.',
    'not_regex' => 'Format data :attribute tidak valid.',
    'numeric' => 'Data :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Data :attribute harus mengandung minimal satu huruf.',
        'mixed' => 'Data :attribute harus mengandung minimal satu huruf besar dan satu huruf kecil.',
        'numbers' => 'Data :attribute harus mengandung minimal satu angka.',
        'symbols' => 'Data :attribute harus mengandung minimal satu simbol.',
        'uncompromised' => 'Data :attribute yang diberikan telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',
    ],
    'present' => 'Data :attribute harus ada.',
    'present_if' => 'Data :attribute harus ada ketika :other adalah :value.',
    'present_unless' => 'Data :attribute harus ada kecuali :other adalah :value.',
    'present_with' => 'Data :attribute harus ada ketika :values ada.',
    'present_with_all' => 'Data :attribute harus ada ketika :values ada.',
    'prohibited' => 'Data :attribute dilarang.',
    'prohibited_if' => 'Data :attribute dilarang ketika :other adalah :value.',
    'prohibited_unless' => 'Data :attribute dilarang kecuali :other ada di :values.',
    'prohibits' => 'Data :attribute melarang :other untuk ada.',
    'regex' => 'Format data :attribute tidak valid.',
    'required' => 'Data :attribute wajib diisi.',
    'required_array_keys' => 'Data :attribute harus berisi entri untuk: :values.',
    'required_if' => 'Data :attribute wajib diisi ketika :other adalah :value.',
    'required_if_accepted' => 'Data :attribute wajib diisi ketika :other diterima.',
    'required_unless' => 'Data :attribute wajib diisi kecuali :other ada di :values.',
    'required_with' => 'Data :attribute wajib diisi ketika :values ada.',
    'required_with_all' => 'Data :attribute wajib diisi ketika :values ada.',
    'required_without' => 'Data :attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => 'Data :attribute wajib diisi ketika tidak ada :values yang ada.',
    'same' => 'Data :attribute dan :other harus sama.',
    'size' => [
        'array' => 'Data :attribute harus berisi :size item.',
        'file' => 'Data :attribute harus berukuran :size kilobita.',
        'numeric' => 'Data :attribute harus berukuran :size.',
        'string' => 'Data :attribute harus berukuran :size karakter.',
    ],
    'starts_with' => 'Data :attribute harus dimulai dengan: :values.',
    'string' => 'Data :attribute harus berupa string.',
    'timezone' => 'Data :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Data :attribute sudah digunakan.',
    'uploaded' => 'Data :attribute gagal diunggah.',
    'uppercase' => 'Data :attribute harus menggunakan huruf besar.',
    'url' => 'Format data :attribute tidak valid.',
    'ulid' => 'Data :attribute harus berupa ULID yang valid.',
    'uuid' => 'Data :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'nama',
        'username' => 'nama pengguna',
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'konfirmasi password',
        'city' => 'kota',
        'country' => 'negara',
        'address' => 'alamat',
        'phone' => 'nomor telepon',
        'mobile' => 'nomor handphone',
        'age' => 'usia',
        'sex' => 'jenis kelamin',
        'gender' => 'jenis kelamin',
        'day' => 'hari',
        'month' => 'bulan',
        'year' => 'tahun',
        'hour' => 'jam',
        'minute' => 'menit',
        'second' => 'detik',
        'title' => 'judul',
        'content' => 'konten',
        'description' => 'deskripsi',
        'excerpt' => 'ringkasan',
        'date' => 'tanggal',
        'time' => 'waktu',
        'available' => 'tersedia',
        'size' => 'ukuran',
        'nik' => 'NIK',
        'no_telepon' => 'nomor telepon',
        'tempat_kejadian' => 'tempat kejadian',
        'kecamatan_kejadian' => 'kecamatan kejadian',
        'tanggal_kejadian' => 'tanggal kejadian',
        'kronologi' => 'kronologi',
        'nama_bentuk_kekerasan' => 'nama bentuk kekerasan',
        'nama_layanan' => 'nama layanan',
        'jenis_layanan' => 'jenis layanan',
        'nama_pendamping' => 'nama pendamping',
        'nama_konselor' => 'nama konselor',
        'tanggal_pendampingan' => 'tanggal pendampingan',
        'waktu_pendampingan' => 'waktu pendampingan',
        'tempat_pendampingan' => 'tempat pendampingan',
        'tanggal_konseling' => 'tanggal konseling',
        'waktu_konseling' => 'waktu konseling',
        'tempat_konseling' => 'tempat konseling',
        'jadwal_konseling' => 'jadwal konseling',
        'pengaduan_id' => 'pengaduan',
        'korban_id' => 'korban',
        'nama_korban' => 'nama korban',
        'jenis_kelamin' => 'jenis kelamin',
        'disabilitas' => 'status disabilitas',
        'usia' => 'usia',
        'pendidikan' => 'pendidikan',
        'status_perkawinan' => 'status perkawinan',
        'pekerjaan' => 'pekerjaan',
        'nama' => 'nama',
        'posisi' => 'posisi',
        'foto' => 'foto',
        'kota_nama' => 'nama kota',
        'kecamatan_nama' => 'nama kecamatan',
        'desa_nama' => 'nama desa',
        'kota_id' => 'kota',
        'kecamatan_id' => 'kecamatan',
        'desa_id' => 'desa',
        'RT' => 'RT',
        'RW' => 'RW',
        'sebagai' => 'sebagai',
        'konfirmasi' => 'konfirmasi',
    ],

]; 