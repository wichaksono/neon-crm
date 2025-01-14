<?php

namespace App\Filament\Pages;

use App\Models\Product;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

use function stat;

class ProductToBuy extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.product-to-buy';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Products';

    protected static ?int $navigationSort = 100;

    protected ?string $heading = 'Products';

    public Collection $products;

    public static function getBreadcrumb(): string
    {
        return 'Products';
    }

    public function getBreadcrumbs(): array
    {
        return [
            '/' => 'Dashboard',
            '' => static::getBreadcrumb(),
        ];
    }

    public function mount(): void
    {
        $this->products = Product::all();
    }

    public function addToCart($productId): void
    {
        $this->mount(); // Refresh data

        Notification::make()
            ->title('Saved successfully')
            ->body('Product has been added to cart!')
            ->success()
            ->send();

    }
}
