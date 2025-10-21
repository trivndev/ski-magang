<?php

namespace App\Livewire\Internships\Forms;

use App\Models\Internship;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InternshipForm extends Form
{
    #[Validate]
    public string $job_title = '';
    #[Validate]
    public string $company = '';
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
            'location' => 'required|string|min:6|max:255',
            'job_description' => 'required|string|min:32|max:255',
            'requirements' => 'required|string|min:32|max:255',
            'benefits' => 'string|max:255',
            'contact_email' => 'email|max:255|email:dns',
            'contact_phone' => 'required|regex:/^[0-9+\s-]+$/|min:8|max:20|string',
            'contact_name' => 'required|string|min:3|max:64',
            'end_date' => 'required|date',
            'vocational_major_id' => 'required|exists:vocational_majors,id|numeric',
        ];
    }

    public function store()
    {
        $this->validate();

        Internship::create([
            'job_title' => $this->job_title,
            'company' => $this->company,
            'location' => $this->location,
            'job_description' => $this->job_description,
            'requirements' => $this->requirements,
            'benefits' => $this->benefits,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'contact_name' => $this->contact_name,
            'end_date' => $this->end_date,
            'author_id' => Auth::id(),
            'vocational_major_id' => $this->vocational_major_id,
        ]);
        $this->reset();
    }

}
