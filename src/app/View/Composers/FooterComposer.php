<?php

namespace App\View\Composers;
 
use App\Repositories\UserRepository;
use Illuminate\View\View;
 
class FooterComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('year', date("Y"));
    }
}