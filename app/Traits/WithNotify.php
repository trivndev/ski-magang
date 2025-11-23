<?php

namespace App\Traits;

trait WithNotify
{
    protected function notifyDispatch(string $variant, ?string $title = null, ?string $message = null, ?array $sender = null): void
    {
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

    protected function notifyError(?string $title = null, ?string $message = null): void
    {
        $this->notifyDispatch('error', $title, $message);
    }

    protected function notifyMessage(array $sender, ?string $message = null, ?string $title = null): void
    {
        $this->notifyDispatch('message', $title, $message, $sender);
    }
}
