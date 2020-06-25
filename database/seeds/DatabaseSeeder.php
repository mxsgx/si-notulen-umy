<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run()
    {
        $tables = [
            'lecturers' => \App\Lecturer::class,
            'rooms' => \App\Room::class,
            'meetings' => \App\Meeting::class,
            'faculties' => \App\Faculty::class,
            'studies' => \App\Study::class,
            'minutes' => \App\Minute::class,
            'documents' => \App\Document::class,
            'presents' => \App\Present::class,
            'users' => \App\User::class,
        ];

        $fileName = 'db.json';
        $filePath = storage_path('backup/' . $fileName);

        if (File::exists($filePath)) {
            $file = File::get($filePath);
            $json = json_decode($file, true);

            if ($json) {
                $collection = collect($json);

                foreach ($tables as $table => $class) {
                    $record = $collection->where('name', $table)->first();

                    if ($record) {
                        foreach ($record['data'] as $data) {
                            $class::create($data);
                        }
                    }
                }
            }
        } else {
            \App\User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@notulen.test',
                'password' => Hash::make('password'),
                'role' => 'super-admin',
            ]);
        }
    }
}
