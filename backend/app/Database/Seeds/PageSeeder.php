<?php
/**
 * Developer note: In CodeIgniter 4, seeders are located in backend/app/Database/Seeds/.
 * This seeder will create 10 sample pages with substantial, long-form content to look organic.
 */

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UsersModel;
use App\Models\PagesModel;
use App\Models\BlocksModel;

class PageSeeder extends Seeder
{
    public function run()
    {
        $usersModel  = new UsersModel();
        $pagesModel  = new PagesModel();
        $blocksModel = new BlocksModel();

        // 1. Ensure we have at least one user
        $user = $usersModel->where('id', 2)->first();
        if (!$user) {
            $userId = $usersModel->insert([
                'name'     => 'Demo Admin',
                'email'    => 'admin@demo.com',
                'username' => 'admin',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'status'   => 'active'
            ]);
        } else {
            $userId = $user->id;
        }

        $placeholderImg = 'uploads/general/placeholder.jpg';

        $pages = [
            [
                'title' => 'Budi Santoso - Software Engineer',
                'slug'  => 'budi-dev',
                'description' => 'Portofolio dan Link Resmi Budi Santoso, Full-stack Developer.',
                'theme' => [
                    'backgroundColor' => '#f8fafc',
                    'accentColor'     => '#0f172a',
                    'fontFamily'      => 'sans',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Budi Santoso', 'bio' => 'Senior Full-stack Developer & Tech Enthusiast', 'align' => 'center', 'textColor' => '#0f172a']],
                    ['type' => 'social', 'content' => [['platform' => 'github', 'url' => '#'], ['platform' => 'linkedin', 'url' => '#'], ['platform' => 'twitter', 'url' => '#']]],
                    ['type' => 'text', 'content' => [
                        'content' => "Halo! Saya Budi, seorang pengembang aplikasi yang berdedikasi untuk menciptakan solusi digital yang tidak hanya berfungsi dengan baik, tetapi juga memberikan pengalaman pengguna yang luar biasa.\n\nDengan pengalaman lebih dari 8 tahun di industri teknologi, saya telah membantu berbagai perusahaan rintisan (startup) hingga korporasi besar dalam mengoptimalkan infrastruktur sistem mereka. Fokus utama saya saat ini adalah pada arsitektur microservices dan pengembangan antarmuka yang responsif menggunakan React dan Node.js.",
                        'align' => 'center',
                        'textColor' => '#475569'
                    ]],
                    ['type' => 'divider', 'content' => ['style' => 'solid']],
                    ['type' => 'text', 'content' => ['content' => 'PROJECT TERBARU', 'align' => 'center', 'textColor' => '#0f172a']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Aksibio Page Builder', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Fintech Dashboard', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'text', 'content' => [
                        'content' => "Project Aksibio ini adalah salah satu karya kebanggaan saya, di mana saya menggabungkan fleksibilitas backend CodeIgniter 4 dengan dinamisme Vue 3. Tujuannya adalah memberikan kebebasan bagi kreator untuk membangun branding mereka tanpa hambatan teknis.",
                        'align' => 'center',
                        'textColor' => '#64748b'
                    ]],
                    ['type' => 'link', 'content' => ['title' => '🚀 Lihat Portofolio Lengkap', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-folder2-open']],
                    ['type' => 'alert', 'content' => ['type' => 'success', 'title' => 'Open for Collaboration', 'content' => 'Saya saat ini menerima proyek konsultasi untuk periode Q3 2026. Mari diskusikan ide Anda!', 'icon' => 'bi-chat-text']],
                    ['type' => 'link', 'content' => ['title' => '☕ Coffee Support', 'url' => '#', 'style' => 'outline', 'icon' => 'bi-cup-hot']],
                    ['type' => 'text', 'content' => ['content' => 'Stay hungry, stay foolish! let\'s connect.', 'align' => 'center', 'textColor' => '#94a3b8']]
                ]
            ],
            [
                'title' => 'Siti Photography | Bali Base',
                'slug'  => 'siti-photo',
                'description' => 'Layanan Fotografi Profesional untuk Wedding, Event, dan Travel.',
                'theme' => [
                    'backgroundColor' => '#0f172a',
                    'accentColor'     => '#f59e0b',
                    'fontFamily'      => 'serif',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Siti Aminah', 'bio' => 'Visual Storyteller based in the Heart of Bali.', 'align' => 'center', 'textColor' => '#ffffff']],
                    ['type' => 'text', 'content' => [
                        'text' => "Bagi saya, fotografi bukan sekadar menekan tombol rana. Ini adalah tentang menangkap emosi yang tidak terucapkan, sejarah yang sedang ditulis, dan cahaya yang membasuh indahnya alam Bali.\n\nSejak pindah ke Bali tahun 2018, saya telah jatuh cinta dengan cara pulau ini memberikan latar belakang yang magis bagi setiap pasangan yang saya potret. Saya berkomitmen untuk memberikan hasil foto yang 'timeless'—elegan saat ini, dan tetap mempesona saat dilihat 20 tahun ke depan.",
                        'align' => 'center',
                        'textColor' => '#94a3b8'
                    ]],
                    ['type' => 'slideshow', 'content' => ['images' => [
                        ['url' => $placeholderImg, 'caption' => 'Love under the sunset'],
                        ['url' => $placeholderImg, 'caption' => 'Sacred Ubud vibes'],
                        ['url' => $placeholderImg, 'caption' => 'The happiness']
                    ]]],
                    ['type' => 'divider', 'content' => ['style' => 'solid']],
                    ['type' => 'text', 'content' => [
                        'text' => "Saya menawarkan berbagai paket layanan, mulai dari sesi pre-wedding singkat di pantai hingga cakupan hari pernikahan penuh yang intim. Setiap paket sudah termasuk arahan gaya (styling) dan editing profesional agar setiap detail terlihat sempurna.",
                        'align' => 'center',
                        'textColor' => '#cbd5e1'
                    ]],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Wedding Story', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Travel Diaries', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'link', 'content' => ['title' => '📅 Booking & Price List List', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-journal-text']],
                    ['type' => 'social', 'content' => [['platform' => 'instagram', 'url' => '#'], ['platform' => 'youtube', 'url' => '#']]],
                    ['type' => 'text', 'content' => ['text' => 'Let\'s create magic together.', 'align' => 'center', 'textColor' => '#475569']]
                ]
            ],
            [
                'title' => 'Dapur Chef Rani - Kuliner & Resep',
                'slug'  => 'chef-rani',
                'description' => 'Inspirasi masakan harian dan kelas memasak profesional.',
                'theme' => [
                    'backgroundColor' => '#fff7ed',
                    'accentColor'     => '#e11d48',
                    'fontFamily'      => 'sans',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Chef Rani', 'bio' => 'Culinary Explorer & Educator.', 'align' => 'center', 'textColor' => '#7c2d12']],
                    ['type' => 'text', 'content' => [
                        'text' => "Selamat datang di Dapur Rani! Perjalanan kuliner saya dimulai dari dapur kecil ibu saya, di mana saya belajar bahwa bumbu rahasia paling penting dalam setiap masakan adalah kesabaran dan cinta.\n\nDi sini, saya ingin meruntuhkan mitos bahwa memasak makanan enak itu sulit. Melalui resep-resep yang saya bagikan, saya ingin memberdayakan siapa saja untuk berani mencoba, bereksperimen dengan rasa, dan menciptakan kenangan manis di meja makan keluarga.",
                        'align' => 'center',
                        'textColor' => '#9a3412'
                    ]],
                    ['type' => 'video', 'content' => ['url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']],
                    ['type' => 'alert', 'content' => ['type' => 'warning', 'title' => 'BARU RILIS!', 'message' => 'E-Book "Rahasia Dapur Nusantara" kini tersedia untuk diunduh. Berisi 50+ resep otentik keluarga.', 'icon' => 'bi-book']],
                    ['type' => 'divider', 'content' => ['style' => 'dashed']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Resep 15 Menit', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Kursus Pastry', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'link', 'content' => ['title' => '📗 Download E-Book Sekarang', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-download']],
                    ['type' => 'link', 'content' => ['title' => '🛒 Peralatan Masak Rekomendasi', 'url' => '#', 'style' => 'outline', 'icon' => 'bi-cart']],
                    ['type' => 'social', 'content' => [['platform' => 'youtube', 'url' => '#'], ['platform' => 'instagram', 'url' => '#']]]
                ]
            ],
            [
                'title' => 'Aksibio Agency - Creative Partner',
                'slug'  => 'aksibio-agency',
                'description' => 'Agensi kreatif yang membantu brand Anda tumbuh secara digital.',
                'theme' => [
                    'backgroundColor' => '#ffffff',
                    'accentColor'     => '#2563eb',
                    'fontFamily'      => 'sans',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Aksibio Agency', 'bio' => 'Akselerasi Brand Anda ke Level Selanjutnya.', 'align' => 'left', 'textColor' => '#1e293b']],
                    ['type' => 'text', 'content' => [
                        'text' => "Dunia digital bergerak sangat cepat. Jika brand Anda tidak beradaptasi, Anda akan tertinggal. Di Aksibio Agency, kami tidak hanya membuat desain yang 'bagus dilihat', kami membangun identitas yang mampu bercerita dan menarik audiens yang tepat.\n\nKami percaya bahwa setiap bisnis, sekecil apa pun, layak mendapatkan kehadiran digital yang kuat dan profesional. Kami hadir untuk menjembatani ide-ide cemerlang Anda dengan eksekusi visual yang memukau.",
                        'align' => 'left',
                        'textColor' => '#4b5563'
                    ]],
                    ['type' => 'divider', 'content' => ['style' => 'solid']],
                    ['type' => 'text', 'content' => ['text' => 'LAYANAN UTAMA KAMI', 'align' => 'center', 'textColor' => '#2563eb']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Social Media Mgmt', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Web Design', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Branding Kit', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Ads Strategy', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'link', 'content' => ['title' => '💬 Konsultasi Sekarang', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-chat-dots']],
                    ['type' => 'alert', 'content' => ['type' => 'info', 'title' => 'Mengapa Kami?', 'message' => 'Laporan transparan, revisi fleksibel, dan hasil yang terukur bagi pertumbuhan bisnis Anda.', 'icon' => 'bi-patch-check']],
                    ['type' => 'text', 'content' => ['text' => 'Membangun masa depan digital bersama Aksibio.', 'align' => 'center', 'textColor' => '#94a3b8']]
                ]
            ],
            [
                'title' => 'CV Online - Andi Wijaya, S.Kom',
                'slug'  => 'andi-cv',
                'description' => 'Profil profesional dan portofolio desain Andi Wijaya.',
                'theme' => [
                    'backgroundColor' => '#f8fafc',
                    'accentColor'     => '#4f46e5',
                    'fontFamily'      => 'sans',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Andi Wijaya', 'bio' => 'Senior UI/UX Designer & Mentor', 'align' => 'left', 'textColor' => '#1e293b']],
                    ['type' => 'text', 'content' => [
                        'text' => "Sebagai seorang Senior UI/UX Designer, saya memiliki hasrat untuk memecahkan masalah kompleks melalui desain yang intuitif. Saya percaya bahwa antarmuka yang baik bukan hanya tentang warna dan bentuk, tetapi tentang bagaimana sistem tersebut memandu pengguna mencapai tujuan mereka tanpa hambatan.\n\nDalam 6 tahun terakhir, saya telah memimpin tim desain untuk membangun produk finansial yang digunakan oleh ribuan pengguna setiap harinya. Saya juga rutin mengisi webinar tentang 'User-Centric Design' untuk membantu desainer muda berkembang di industri ini.",
                        'align' => 'left',
                        'textColor' => '#475569'
                    ]],
                    ['type' => 'alert', 'content' => ['type' => 'info', 'title' => 'Ketersediaan Kerja', 'message' => 'Saat ini saya terbuka untuk tawaran peran Full-time Senior/Lead di Jakarta atau Global Remote berkala.', 'icon' => 'bi-briefcase']],
                    ['type' => 'divider', 'content' => ['style' => 'solid']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Case Study: Bank App', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Design System 2.0', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'link', 'content' => ['title' => '📄 Download Full Resume (PDF)', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-file-earmark-person']],
                    ['type' => 'link', 'content' => ['title' => '🎨 Dribbble Showcase', 'url' => '#', 'style' => 'outline', 'icon' => 'bi-dribbble']],
                    ['type' => 'social', 'content' => [['platform' => 'linkedin', 'url' => '#'], ['platform' => 'twitter', 'url' => '#']]],
                    ['type' => 'text', 'content' => ['text' => 'Design with purpose, delivery with excellence.', 'align' => 'center', 'textColor' => '#94a3b8']]
                ]
            ],
            [
                'title' => 'Dunia Gamer - Streaming & News',
                'slug'  => 'gamer-ganteng',
                'description' => 'Channel resmi Gamer Ganteng, update streaming dan jadwal mabar.',
                'theme' => [
                    'backgroundColor' => '#020617',
                    'accentColor'     => '#a855f7',
                    'fontFamily'      => 'mono',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Gamer Ganteng', 'bio' => 'Live every day after 8 PM!', 'align' => 'center', 'textColor' => '#ffffff']],
                    ['type' => 'text', 'content' => [
                        'text' => "Yooo guys! Balik lagi sama gue, Gamer Ganteng. Di sini tempat kita seru-seruan bareng, bahas update game terbaru, sampe gacha bareng yang seringnya ampas tapi tetep asik.\n\nChannel ini dibangun buat komunitas gaming yang positif dan asik. Gak cuma mabar, kita juga sering diskusi soal setup PC, tips jago di rank, sampe curhat colongan pas lagi rehat. Pantengin terus jadwal gue ya!",
                        'align' => 'center',
                        'textColor' => '#94a3b8'
                    ]],
                    ['type' => 'video', 'content' => ['url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']],
                    ['type' => 'social', 'content' => [['platform' => 'twitch', 'url' => '#'], ['platform' => 'discord', 'url' => '#'], ['platform' => 'youtube', 'url' => '#']]],
                    ['type' => 'divider', 'content' => ['style' => 'dashed']],
                    ['type' => 'link', 'content' => ['title' => '💖 Support Stream (Saweria)', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-heart-fill']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'My Setup Gear', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Merchandise', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'alert', 'content' => ['type' => 'info', 'title' => 'JOIN DISCORD', 'message' => 'Lagi ada turnamen internal berhadiah skin. Masuk ke room #event buat daftar!', 'icon' => 'bi-discord']],
                    ['type' => 'text', 'content' => ['text' => 'GGWP! See you on stream.', 'align' => 'center', 'textColor' => '#475569']]
                ]
            ],
            [
                'title' => 'Toko Fashion ID - Katalog Terbaru',
                'slug'  => 'fashion-id',
                'description' => 'Koleksi fashion lokal berkualitas dengan harga bersaing.',
                'theme' => [
                    'backgroundColor' => '#ffffff',
                    'accentColor'     => '#2563eb',
                    'fontFamily'      => 'sans',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Fashion ID', 'bio' => 'Your Daily Style Inspiration.', 'align' => 'center', 'textColor' => '#1e293b']],
                    ['type' => 'text', 'content' => [
                        'text' => "Kami percaya bahwa tampil percaya diri tidak harus mahal. Sejak 2020, Fashion ID telah menghadirkan kurasi pakaian yang menggabungkan kenyamanan bahan berkualitas dengan desain yang selalu 'up-to-date'.\n\nHari ini, kami bangga bisa melayani ribuan pelanggan di seluruh Indonesia. Komitmen kami adalah memberikan pengalaman belanja yang mudah, cepat, dan terpercaya dengan jaminan kepuasan pelanggan di setiap produk yang kami kirimkan.",
                        'align' => 'center',
                        'textColor' => '#64748b'
                    ]],
                    ['type' => 'alert', 'content' => ['type' => 'danger', 'title' => 'FLASH SALE!', 'message' => 'Diskon up to 60% untuk semua koleksi Jaket & Hoodie. Berlaku hanya hari ini!', 'icon' => 'bi-lightning-charge']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Baju Pria', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Baju Wanita', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Sandal Kece', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Aksesoris', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'link', 'content' => ['title' => '🛍️ Belanja via Shopee', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-shop']],
                    ['type' => 'link', 'content' => ['title' => '📱 Katalog WhatsApp', 'url' => '#', 'style' => 'outline', 'icon' => 'bi-chat-left-dots']],
                    ['type' => 'social', 'content' => [['platform' => 'instagram', 'url' => '#'], ['platform' => 'tiktok', 'url' => '#']]],
                    ['type' => 'text', 'content' => ['text' => 'Fashion ID - Gaya untuk Semua.', 'align' => 'center', 'textColor' => '#94a3b8']]
                ]
            ],
            [
                'title' => 'Undangan Pernikahan Budi & Sari',
                'slug'  => 'wedding-budi-sari',
                'description' => 'Budi & Sari akan melangsungkan pernikahan. Mohon doa restunya.',
                'theme' => [
                    'backgroundColor' => '#fff1f2',
                    'accentColor'     => '#be123c',
                    'fontFamily'      => 'serif',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Budi & Sari', 'bio' => 'Walking together, forever.', 'align' => 'center', 'textColor' => '#881337']],
                    ['type' => 'text', 'content' => [
                        'text' => "Dua jiwa yang berbeda, dipertemukan oleh takdir yang indah. Atas izin Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk hadir di momen yang sangat spesial bagi kehidupan kami berdua.\n\nKehadiran dan doa restu Anda adalah kado terindah yang bisa kami harapkan. Kami menantikan kehadiran Anda di hari bahagia kami.",
                        'align' => 'center',
                        'textColor' => '#be123c'
                    ]],
                    ['type' => 'countdown', 'content' => ['datetime' => '2026-08-20 09:00:00']],
                    ['type' => 'divider', 'content' => ['style' => 'solid']],
                    ['type' => 'text', 'content' => ['text' => "AKAD & RESEPSI\nMinggu, 20 Agustus 2026\nGedung Serbaguna, Jakarta Selatan", 'align' => 'center', 'textColor' => '#1e293b']],
                    ['type' => 'link', 'content' => ['title' => '📍 Lokasi (Google Maps)', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-geo-alt-fill']],
                    ['type' => 'slideshow', 'content' => ['images' => [
                        ['url' => $placeholderImg, 'caption' => 'The Gallery'],
                        ['url' => $placeholderImg, 'caption' => 'Prewedding Story']
                    ]]],
                    ['type' => 'link', 'content' => ['title' => '🎁 Kirim Hadiah Digital', 'url' => '#', 'style' => 'outline', 'icon' => 'bi-gift-fill']],
                    ['type' => 'text', 'content' => ['text' => 'Mohon maaf jika ada kekurangan dalam penyampaian.', 'align' => 'center', 'textColor' => '#881337']]
                ]
            ],
            [
                'title' => 'Grup Musik - Senja di Kota',
                'slug'  => 'senja-musik',
                'description' => 'Update jadwal manggung dan karya terbaru dari Senja di Kota.',
                'theme' => [
                    'backgroundColor' => '#0f172a',
                    'accentColor'     => '#f59e0b',
                    'fontFamily'      => 'sans',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Senja di Kota', 'bio' => 'Melodi sederhana untuk hari yang lelah.', 'align' => 'center', 'textColor' => '#ffffff']],
                    ['type' => 'text', 'content' => [
                        'text' => "Senja di Kota adalah kolektif musik indie yang lahir dari kebisingan Jakarta. Kami percaya bahwa musik haruslah jujur, menceritakan tentang kemacetan, kopi yang dingin, dan rindu yang tak kunjung sampai.\n\nSetiap lagu kami adalah catatan harian yang kami ubah menjadi melodi. Terima kasih sudah mendengarkan dan menjadi bagian dari perjalanan kami dari panggung kecil ke panggung lainnya.",
                        'align' => 'center',
                        'textColor' => '#cbd5e1'
                    ]],
                    ['type' => 'social', 'content' => [['platform' => 'spotify', 'url' => '#'], ['platform' => 'apple_music', 'url' => '#'], ['platform' => 'youtube_music', 'url' => '#']]],
                    ['type' => 'video', 'content' => ['url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']],
                    ['type' => 'alert', 'content' => ['type' => 'success', 'title' => 'NEW SINGLE!', 'message' => 'Single terbaru kami "Lampu Merah" sudah bisa didengarkan di semua platform!', 'icon' => 'bi-music-note-beamed']],
                    ['type' => 'divider', 'content' => ['style' => 'solid']],
                    ['type' => 'text', 'content' => ['text' => 'JADWAL MANGGUNG', 'align' => 'center', 'textColor' => '#f59e0b']],
                    ['type' => 'link', 'content' => ['title' => '🎫 Jakarta (20 Juli) - Get Ticket', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-ticket-detailed']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Official Merch', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Lirik & Chord', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'text', 'content' => ['text' => 'Sampai bertemu di gelombang suara berikutnya!', 'align' => 'center', 'textColor' => '#94a3b8']]
                ]
            ],
            [
                'title' => 'Coach Mike - Health & Lifestyle',
                'slug'  => 'coach-mike',
                'description' => 'Ubah hidupmu sekarang melalui bimbingan kebugaran Coach Mike.',
                'theme' => [
                    'backgroundColor' => '#f8fafc',
                    'accentColor'     => '#059669',
                    'fontFamily'      => 'sans',
                    'buttonStyle'     => 'rounded'
                ],
                'blocks' => [
                    ['type' => 'profile', 'content' => ['avatar' => $placeholderImg, 'name' => 'Coach Mike', 'bio' => 'Fit for a Lifetime.', 'align' => 'center', 'textColor' => '#1e293b']],
                    ['type' => 'text', 'content' => [
                        'text' => "Kesehatan bukan tentang seberapa berat beban yang bisa kamu angkat, tapi tentang seberapa konsisten kamu muncul untuk dirimu sendiri setiap hari.\n\nSaya telah membantu ratusan orang bertransformasi bukan hanya secara fisik, tapi juga secara mental. Pendekatan saya fokus pada keberlanjutan gaya hidup sehat tanpa harus merasa tersiksa. Mari mulai langkah pertamamu bersama saya hari ini!",
                        'align' => 'center',
                        'textColor' => '#475569'
                    ]],
                    ['type' => 'alert', 'content' => ['type' => 'success', 'title' => 'KONSULTASI GRATIS', 'message' => 'Tersedia 5 slot mingguan untuk sesi konsultasi 15 menit via Zoom. Daftar sekarang!', 'icon' => 'bi-chat-heart']],
                    ['type' => 'divider', 'content' => ['style' => 'solid']],
                    ['type' => 'link', 'content' => ['title' => '🔥 Program Diet 30 Hari', 'url' => '#', 'style' => 'solid', 'icon' => 'bi-fire']],
                    ['type' => 'link', 'content' => ['title' => '💪 Online Personal Coaching', 'url' => '#', 'style' => 'outline', 'icon' => 'bi-person-badge']],
                    ['type' => 'link', 'content' => ['title' => '📗 Guide Nutrisi Dasar (E-Book)', 'url' => '#', 'style' => 'outline', 'icon' => 'bi-journal-bookmark']],
                    ['type' => 'grid', 'content' => ['columns' => 2, 'items' => [
                        ['title' => 'Tips Video', 'url' => '#', 'image' => $placeholderImg],
                        ['title' => 'Review Suplemen', 'url' => '#', 'image' => $placeholderImg]
                    ]]],
                    ['type' => 'social', 'content' => [['platform' => 'instagram', 'url' => '#'], ['platform' => 'youtube', 'url' => '#'], ['platform' => 'tiktok', 'url' => '#']]],
                    ['type' => 'text', 'content' => ['text' => 'You are stronger than you think.', 'align' => 'center', 'textColor' => '#94a3b8']]
                ]
            ]
        ];

        foreach ($pages as $p) {
            // Check if slug already exists to avoid unique constraint error
            if ($pagesModel->where('slug', $p['slug'])->first()) {
                continue;
            }

            $pageData = [
                'user_id'     => $userId,
                'title'       => $p['title'],
                'slug'        => $p['slug'],
                'description' => $p['description'],
                'theme'       => json_encode($p['theme']),
                'status'      => 'active',
                'created_by'  => $userId
            ];

            $pageId = $pagesModel->insert($pageData);

            if ($pageId) {
                foreach ($p['blocks'] as $index => $b) {
                    $blocksModel->insert([
                        'page_id'    => $pageId,
                        'type'       => $b['type'],
                        'data'       => json_encode($b['content']),
                        'sort_order' => $index,
                        'status'     => 'active',
                        'created_by' => $userId
                    ]);
                }
            }
        }
    }
}
