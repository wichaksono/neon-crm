<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Transaction extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.transaction';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 120;

    protected ?string $heading = 'Transactions';
}
