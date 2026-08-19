<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Polyclinic;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polyclinics = [
            [
                'id'          => 1,
                'slug'        => 'penyakit-dalam',
                'name'        => ['id' => 'Poli Penyakit Dalam', 'en' => 'Internal Medicine Clinic'],
                'description' => ['id' => 'Pelayanan komprehensif diagnosis dan penanganan penyakit organ dalam pada orang dewasa dan lansia (diabetes, hipertensi, lambung, ginjal, hati).', 'en' => 'Comprehensive diagnosis and treatment of internal organ diseases in adults and the elderly.'],
                'icon'        => 'fa-solid fa-stethoscope',
                'is_active'   => true,
            ],
            [
                'id'          => 2,
                'slug'        => 'anak',
                'name'        => ['id' => 'Poli Anak', 'en' => 'Pediatric Clinic'],
                'description' => ['id' => 'Pelayanan kesehatan bayi, anak, dan remaja meliputi pengobatan penyakit, vaksinasi/imunisasi, serta pemantauan tumbuh kembang.', 'en' => 'Healthcare services for infants, children, and adolescents including illness treatment, vaccination, and growth monitoring.'],
                'icon'        => 'fa-solid fa-baby',
                'is_active'   => true,
            ],
            [
                'id'          => 3,
                'slug'        => 'obgyn-kandungan',
                'name'        => ['id' => 'Poli Obgyn (Kandungan)', 'en' => 'Obstetrics & Gynecology Clinic'],
                'description' => ['id' => 'Pemeriksaan kehamilan rutin, USG 4D HD Live, program kehamilan, persalinan ERACS, dan kesehatan organ reproduksi wanita.', 'en' => 'Routine pregnancy check-up, 4D USG HD Live, fertility program, ERACS delivery, and female reproductive health.'],
                'icon'        => 'fa-solid fa-person-pregnant',
                'is_active'   => true,
            ],
            [
                'id'          => 4,
                'slug'        => 'bedah',
                'name'        => ['id' => 'Poli Bedah', 'en' => 'General Surgery Clinic'],
                'description' => ['id' => 'Konsultasi dan tindakan pembedahan umum untuk berbagai kondisi medis seperti usus buntu, hernia, tumor jinak, dan luka bedah.', 'en' => 'Consultation and surgical procedures for conditions such as appendicitis, hernia, benign tumors, and wound care.'],
                'icon'        => 'fa-solid fa-scalpel',
                'is_active'   => true,
            ],
            [
                'id'          => 5,
                'slug'        => 'urologi',
                'name'        => ['id' => 'Poli Urologi', 'en' => 'Urology Clinic'],
                'description' => ['id' => 'Penanganan kelainan sistem saluran kemih (ginjal, kandung kemih, batu saluran kemih) dan organ reproduksi pria (prostat).', 'en' => 'Treatment of urinary tract disorders (kidneys, bladder, urinary stones) and male reproductive organs (prostate).'],
                'icon'        => 'fa-solid fa-dna',
                'is_active'   => true,
            ],
            [
                'id'          => 6,
                'slug'        => 'mata',
                'name'        => ['id' => 'Poli Mata', 'en' => 'Ophthalmology Clinic'],
                'description' => ['id' => 'Pemeriksaan kesehatan mata, refraksi visus, penanganan glaukoma, infeksi mata, dan operasi katarak modern (Phacoemulsification).', 'en' => 'Eye health examination, refraction, glaucoma treatment, eye infection, and modern cataract surgery.'],
                'icon'        => 'fa-solid fa-eye',
                'is_active'   => true,
            ],
            [
                'id'          => 7,
                'slug'        => 'jantung',
                'name'        => ['id' => 'Poli Jantung', 'en' => 'Cardiology Clinic'],
                'description' => ['id' => 'Pencegahan, diagnosis, dan terapi penyakit jantung serta pembuluh darah didukung fasilitas EKG, Treadmill, dan Echocardiography.', 'en' => 'Prevention, diagnosis, and therapy for cardiovascular diseases supported by ECG, Treadmill, and Echocardiography.'],
                'icon'        => 'fa-solid fa-heart-pulse',
                'is_active'   => true,
            ],
            [
                'id'          => 8,
                'slug'        => 'paru',
                'name'        => ['id' => 'Poli Paru', 'en' => 'Pulmonology Clinic'],
                'description' => ['id' => 'Diagnosis dan penanganan penyakit saluran pernapasan dan paru-paru seperti asma, PPOK, TBC, bronkitis, dan pneumonia.', 'en' => 'Diagnosis and management of respiratory diseases and lungs including asthma, COPD, tuberculosis, and pneumonia.'],
                'icon'        => 'fa-solid fa-lungs',
                'is_active'   => true,
            ],
            [
                'id'          => 9,
                'slug'        => 'orthopedi',
                'name'        => ['id' => 'Poli Orthopedi', 'en' => 'Orthopedics & Traumatology Clinic'],
                'description' => ['id' => 'Penanganan cedera tulang, patah tulang (fraktur), dislokasi sendi, kelainan bentuk tulang belakang, dan trauma kecelakaan.', 'en' => 'Treatment of bone injuries, fractures, joint dislocations, spinal disorders, and accidental trauma.'],
                'icon'        => 'fa-solid fa-bone',
                'is_active'   => true,
            ],
            [
                'id'          => 10,
                'slug'        => 'tht-kl',
                'name'        => ['id' => 'Poli THT – KL', 'en' => 'ENT Clinic (Ear, Nose, Throat)'],
                'description' => ['id' => 'Pemeriksaan dan terapi gangguan telinga, hidung, tenggorokan, serta bedah kepala dan leher (sinusitis, amandel, polip, gangguan pendengaran).', 'en' => 'Examination and treatment of ear, nose, throat, head and neck disorders.'],
                'icon'        => 'fa-solid fa-head-side-cough',
                'is_active'   => true,
            ],
            [
                'id'          => 11,
                'slug'        => 'neurologi-saraf',
                'name'        => ['id' => 'Poli Neurologi (Saraf)', 'en' => 'Neurology Clinic'],
                'description' => ['id' => 'Penanganan penyakit sistem saraf pusat dan tepi seperti stroke, vertigo, migrain/nyeri kepala, epilepsi, dan saraf terjepit (HNP).', 'en' => 'Management of central and peripheral nervous system disorders such as stroke, vertigo, migraine, epilepsy, and pinched nerves.'],
                'icon'        => 'fa-solid fa-brain',
                'is_active'   => true,
            ],
            [
                'id'          => 12,
                'slug'        => 'bedah-saraf',
                'name'        => ['id' => 'Poli Bedah Saraf', 'en' => 'Neurosurgery Clinic'],
                'description' => ['id' => 'Tindakan operasi saraf untuk kasus trauma kepala, perdarahan otak, tumor otak/tulang belakang, dan kelainan vaskular saraf.', 'en' => 'Neurosurgical procedures for head trauma, brain hemorrhage, brain/spinal tumors, and vascular abnormalities.'],
                'icon'        => 'fa-solid fa-microscope',
                'is_active'   => true,
            ],
            [
                'id'          => 13,
                'slug'        => 'jiwa',
                'name'        => ['id' => 'Poli Jiwa', 'en' => 'Psychiatry Clinic'],
                'description' => ['id' => 'Konsultasi dan terapi kesehatan mental, gangguan kecemasan, depresi, stres, gangguan tidur/insomnia, dan psikiatri umum.', 'en' => 'Mental health consultation and therapy, anxiety, depression, stress, sleep disorders, and general psychiatry.'],
                'icon'        => 'fa-solid fa-hand-holding-heart',
                'is_active'   => true,
            ],
            [
                'id'          => 14,
                'slug'        => 'kulit-dan-kelamin',
                'name'        => ['id' => 'Poli Kulit dan Kelamin', 'en' => 'Dermatology & Venereology Clinic'],
                'description' => ['id' => 'Perawatan masalah kulit (jerawat, alergi, eksim, infeksi jamur/bakteri, psoriasis) serta penanganan infeksi menular seksual.', 'en' => 'Skin care treatments (acne, allergy, eczema, fungal/bacterial infections) and sexually transmitted infections.'],
                'icon'        => 'fa-solid fa-shield-virus',
                'is_active'   => true,
            ],
            [
                'id'          => 15,
                'slug'        => 'rehab-medik',
                'name'        => ['id' => 'Poli Rehab Medik', 'en' => 'Physical Medicine & Rehabilitation'],
                'description' => ['id' => 'Pelayanan fisioterapi, okupasi terapi, dan pemulihan fungsi tubuh pasca stroke, operasi, cedera otot, atau nyeri punggung.', 'en' => 'Physiotherapy, occupational therapy, and rehabilitation services after stroke, surgery, muscle injury, or back pain.'],
                'icon'        => 'fa-solid fa-person-walking-with-cane',
                'is_active'   => true,
            ],
            [
                'id'          => 16,
                'slug'        => 'spesialis-gigi-periodonti',
                'name'        => ['id' => 'Poli Spesialis Gigi (Periodonti)', 'en' => 'Periodontics Dental Clinic'],
                'description' => ['id' => 'Perawatan khusus jaringan penyangga gigi, gusi berdarah, periodontitis, pembersihan karang gigi mendalam, dan bedah flep gusi.', 'en' => 'Specialized care for periodontal tissues, bleeding gums, periodontitis, deep scaling, and gum flap surgery.'],
                'icon'        => 'fa-solid fa-tooth',
                'is_active'   => true,
            ],
            [
                'id'          => 17,
                'slug'        => 'bedah-mulut',
                'name'        => ['id' => 'Poli Bedah Mulut', 'en' => 'Oral & Maxillofacial Surgery Clinic'],
                'description' => ['id' => 'Tindakan operasi gigi bungsu (odontektomi), kista rongga mulut, fraktur rahang, dan rekonstruksi bedah maksilofasial.', 'en' => 'Wisdom tooth surgery (odontectomy), oral cysts, jaw fracture, and maxillofacial surgery.'],
                'icon'        => 'fa-solid fa-teeth-open',
                'is_active'   => true,
            ],
            [
                'id'          => 18,
                'slug'        => 'gigi',
                'name'        => ['id' => 'Poli Gigi', 'en' => 'General Dental Clinic'],
                'description' => ['id' => 'Pelayanan kesehatan gigi umum, tambal gigi estetik, pencabutan gigi, pembersihan karang gigi (scaling), dan perawatan saluran akar.', 'en' => 'General dental care, aesthetic filling, tooth extraction, scaling, and root canal treatment.'],
                'icon'        => 'fa-solid fa-tooth',
                'is_active'   => true,
            ],
            [
                'id'          => 19,
                'slug'        => 'radiologi',
                'name'        => ['id' => 'Poli Radiologi', 'en' => 'Radiology & Imaging Center'],
                'description' => ['id' => 'Pemeriksaan diagnostik radiologi digital X-Ray (Rontgen), USG Doppler, Panoramic Dental, dan penunjang diagnostik imaging canggih.', 'en' => 'Digital diagnostic radiology X-Ray, Doppler Ultrasound, Dental Panoramic, and imaging diagnostic services.'],
                'icon'        => 'fa-solid fa-x-ray',
                'is_active'   => true,
            ],
        ];

        // Nonaktifkan foreign key checks sementara untuk reset tabel secara bersih
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Polyclinic::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($polyclinics as $poli) {
            Polyclinic::create($poli);
        }

        // Hubungkan kembali dokter yang ada ke ID poli baru
        // Dokter Anak -> Poli Anak (ID: 2)
        Doctor::where('title_degree', 'like', '%Sp.A%')->orWhere('name', 'like', '%Sp.A%')->update(['polyclinic_id' => 2]);

        // Dokter Bedah -> Poli Bedah (ID: 4)
        Doctor::where('title_degree', 'like', '%Sp.B%')->orWhere('name', 'like', '%Sp.B%')->update(['polyclinic_id' => 4]);
    }
}
