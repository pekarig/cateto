<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\ContentBlock;
use App\Models\AiToolItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AiToolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AI jövő oldal megkeresése
        $aiJovoPage = Page::where('slug', 'ai-jovo')->first();

        if (!$aiJovoPage) {
            $this->command->error('❌ AI jövő oldal nem található (slug: ai-jovo)');
            return;
        }

        // Content Block létrehozása az 'ai_tools' kulccsal
        ContentBlock::updateOrCreate(
            [
                'page_id' => $aiJovoPage->id,
                'key' => 'ai_tools'
            ],
            [
                'sort_order' => 2, // hero után
                'type' => 'custom',
                'content' => '<!-- AI Tools Grid: Dinamikus tartalom az admin felületről -->',
            ]
        );

        $this->command->info('✅ AI Tools content block létrehozva');

        // Storage könyvtár létrehozása, ha még nem létezik
        $storageIconsPath = storage_path('app/public/ai-icons');
        if (!File::exists($storageIconsPath)) {
            File::makeDirectory($storageIconsPath, 0755, true);
            $this->command->info('✅ storage/app/public/ai-icons könyvtár létrehozva');
        }

        // AI tool adatok
        $aiTools = [
            [
                'icon' => 'openai.svg',
                'name' => 'OpenAI',
                'description' => '<p>ChatGPT, GPT-4/5, API-k</p>',
                'button_text' => 'Megnyitás',
                'button_url' => 'https://chatgpt.com/',
                'button_target_blank' => true,
                'sort_order' => 1,
            ],
            [
                'icon' => 'anthropic.svg',
                'name' => 'Anthropic',
                'description' => '<p>Claude, Claude Pro, API-k</p>',
                'button_text' => 'Megnyitás',
                'button_url' => 'https://www.anthropic.com/',
                'button_target_blank' => true,
                'sort_order' => 2,
            ],
            [
                'icon' => 'gemini.svg',
                'name' => 'Gemini',
                'description' => '<p>Gemini 1.5, Pro, Nano</p>',
                'button_text' => 'Megnyitás',
                'button_url' => 'https://www.gemini.com/',
                'button_target_blank' => true,
                'sort_order' => 3,
            ],
            [
                'icon' => 'ollama.svg',
                'name' => 'Ollama',
                'description' => '<p>Lokális LLM-ek</p>',
                'button_text' => 'Megnyitás',
                'button_url' => 'https://ollama.com/',
                'button_target_blank' => true,
                'sort_order' => 4,
            ],
            [
                'icon' => 'copilot.svg',
                'name' => 'Copilot',
                'description' => '<p>AI asszisztens</p>',
                'button_text' => 'Megnyitás',
                'button_url' => 'https://copilot.com/',
                'button_target_blank' => true,
                'sort_order' => 5,
            ],
            [
                'icon' => 'perplexity.svg',
                'name' => 'Perplexity',
                'description' => '<p>Mélyreható betekintés</p>',
                'button_text' => 'Megnyitás',
                'button_url' => 'https://perplexity.ai/',
                'button_target_blank' => true,
                'sort_order' => 6,
            ],
        ];

        // AI tools seed-elése
        foreach ($aiTools as $toolData) {
            $iconFileName = $toolData['icon'];
            $sourceIconPath = public_path('images/logos/' . $iconFileName);
            $destIconPath = $storageIconsPath . '/' . $iconFileName;

            // Ikon másolása a public/images/logos/-ból a storage/app/public/ai-icons/-ba
            if (File::exists($sourceIconPath)) {
                File::copy($sourceIconPath, $destIconPath);
                $this->command->info("✅ Ikon másolva: {$iconFileName}");
            } else {
                $this->command->warn("⚠️ Ikon nem található: {$sourceIconPath}");
            }

            // AI tool item létrehozása vagy frissítése
            AiToolItem::updateOrCreate(
                [
                    'page_id' => $aiJovoPage->id,
                    'name' => $toolData['name'],
                ],
                [
                    'icon_path' => 'ai-icons/' . $iconFileName,
                    'description' => $toolData['description'],
                    'button_text' => $toolData['button_text'],
                    'button_url' => $toolData['button_url'],
                    'button_target_blank' => $toolData['button_target_blank'],
                    'sort_order' => $toolData['sort_order'],
                ]
            );

            $this->command->info("✅ AI tool létrehozva: {$toolData['name']}");
        }

        $this->command->line('');
        $this->command->info('🎉 AI Tools seeder sikeresen lefutott!');
        $this->command->info('➡️ Admin: /admin/ai-tool-items');
        $this->command->info('➡️ Frontend: /ai-jovo');
    }
}
