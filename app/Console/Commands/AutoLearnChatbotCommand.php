<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ChatbotAutoLearningService;

class AutoLearnChatbotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:auto-learn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proses antrean pertanyaan pengunjung tak dikenal secara otomatis (Spam cleanup & Auto-association)';

    /**
     * Execute the console command.
     */
    public function handle(ChatbotAutoLearningService $autoLearningService)
    {
        $this->info('Memulai pemrosesan otomatis Learning Queue Tanya Kakak Fikri...');

        $stats = $autoLearningService->processPendingQueries();

        $this->info("Total pertanyaan diproses: {$stats['total']}");
        $this->line("• Spam/teks acak dibersihkan : {$stats['spam_cleaned']}");
        $this->line("• Otomatis dipetakan ke KB    : {$stats['auto_mapped']}");
        $this->line("• Menunggu tindakan admin    : {$stats['skipped']}");

        $this->info('Pemrosesan otomatis selesai!');

        return Command::SUCCESS;
    }
}
