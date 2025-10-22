<?php

namespace App\Traits;

/**
 * Helper trait to dispatch toast notifications to the global Alpine listener.
 *
 * Usage within a Livewire component:
 * - use WithNotify;
 * - $this->notifySuccess('Title', 'Message');
 * - $this->notifyInfo('Title', 'Message');
 * - $this->notifyWarning('Title', 'Message');
 * - $this->notifyDanger('Title', 'Message');
 * - $this->notifyMessage(sender: ['name' => 'John', 'avatar' => '...'], message: 'Hi there');
 */
trait WithNotify
{
    /**
     * Base helper to dispatch the notify event with named arguments
     * so Alpine receives a flat detail object: { variant, title, message, sender }
     */
    protected function notifyDispatch(string $variant, ?string $title = null, ?string $message = null, ?array $sender = null): void
    {
        // Livewire v3 DOM event dispatch with named arguments
        $this->dispatch(
            'notify',
            variant: $variant,
            title: $title,
            message: $message,
            sender: $sender,
        );
    }

    protected function notifySuccess(?string $title = null, ?string $message = null): void
    {
        $this->notifyDispatch('success', $title, $message);
    }

    protected function notifyInfo(?string $title = null, ?string $message = null): void
    {
        $this->notifyDispatch('info', $title, $message);
    }

    protected function notifyWarning(?string $title = null, ?string $message = null): void
    {
        $this->notifyDispatch('warning', $title, $message);
    }

    protected function notifyDanger(?string $title = null, ?string $message = null): void
    {
        $this->notifyDispatch('danger', $title, $message);
    }

    /**
     * Special variant that supports sender payload for the "message" style toast.
     * Example sender payload: ['name' => 'Jane', 'avatar' => 'https://...']
     */
    protected function notifyMessage(array $sender, ?string $message = null, ?string $title = null): void
    {
        $this->notifyDispatch('message', $title, $message, $sender);
    }
}
