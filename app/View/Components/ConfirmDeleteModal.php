<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmDeleteModal extends Component
{
    /**
     * Create a new component instance.
     */

    public string $modalId;
    public string $action;

    public function __construct(string $modalId, string $action)
    {
        $this->modalId = $modalId;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.confirm-delete-modal');
    }
}
