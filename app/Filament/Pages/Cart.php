<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Cart extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.cart';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 110;
}
