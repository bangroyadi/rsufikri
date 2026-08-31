<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Polyclinic;

class CompleteDoctorsSeeder extends Seeder
{
    public function run(): void
    {
        $allDoctors = [
            // Poli Penyakit Dalam (ID 1)
            [
                'name' => 'dr. Ahmad Fauzi, Sp.PD',
                'title_degree' => 'Sp.PD',
                'polyclinic_id' => 1,
                'specialty' => ['id' => 'Spesialis Penyakit Dalam', 'en' => 'Internal Medicine Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Dokter spesialis penyakit dalam berpengalaman dalam penanganan diabetes, hipertensi, gangguan lambung, hati, dan penyakit dalam lainnya.', 'en' => 'Experienced internal medicine specialist handling diabetes, hypertension, gastrointestinal, and metabolic diseases.'],
                'is_active' => true,
            ],
            [
                'name' => 'dr. H. Rahmat Hidayat, Sp.PD-KGEH',
                'title_degree' => 'Sp.PD-KGEH',
                'polyclinic_id' => 1,
                'specialty' => ['id' => 'Spesialis Penyakit Dalam Konsultan Gastroenterologi Hepatologi', 'en' => 'Gastroenterology & Hepatology Consultant'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Konsultan gastroenterologi dan hepatologi melayani endoskopi, kolonoskopi, penanganan batu empedu, liver, dan saluran cerna.', 'en' => 'Consultant in gastroenterology and hepatology for endoscopy, gallbladder, and liver care.'],
                'is_active' => true,
            ],

            // Poli Anak (ID 2)
            [
                'name' => 'dr. Adam Sultansah Hardigaluh, Sp.A',
                'title_degree' => 'Sp.A',
                'polyclinic_id' => 2,
                'specialty' => ['id' => 'Spesialis Anak & Tumbuh Kembang', 'en' => 'Pediatric & Child Development Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Dokter spesialis anak berdedikasi melayani kesehatan anak, imunisasi, dan pemantauan tumbuh kembang optimal.', 'en' => 'Dedicated pediatrician serving child health, vaccination, and optimal development.'],
                'is_active' => true,
            ],
            [
                'name' => 'dr. Ade Hafni, Sp.A',
                'title_degree' => 'Sp.A',
                'polyclinic_id' => 2,
                'specialty' => ['id' => 'Spesialis Anak', 'en' => 'Pediatric Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1594824813566-7885a3964477?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Melayani konsultasi kesehatan bayi, anak balita, nutrisi anak, dan pengobatan infeksi pediatri.', 'en' => 'Pediatric consultations for infants, toddlers, nutrition, and infections.'],
                'is_active' => true,
            ],
            [
                'name' => 'dr. Naman Khalid, Sp.A',
                'title_degree' => 'Sp.A',
                'polyclinic_id' => 2,
                'specialty' => ['id' => 'Spesialis Anak', 'en' => 'Pediatric Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Berpengalaman dalam diagnosis dan tatalaksana komprehensif penyakit anak dan bayi baru lahir (neonatologi).', 'en' => 'Experienced in diagnosis and management of pediatric and newborn conditions.'],
                'is_active' => true,
            ],

            // Poli Obgyn / Kandungan (ID 3)
            [
                'name' => 'dr. Budi Santoso, Sp.OG',
                'title_degree' => 'Sp.OG',
                'polyclinic_id' => 3,
                'specialty' => ['id' => 'Spesialis Kebidanan & Kandungan', 'en' => 'Obstetrician & Gynecologist'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Melayani pemeriksaan USG 4D HD Live, program kehamilan, persalinan ERACS, dan operasi kandungan.', 'en' => 'Serving 4D USG HD Live checkups, pregnancy programs, ERACS delivery, and gynecological surgery.'],
                'is_active' => true,
            ],
            [
                'name' => 'dr. Hj. Nurul Hidayati, Sp.OG',
                'title_degree' => 'Sp.OG',
                'polyclinic_id' => 3,
                'specialty' => ['id' => 'Spesialis Kebidanan & Kandungan', 'en' => 'Obstetrics & Gynecology Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Ahli kesehatan reproduksi wanita, konsultasi pra-nikah, kehamilan risiko tinggi, dan kesehatan maternal.', 'en' => 'Expert in female reproductive health, premarital consultation, and maternal care.'],
                'is_active' => true,
            ],

            // Poli Bedah (ID 4)
            [
                'name' => 'dr. Agi Budinuransyah, Sp.B',
                'title_degree' => 'Sp.B',
                'polyclinic_id' => 4,
                'specialty' => ['id' => 'Spesialis Bedah Umum', 'en' => 'General Surgery Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Menangani tindakan pembedahan umum, operasi usus buntu, hernia, tumor jinak, dan trauma luka bedah.', 'en' => 'Handling general surgical procedures, appendectomy, hernia, and surgical trauma.'],
                'is_active' => true,
            ],
            [
                'name' => 'dr. Ferdi Stefiyan, Sp.B',
                'title_degree' => 'Sp.B',
                'polyclinic_id' => 4,
                'specialty' => ['id' => 'Spesialis Bedah Umum & Laparoskopi', 'en' => 'General & Laparoscopic Surgery'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Spesialis bedah umum dengan keahlian bedah invasif minimal (laparoskopi) untuk pemulihan cepat.', 'en' => 'General surgery specialist with expertise in minimally invasive laparoscopic surgery.'],
                'is_active' => true,
            ],

            // Poli Urologi (ID 5)
            [
                'name' => 'dr. Yoga Pratama, Sp.U',
                'title_degree' => 'Sp.U',
                'polyclinic_id' => 5,
                'specialty' => ['id' => 'Spesialis Urologi', 'en' => 'Urology Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Melayani penanganan batu ginjal tanpa sayatan (ESWL / PCNL), prostat, dan gangguan saluran kemih.', 'en' => 'Treating kidney stones, prostate, and urinary tract disorders.'],
                'is_active' => true,
            ],

            // Poli Mata (ID 6)
            [
                'name' => 'dr. Rina Kusumawati, Sp.M',
                'title_degree' => 'Sp.M',
                'polyclinic_id' => 6,
                'specialty' => ['id' => 'Spesialis Mata (Oftalmologi)', 'en' => 'Ophthalmologist'],
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Pemeriksaan mata komprehensif, operasi katarak modern (Phacoemulsification), dan penanganan glaukoma.', 'en' => 'Comprehensive eye exams, modern cataract surgery, and glaucoma therapy.'],
                'is_active' => true,
            ],

            // Poli Jantung (ID 7)
            [
                'name' => 'dr. Hendra Wijaya, Sp.JP (K), FIHA',
                'title_degree' => 'Sp.JP (K)',
                'polyclinic_id' => 7,
                'specialty' => ['id' => 'Spesialis Jantung & Pembuluh Darah Konsultan', 'en' => 'Cardiologist & Vascular Consultant'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Ahli kardiovaskular dalam pencegahan, diagnosis aritmia, gagal jantung, pasang ring, dan penyakit jantung koroner.', 'en' => 'Cardiovascular specialist for arrhythmia, heart failure, and coronary artery disease.'],
                'is_active' => true,
            ],

            // Poli Paru (ID 8)
            [
                'name' => 'dr. Dian Anggraini, Sp.P',
                'title_degree' => 'Sp.P',
                'polyclinic_id' => 8,
                'specialty' => ['id' => 'Spesialis Pulmonologi & Kedokteran Respirasi (Paru)', 'en' => 'Pulmonology & Respiratory Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1594824813566-7885a3964477?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Diagnosis dan tatalaksana asma, PPOK, bronkitis kronis, TBC, pneumonia, dan spirometri fungsi paru.', 'en' => 'Diagnosis and management of asthma, COPD, pneumonia, and pulmonary function tests.'],
                'is_active' => true,
            ],

            // Poli Orthopedi (ID 9)
            [
                'name' => 'dr. Irfan Gunawan, Sp.OT',
                'title_degree' => 'Sp.OT',
                'polyclinic_id' => 9,
                'specialty' => ['id' => 'Spesialis Orthopedi & Traumatologi', 'en' => 'Orthopedic & Traumatology Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Menangani patah tulang (fraktur), cedera sendi, nyeri lutut, rekonstruksi ligamen, dan kelainan tulang belakang.', 'en' => 'Treating bone fractures, joint injuries, knee pain, and spine disorders.'],
                'is_active' => true,
            ],

            // Poli THT-KL (ID 10)
            [
                'name' => 'dr. Dedi Supriyadi, Sp.THT-KL',
                'title_degree' => 'Sp.THT-KL',
                'polyclinic_id' => 10,
                'specialty' => ['id' => 'Spesialis THT – Kepala & Leher', 'en' => 'ENT Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Melayani endoskopi THT, penanganan sinusitis, amandel (tonsil), gangguan pendengaran, dan vertigo.', 'en' => 'ENT endoscopy, sinusitis, tonsillitis, hearing loss, and vertigo.'],
                'is_active' => true,
            ],

            // Poli Saraf / Neurologi (ID 11)
            [
                'name' => 'dr. Anisa Putri Utami, Sp.N',
                'title_degree' => 'Sp.N',
                'polyclinic_id' => 11,
                'specialty' => ['id' => 'Spesialis Neurologi (Saraf)', 'en' => 'Neurologist'],
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Melayani tatalaksana stroke, epilepsi, migrain, nyeri neuropatik, neuropati diabetik, dan saraf terjepit.', 'en' => 'Treating stroke, epilepsy, migraines, neuropathic pain, and pinched nerves.'],
                'is_active' => true,
            ],

            // Poli Bedah Saraf (ID 12)
            [
                'name' => 'dr. Firman Muharam, Sp.BS',
                'title_degree' => 'Sp.BS',
                'polyclinic_id' => 12,
                'specialty' => ['id' => 'Spesialis Bedah Saraf', 'en' => 'Neurosurgery Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Tindakan operatif trauma kepala, perdarahan otak, tumor intrakranial, dan mikrosurgeri tulang belakang.', 'en' => 'Operative procedures for head trauma, brain hemorrhage, and spinal microsurgery.'],
                'is_active' => true,
            ],

            // Poli Jiwa / Psikiatri (ID 13)
            [
                'name' => 'dr. Hendri Kurniawan, Sp.KJ',
                'title_degree' => 'Sp.KJ',
                'polyclinic_id' => 13,
                'specialty' => ['id' => 'Spesialis Kedokteran Jiwa (Psikiater)', 'en' => 'Psychiatrist'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Konseling kesehatan mental, terapi kecemasan (anxiety), depresi, insomnia, stres, dan psikosomatis.', 'en' => 'Mental health counseling, anxiety, depression, insomnia, and psychosomatic care.'],
                'is_active' => true,
            ],

            // Poli Kulit & Kelamin (ID 14)
            [
                'name' => 'dr. Maya Safitri, Sp.D.V.E',
                'title_degree' => 'Sp.D.V.E',
                'polyclinic_id' => 14,
                'specialty' => ['id' => 'Spesialis Dermatologi & Venereologi', 'en' => 'Dermatologist & Venereologist'],
                'photo' => 'https://images.unsplash.com/photo-1594824813566-7885a3964477?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Perawatan jerawat, flek wajah, alergi kulit, eksim, infeksi jamur, laser estetika, dan penyakit menular seksual.', 'en' => 'Skin care treatments for acne, eczema, fungal infections, and aesthetic laser.'],
                'is_active' => true,
            ],

            // Poli Rehab Medik (ID 15)
            [
                'name' => 'dr. Edwin Nugraha, Sp.KFR',
                'title_degree' => 'Sp.KFR',
                'polyclinic_id' => 15,
                'specialty' => ['id' => 'Spesialis Kedokteran Fisik & Rehabilitasi', 'en' => 'Physical Medicine & Rehabilitation Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Program pemulihan gerak pasca stroke, fisioterapi nyeri leher/punggung, terapi okupasi, dan cedera olahraga.', 'en' => 'Rehabilitation after stroke, neck/back pain physiotherapy, and sports injuries.'],
                'is_active' => true,
            ],

            // Poli Spesialis Gigi Periodonti (ID 16)
            [
                'name' => 'drg. Silvia Dewi, Sp.Perio',
                'title_degree' => 'Sp.Perio',
                'polyclinic_id' => 16,
                'specialty' => ['id' => 'Spesialis Periodonsia (Jaringan Gusi & Tulang Gigi)', 'en' => 'Periodontist'],
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Perawatan radang gusi, scaling subgingiva, kuretase gusi, gigi goyang, dan bedah flep periodontal.', 'en' => 'Treatment for gingivitis, deep scaling, loose teeth, and periodontal flap surgery.'],
                'is_active' => true,
            ],

            // Poli Bedah Mulut (ID 17)
            [
                'name' => 'drg. Bambang Tri Sasongko, Sp.BM',
                'title_degree' => 'Sp.BM',
                'polyclinic_id' => 17,
                'specialty' => ['id' => 'Spesialis Bedah Mulut & Maksilofasial', 'en' => 'Oral & Maxillofacial Surgeon'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Operasi gigi bungsu (odontektomi), kista rongga mulut, fraktur rahang, dan rekonstruksi bedah mulut.', 'en' => 'Wisdom tooth surgery (odontectomy), oral cysts, and jaw fracture surgery.'],
                'is_active' => true,
            ],

            // Poli Gigi Umum (ID 18)
            [
                'name' => 'drg. Citra Lestari',
                'title_degree' => 'drg.',
                'polyclinic_id' => 18,
                'specialty' => ['id' => 'Dokter Gigi Umum', 'en' => 'General Dentist'],
                'photo' => 'https://images.unsplash.com/photo-1594824813566-7885a3964477?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Pembersihan karang gigi (scaling), tambal gigi estetik, pencabutan gigi, dan perawatan saluran akar.', 'en' => 'Dental scaling, aesthetic fillings, tooth extractions, and root canal care.'],
                'is_active' => true,
            ],

            // Poli Radiologi (ID 19)
            [
                'name' => 'dr. Wahyu Pratomo, Sp.Rad',
                'title_degree' => 'Sp.Rad',
                'polyclinic_id' => 19,
                'specialty' => ['id' => 'Spesialis Radiologi', 'en' => 'Radiologist'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'bio' => ['id' => 'Ekspertise diagnostik Rontgen (X-Ray Digital), USG Abdomen/Vaskular, Panoramic Dental, dan imaging diagnostik.', 'en' => 'Diagnostic expertise in Digital X-Ray, Abdominal/Vascular Ultrasound, and imaging diagnostics.'],
                'is_active' => true,
            ],
        ];

        foreach ($allDoctors as $docData) {
            // Update or create based on clean name
            Doctor::updateOrCreate(
                ['name' => $docData['name']],
                $docData
            );
        }
    }
}
