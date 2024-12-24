<?php
namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Support\Enums\IconPosition;

class Settings extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'hugeicons-settings-05';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $navigationGroup = 'Systems';

    protected static ?int $navigationSort = 100;

    public array $data;

    public function mount(): void
    {
        $this->data['site_name'] = '12345';
        $this->data['contact_email'] = '13123';
        $this->data['site_description'] = 'dfgdfg';
    }

    protected function getSettingValue(string $optionName): string
    {
        $setting = Setting::where('option_name', $optionName)->first();
        return $setting ? $setting->option_value : '';
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema($this->getFormSchema());
    }

    // Form schema for settings page
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('Tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('General')
                        ->icon('heroicon-m-bell')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            Forms\Components\TextInput::make('site_name')
                                ->label('Site Name')
                                ->default($this->data['site_name'])
                                ->required()
                                ->maxLength(255),
                        ]),

                    Forms\Components\Tabs\Tab::make('Label 1')
                        ->schema([
                            Forms\Components\TextInput::make('contact_email')
                                ->label('Contact Email')
                                ->default($this->data['contact_email'])
                                ->required()
                                ->email(),
                        ]),

                    Forms\Components\Tabs\Tab::make('Label 2')
                        ->schema([
                            Forms\Components\TextInput::make('site_description')
                                ->label('Site Description')
                                ->default($this->data['site_description'])
                                ->required()
                                ->maxLength(500),
                        ])
                ]),
        ];
    }


    public function saveSettings(): void
    {
        $this->saveSetting('site_name', $this->data['site_name']);
        $this->saveSetting('contact_email', $this->data['contact_email']);
        $this->saveSetting('site_description', $this->data['site_description']);

    }

    protected function saveSetting(string $optionName, string $optionValue): void
    {
        Setting::updateOrCreate(
            ['setting_key' => $optionName],
            ['setting_value' => $optionValue]
        );
    }
}
