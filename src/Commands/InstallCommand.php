<?php

namespace Emuniq\FilamentScrollableTopnav\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'scrollable-topnav:install';
    protected $description = 'Install Filament Scrollable Topnav plugin into your theme';

    public function handle()
    {
        $this->info('Installing Filament Scrollable Topnav...');

        $themeFiles = $this->findThemeFiles();

        if (empty($themeFiles)) {
            $this->comment('No Filament theme found. Plugin will work with default inline CSS.');
            $this->comment('For zero-flash experience, create a theme with: php artisan make:filament-theme');

            return 0;
        }

        foreach ($themeFiles as $themeFile) {
            $content = File::get($themeFile);

            if (str_contains($content, 'filament-scrollable-topnav/resources/css/plugin.css')) {
                $this->comment("Already installed in: {$themeFile}");

                continue;
            }

            $importLine = "@import '" . $this->buildImportPath($themeFile) . "';";

            $lines = explode("\n", $content);
            $insertIndex = 0;

            foreach ($lines as $index => $line) {
                if (str_starts_with(trim($line), '@import')) {
                    $insertIndex = $index + 1;
                }
            }

            array_splice($lines, $insertIndex, 0, $importLine);
            $newContent = implode("\n", $lines);

            File::put($themeFile, $newContent);
            $this->info("Added to: {$themeFile}");
        }

        $this->newLine();
        $this->warn('Remember to rebuild your assets:');
        $this->line('  npm run build');
        $this->newLine();
        $this->info('Installation complete!');

        return 0;
    }

    protected function findThemeFiles(): array
    {
        $files = [];
        $resourcePath = resource_path('css/filament');

        if (! File::isDirectory($resourcePath)) {
            return $files;
        }

        $panelDirs = File::directories($resourcePath);

        foreach ($panelDirs as $panelDir) {
            $themeFile = $panelDir . '/theme.css';
            if (File::exists($themeFile)) {
                $files[] = $themeFile;
            }
        }

        return $files;
    }

    protected function buildImportPath(string $themeFile): string
    {
        $target = base_path('vendor/emuniq/filament-scrollable-topnav/resources/css/plugin.css');
        $from = dirname($themeFile);

        $fromParts = explode('/', trim($from, '/'));
        $toParts = explode('/', trim($target, '/'));

        $common = 0;
        $max = min(count($fromParts), count($toParts));
        while ($common < $max && $fromParts[$common] === $toParts[$common]) {
            $common++;
        }

        $up = str_repeat('../', count($fromParts) - $common);
        $down = implode('/', array_slice($toParts, $common));

        return $up . $down;
    }
}
