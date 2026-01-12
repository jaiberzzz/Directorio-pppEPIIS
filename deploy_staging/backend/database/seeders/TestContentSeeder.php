<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\News;
use App\Models\Document;
use App\Models\User;
use App\Models\Practitioner;
use Spatie\Permission\Models\Role;

class TestContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create News
        News::create([
            'title' => 'Inicio de Convocatorias 2025-I',
            'content' => 'Se comunica a toda la comunidad estudiantil que las convocatorias para prácticas preprofesionales del semestre 2025-I ya están abiertas.',
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Charla Informativa sobre Prácticas',
            'content' => 'Este viernes tendremos una charla informativa con egresados sobre sus experiencias en el mercado laboral.',
            'published_at' => now()->subDays(2),
        ]);

        // 2. Create Documents
        Document::create([
            'title' => 'Formato de Solicitud de Prácticas',
            'file_path' => 'templates/solicitud.pdf',
            'description' => 'Documento para iniciar el trámite de prácticas.',
        ]);

        Document::create([
            'title' => 'Reglamento de Prácticas Preprofesionales',
            'file_path' => 'templates/reglamento.pdf',
            'description' => 'Normativa vigente para el desarrollo de prácticas.',
        ]);

        // 3. Create Practitioners (Students)
        $roleEstudiante = Role::findByName('Estudiante');

        for ($i = 1; $i <= 10; $i++) {
            $studentUser = User::create([
                'name' => "Estudiante {$i}",
                'email' => "estudiante{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            $studentUser->assignRole($roleEstudiante);

            Practitioner::create([
                'user_id' => $studentUser->id,
                'dni' => "700000{$i}", // Dummy DNI
                'student_code' => "202100{$i}",
                'phone' => "90010020{$i}",
                'semester' => '24-1',
                'company_name' => $i % 2 == 0 ? 'Tech Solutions SAC' : 'Innovatech Corp',
                'practice_area' => $i % 2 == 0 ? 'Desarrollo Web' : 'Soporte TI',
                'status' => $i % 3 == 0 ? 'finalizado' : ($i % 2 == 0 ? 'en proceso' : 'por iniciar'),
                'hours_completed' => $i * 10,
                'start_date' => now()->subMonths(3),
                'end_date' => now()->addMonths(3),
            ]);
        }
    }
}
