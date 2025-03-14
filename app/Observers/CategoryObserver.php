<?php

namespace App\Observers;

use App\Models\Category;
use Filament\Notifications\Notification;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        Notification::make()
            ->title('You have a new category: '. $category->priority)
            ->send()
            ->sendToDatabase($category);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        Notification::make()
            ->title('You have a update category: '. $category->priority)
            ->send()
            ->sendToDatabase($category);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
