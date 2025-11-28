<?php

namespace App\Livewire\Internships\Forms;

use App\Models\Internship;
use App\Models\InternshipsPostStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InternshipForm extends Form
{
    #[Validate]
    public string $job_title = '';
    #[Validate]
    public string $company = '';
    #[Validate]
    public $company_logo = null;
    public ?string $existing_company_logo = null;
    #[Validate]
    public string $location = '';
    #[Validate]
    public string $job_description = '';
    #[Validate]
    public string $requirements = '';
    #[Validate]
    public string $benefits = '';
    #[Validate]
    public string $contact_email = '';
    #[Validate]
    public string $contact_phone = '';
    #[Validate]
    public string $contact_name = '';
    #[Validate]
    public string $end_date = '';
    #[Validate]
    public $vocational_major_id = '';

    public function rules(): array
    {
        return [
            'job_title' => 'required|string|min:2|max:255',
            'company' => 'required|string|min:3|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'location' => 'required|string|min:6|max:255',
            'job_description' => 'required|string|min:32|max:2000',
            'requirements' => 'required|string|min:32|max:2000',
            'benefits' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255|email:dns',
            'contact_phone' => 'required|regex:/^(?=(?:.*\d){8,20}$)\+?[0-9\s().-]+$/|min:8|max:20|string',
            'contact_name' => 'required|string|min:3|max:64',
            'end_date' => 'required|date',
            'vocational_major_id' => 'required|exists:vocational_majors,id|numeric',
        ];
    }

    public function store()
    {
        $this->sanitizeInputs();
        $this->validate();

        $logoPath = null;
        if ($this->company_logo) {
            $logoPath = $this->company_logo->store('company-logos', 'public');
        }

        Internship::create([
            'job_title' => $this->job_title,
            'company' => $this->company,
            'company_logo' => $logoPath,
            'location' => $this->location,
            'job_description' => $this->job_description,
            'requirements' => $this->requirements,
            'benefits' => $this->benefits,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->normalizePhone($this->contact_phone),
            'contact_name' => $this->contact_name,
            'end_date' => $this->end_date,
            'author_id' => Auth::id(),
            'vocational_major_id' => $this->vocational_major_id,
        ]);
        $this->reset();
    }
    public function update(string $internshipId): void
    {
        $this->sanitizeInputs();
        $this->validate();

        $internship = Internship::query()
            ->whereKey($internshipId)
            ->firstOrFail();

        if ($internship->author_id !== Auth::id()) {
            throw ValidationException::withMessages([
                'authorization' => 'You are not authorized to update this post.',
            ]);
        }

        $bannedId = InternshipsPostStatus::query()
            ->whereRaw('LOWER(status) = ?', ['banned'])
            ->value('id');
        $pendingId = InternshipsPostStatus::query()
            ->whereRaw('LOWER(status) = ?', ['pending'])
            ->value('id');

        if ($bannedId && (string)$internship->status_id === (string)$bannedId) {
            throw ValidationException::withMessages([
                'status' => 'This post is banned and cannot be edited.',
            ]);
        }

        $logoPath = $internship->company_logo;
        if ($this->company_logo) {
            if ($internship->company_logo) {
                Storage::disk('public')->delete($internship->company_logo);
            }
            $logoPath = $this->company_logo->store('company-logos', 'public');
        }

        $internship->fill([
            'job_title' => $this->job_title,
            'company' => $this->company,
            'company_logo' => $logoPath,
            'location' => $this->location,
            'job_description' => $this->job_description,
            'requirements' => $this->requirements,
            'benefits' => $this->benefits,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->normalizePhone($this->contact_phone),
            'contact_name' => $this->contact_name,
            'end_date' => $this->end_date,
            'vocational_major_id' => $this->vocational_major_id,
        ]);

        if ($pendingId) {
            $internship->status_id = $pendingId;
        }

        $internship->save();
    }

    private function normalizePhone(string $raw): string
    {
        $s = trim($raw);
        $s = str_replace([' ', '(', ')', '-', '.'], '', $s);

        if (str_starts_with($s, '+62')) {
            $rest = substr($s, 3);
            if (str_starts_with($rest, '0')) {
                $rest = substr($rest, 1);
            }
            return '+62' . $rest;
        }

        if (str_starts_with($s, '62')) {
            $rest = substr($s, 2);
            if (str_starts_with($rest, '0')) {
                $rest = substr($rest, 1);
            }
            return '+62' . $rest;
        }

        if (str_starts_with($s, '08')) {
            return '+62' . substr($s, 1);
        }

        if (str_starts_with($s, '8')) {
            return '+62' . $s;
        }

        return $s;
    }

    private function sanitizeInputs(): void
    {
        foreach (['job_title', 'company', 'location', 'contact_name'] as $key) {
            if (isset($this->{$key}) && is_string($this->{$key})) {
                $value = trim($this->{$key});
                $value = preg_replace('/[ \t\x{00A0}]{2,}/u', ' ', $value);
                $this->{$key} = $value;
            }
        }

        foreach (['job_description', 'requirements', 'benefits'] as $key) {
            if (isset($this->{$key}) && is_string($this->{$key})) {
                $this->{$key} = trim($this->{$key});
            }
        }

        if (isset($this->contact_email) && is_string($this->contact_email)) {
            $this->contact_email = trim($this->contact_email);
        }

        if (isset($this->contact_phone) && is_string($this->contact_phone)) {
            $this->contact_phone = trim($this->contact_phone);
        }

        if (isset($this->end_date) && is_string($this->end_date)) {
            $this->end_date = trim($this->end_date);
        }
    }
}
