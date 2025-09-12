<?php

namespace App\Livewire\ProgramChecks;

use App\Models\ProgramItem;
use App\Models\ProgramCheck;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Collection;

class Index extends Component
{
    public ?string $selectedCategory = null;
    public Collection $items;
    public Collection $categories;

    public function boot()
    {
        $this->items = new Collection();
        $this->categories = new Collection();
    }

    public function mount()
    {
        $this->loadData();
    }

    private function loadData(): void
    {
        $query = ProgramItem::query()
            ->with(['checks' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);

        if ($this->selectedCategory) {
            $query->where('category', $this->selectedCategory);
        }

        $this->items = $query->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy('category');

        $this->categories = ProgramItem::query()
            ->select('category')
            ->distinct()
            ->pluck('category');
    }

    public function selectCategory(?string $category = null): void
    {
        $this->selectedCategory = $category;
        $this->loadData();
    }

    public function toggleCheck(int $itemId): void
    {
        $check = ProgramCheck::where('user_id', Auth::id())
            ->where('program_item_id', $itemId)
            ->first();

        if ($check) {
            $check->checked_at = $check->checked_at ? null : now();
            $check->save();
        } else {
            ProgramCheck::create([
                'user_id' => Auth::id(),
                'program_item_id' => $itemId,
                'checked_at' => now(),
            ]);
        }

        $this->loadData();
    }

    public function getProgressStats($items): array
    {
        $total = $items->count();
        $completed = $items->filter(function ($item) {
            return $item->checks->first()?->checked_at !== null;
        })->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'percentage' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
        ];
    }

    public function render()
    {
        return view('livewire.program-checks.index')
            ->layout('layouts.app');
    }
}
