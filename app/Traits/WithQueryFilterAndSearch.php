<?php

namespace App\Traits;

use Livewire\Attributes\Url;

trait WithQueryFilterAndSearch
{
    #[Url(as: 'q', except: '')]
    public string $searchQuery = '';

    #[Url(as: 'majors', except: [])]
    public array $selectedMajor = [];

    #[Url(as: 'sort', except: '')]
    public string $sortBy = '';

    public string $draftSearchQuery = '';
    public array $draftSelectedMajor = [];
    public string $draftSortBy = '';

    public function initDraftFiltersFromUrl(): void
    {
        $this->draftSearchQuery = $this->searchQuery;
        $this->draftSelectedMajor = $this->selectedMajor;
        $this->draftSortBy = $this->sortBy;
    }

    protected function applyDraftsToUrlState(): void
    {
        $this->searchQuery = $this->draftSearchQuery;
        $this->selectedMajor = $this->draftSelectedMajor;
        $this->sortBy = $this->draftSortBy;

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function searchPost(): void
    {
        $this->applyDraftsToUrlState();
    }

    public function applyFilters(): void
    {
        $this->applyDraftsToUrlState();
    }

    public function clearFilters(): void
    {
        $this->searchQuery = '';
        $this->selectedMajor = [];
        $this->sortBy = '';

        $this->draftSearchQuery = '';
        $this->draftSelectedMajor = [];
        $this->draftSortBy = '';

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }
}
